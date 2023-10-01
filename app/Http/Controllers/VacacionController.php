<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class VacacionController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'vacaciones',
        'titulo' =>'Vacaciones',
    ];

    public function index(Request $request)
    {
        $vacaciones = new Vacacion();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $vacaciones->obtenerVacaciones($buscar,$pagina);
        $mergeData = [
            'vacaciones'=>$resultado['vacaciones'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('vacaciones.index',$mergeData);
    }


    public function agregar()
    { 
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('vacaciones.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'fecha_ini'=>'required|max:50',
            'fecha_fin'=>'required|max:20',
            'observacion'=>'required',
            'empleado_id'=>'required',
          
        ]);

        $vacacion = new Vacacion();
        $vacacion->fecha_ini = $request->fecha_ini;
        $vacacion->fecha_fin = $request->fecha_fin;
        $vacacion->observacion = $request->observacion;
        $vacacion->empleado_id = $request->empleado_id;
        $vacacion->activo = $request->activo?true:false;
        $vacacion->save();

        return redirect()->route('vacaciones.mostrar',$vacacion->id);
    }
    public function mostrar($id)
    {
        $vacacion = Vacacion::getVacacion($id);
        $mergeData = ['id'=>$id,'vacacion'=>$vacacion,'parControl'=>$this->parControl];
        return view('vacaciones.mostrar',$mergeData);
    }

    public function modificar($id)
    {
        $vacacion = Vacacion::find($id);
    
        $mergeData = ['id'=>$id,'vacacion'=>$vacacion,'parControl'=>$this->parControl];
        return view('vacaciones.modificar',$mergeData);
    }

    public function actualizar(Request $request, Vacacion $vacacion)
    {
        $request->validate([
            'fecha_ini'=>'required|max:50',
            'fecha_fin'=>'required|max:20',
            'observacion'=>'required',
            
        ]);

        $vacacion->fecha_ini = $request->fecha_ini;
        $vacacion->fecha_fin = $request->fecha_fin;
        $vacacion->observacion = $request->observacion;
        $vacacion->empleado_id = $request->empleado_id;
        $vacacion->activo = $request->activo?true:false;
        $vacacion->save();

        return redirect()->route('vacaciones.mostrar',$vacacion->id);
    }

    public function eliminar($id)
    {
        $vacacion = Vacacion::find($id);
        $vacacion->eliminado=true;
        $vacacion->save();
        return redirect()->route('vacaciones.index');
    }
}
