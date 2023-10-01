<?php

namespace App\Http\Controllers;

use App\Models\Anticipo;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class AnticipoController extends Controller
{
    public $parControl=[
        'modulo'=>'planilla',
        'funcionalidad'=>'anticipos',
        'titulo' =>'Anticipos',
    ];

    public function index(Request $request)
    {
        $anticipo = new Anticipo();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $anticipo->obtenerAnticipos($buscar,$pagina);

        $mergeData = [
            'anticipos'=>$resultado['anticipos'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];

        return view('anticipos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $anticipo = Anticipo::find($id);
        $persona = new Persona();
        $empleado = $persona->getNombreCompleto($anticipo->empleado_id);
        $mergeData = ['id'=>$id,'anticipo'=>$anticipo,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('anticipos.mostrar',$mergeData);
    }

    public function agregar()
    {
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('anticipos.agregar',$mergeData);
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

        $anticipo = new Anticipo();
        $anticipo->empleado_id = $request->empleado_id;
        $anticipo->monto = $request->monto;
        $anticipo->motivo = $request->motivo;
        $anticipo->fecha = $request->fecha;
        $anticipo->observacion = $request->observacion;
        $anticipo->activo = true;
        $anticipo->eliminado = false;
        $anticipo->save();
        return redirect()->route('anticipos.mostrar',$anticipo->id);
    }

    public function modificar($id)
    {
        $empleado = new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $anticipo = Anticipo::find($id);
        $mergeData = ['id'=>$id,'anticipo'=>$anticipo,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('anticipos.modificar',$mergeData);
    }

    public function actualizar(Request $request, anticipo $anticipo)
    {
        $request->validate([
            'monto'=>'required|max:30',
            'motivo'=>'required|max:100',
            'fecha'=>'required',
            'observacion'=>'required|max:250',
            'empleado_id'=>'requiered',
            'activo'=>'required',
        ]);

        $anticipo->monto = $request->monto;
        $anticipo->motivo = $request->motivo;
        $anticipo->fecha = $request->fecha;
        $anticipo->observacion = $request->observacion;
        $anticipo->empleado_id = $request->empleado_id;
        $anticipo->activo = $request->activo?true:false;
        $anticipo->save();

        return redirect()->route('anticipos.mostrar',$anticipo->id);
    }

    public function eliminar($id)
    {
        $anticipo = Anticipo::find($id);
        $anticipo->eliminado=true;
        $anticipo->activo=false;
        $anticipo->save();
        return redirect()->route('anticipos.index');
    }
}
