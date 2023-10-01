<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//
class DescuentoController extends Controller
{
    public $parControl=[
        'modulo'=>'planilla',
        'funcionalidad'=>'descuentos',
        'titulo' =>'Descuentos',
    ];

    public function index(Request $request)
    {
        $descuento = new Descuento();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $descuento->obtenerDescuentos($buscar,$pagina);
        $mergeData = ['descuentos'=>$resultado['descuentos'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('descuentos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $descuento = Descuento::find($id);
        $persona = new Persona();
        $empleado = $persona->getNombreCompleto($descuento->empleado_id);
        $mergeData = ['id'=>$id,'descuento'=>$descuento,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('descuentos.mostrar',$mergeData);
    }

    public function agregar()
    {
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('descuentos.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'empleado_id'=>'required|max:30',
            'monto'=>'required|max:30',
            'motivo'=>'required|max:100',
            'fecha'=>'required',
            'observacion'=>'required|max:250',
            'activo'=>'required',
        ]);

        $descuento = new Descuento();
        $descuento->empleado_id = $request->empleado_id;
        $descuento->monto = $request->monto;
        $descuento->motivo = $request->motivo;
        $descuento->fecha = $request->fecha;
        $descuento->observacion = $request->observacion;
        $descuento->activo = true;
        $descuento->eliminado = false;
        $descuento->save();

        return redirect()->route('descuentos.mostrar',$descuento->id);
    }

    public function modificar($id)
    {
        $empleado = new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $descuento = Descuento::find($id);
        $mergeData = ['id'=>$id,'descuento'=>$descuento,'parControl'=>$this->parControl];
        return view('descuentos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Descuento $descuento)
    {
        $request->validate([
            'monto'=>'required|max:30',
            'motivo'=>'required|max:100',
            'fecha'=>'required',
            'observacion'=>'required|max:250',
            'empleado_id'=>'requiered',
            'activo'=>'required',
        ]);

        $descuento->monto = $request->monto;
        $descuento->motivo = $request->motivo;
        $descuento->fecha = $request->fecha;
        $descuento->observacion = $request->observacion;
        $descuento->empleado_id = $request->empleado_id;
        $descuento->activo = $request->activo?true:false;
        $descuento->save();

        return redirect()->route('descuentos.mostrar',$descuento->id);
    }

    public function eliminar($id)
    {
        $descuento = Descuento::find($id);
        $descuento->eliminado=true;
        $descuento->save();
        return redirect()->route('descuentos.index');
    }
}
