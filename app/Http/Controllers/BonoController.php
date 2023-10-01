<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//BonoController
class BonoController extends Controller
{
    public $parControl=[
        'modulo'=>'planilla',
        'funcionalidad'=>'bonos',
        'titulo' =>'Bonos',
    ];

    public function index(Request $request)
    {
        $bono = new Bono();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $bono->obtenerBonos($buscar,$pagina);
        $mergeData = ['bonos'=>$resultado['bonos'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('bonos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $bono = Bono::find($id);
        $persona = new Persona();
        $empleado = $persona->getNombreCompleto($bono->empleado_id);
        $mergeData = ['id'=>$id,'bono'=>$bono,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('bonos.mostrar',$mergeData);
    }

    public function agregar()
    {
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('bonos.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'empleado_id'=>'required|max:30',
            'monto'=>'required|max:30',
            'motivo'=>'required|max:100',
            'fecha'=>'required',
            'observacion'=>'max:250'
        ]);

        $bono = new Bono();
        $bono->empleado_id = $request->empleado_id;
        $bono->monto = $request->monto;
        $bono->motivo = $request->motivo;
        $bono->fecha = $request->fecha;
        $bono->observacion = $request->observacion;
        $bono->activo = true;
        $bono->eliminado = false;
        $bono->save();
        return redirect()->route('bonos.mostrar',$bono->id);
    }

    public function modificar($id)
    {
        $empleado = new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $bono = Bono::find($id);
        $mergeData = ['id'=>$id,'bono'=>$bono,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('bonos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Bono $bono)
    {
        $request->validate([
            'monto'=>'required|max:30',
            'motivo'=>'required|max:100',
            'fecha'=>'required',
            'observacion'=>'required|max:250',
            'empleado_id'=>'requiered',
            'activo'=>'required',
        ]);

        $bono->monto = $request->monto;
        $bono->motivo = $request->motivo;
        $bono->fecha = $request->fecha;
        $bono->observacion = $request->observacion;
        $bono->empleado_id = $request->empleado_id;
        $bono->activo = $request->activo?true:false;
        $bono->save();

        return redirect()->route('bonos.mostrar',$bono->id);
    }

    public function eliminar($id)
    {
        $bono = Bono::find($id);
        $bono->eliminado=true;
        $bono->activo=false;
        $bono->save();
        return redirect()->route('bonos.index');
    }
}
