<?php

namespace App\Http\Controllers;

use App\Models\Falta;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class FaltaController extends Controller
{
    public $parControl=[
        'modulo'=>'seleccion',
        'funcionalidad'=>'faltas',
        'titulo' =>'Faltas',
    ];

    public function index(Request $request)
    {
        $faltas = new Falta();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $faltas->obtenerFaltas($buscar,$pagina);
        $mergeData = [
            'faltas'=>$resultado['faltas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('faltas.index',$mergeData);
    }


    public function agregar()
    { 
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('faltas.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
        
            'fecha'=>'required|max:50',
            'observación'=>'required|max:250',
            'tipo_falta'=>'required',
            'empleado_id'=>'required',
          
        ]);

        $falta = new Falta();
        $falta->fecha = $request->fecha;
        $falta->observacion = $request->observacion;
        $falta->tipo_falta = $request->tipo_falta;
        $falta->empleado_id = $request->empleado_id;
        $falta->activo = $request->activo?true:false;
        $falta->save();

        return redirect()->route('faltas.mostrar',$falta->id);
    }
    public function mostrar($id)
    {
        $falta = Falta::getFalta($id);
        $mergeData = ['id'=>$id,'falta'=>$falta,'parControl'=>$this->parControl];
        return view('faltas.mostrar',$mergeData);
    }

    public function modificar($id)
    {
        $falta = Falta::find($id);
    
        $mergeData = ['id'=>$id,'falta'=>$falta,'parControl'=>$this->parControl];
        return view('faltas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Falta $falta)
    {
        $request->validate([
            'fecha'=>'required|max:50',
            'observación'=>'required|max:250',
            'tipo_falta'=>'required',
           
            
        ]);

        $falta->fecha = $request->fecha;
        $falta->observacion = $request->observacion;
        $falta->tipo_falta = $request->tipo_falta;
        $falta->activo = $request->activo?true:false;
        $falta->save();

        return redirect()->route('faltas.mostrar',$falta->id);
    }

    public function eliminar($id)
    {
        $falta = Falta::find($id);
        $falta->eliminado=true;
        $falta->save();
        return redirect()->route('faltas.index');
    }
}
