<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public $parControl=[
        'modulo'=>'seleccion',
        'funcionalidad'=>'horarios',
        'titulo' =>'Horarios',
    ];

    public function index(Request $request)
    {
        $horarios = new Horario();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $horarios->obtenerHorarios($buscar,$pagina);
        $mergeData = [
            'horarios'=>$resultado['horarios'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('horarios.index',$mergeData);
    }


    public function agregar()
    { 
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('horarios.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'dia'=>'required',
            'hora_ing'=>'required|max:50',
            'hora_sal'=>'required|max:20',
            'empleado_id'=>'required',
          
        ]);

        $horario = new Horario();
        $horario->dia = $request->dia;
        $horario->hora_ing = $request->hora_ing;
        $horario->hora_sal = $request->hora_sal;
        $horario->empleado_id = $request->empleado_id;
        $horario->activo = $request->activo?true:false;
        $horario->save();

        return redirect()->route('horarios.mostrar',$horario->id);
    }
    public function mostrar($id)
    {
        $horario = Horario::getHorario($id);
        $mergeData = ['id'=>$id,'horario'=>$horario,'parControl'=>$this->parControl];
        return view('horarios.mostrar',$mergeData);
    }

    public function modificar($id)
    {
        $horario = Horario::find($id);
    
        $mergeData = ['id'=>$id,'horario'=>$horario,'parControl'=>$this->parControl];
        return view('horarios.modificar',$mergeData);
    }

    public function actualizar(Request $request, Horario $horario)
    {
        $request->validate([
            'dia'=>'required',
            'hora_ing'=>'required|max:50',
            'hora_sal'=>'required|max:20',
        
          
        ]);
        $horario->dia = $request->dia;
        $horario->hora_ing = $request->hora_ing;
        $horario->hora_sal = $request->hora_sal;
  
        $horario->activo = $request->activo?true:false;
        $horario->save();

        return redirect()->route('horarios.mostrar',$horario->id);
    }

    public function eliminar($id)
    {
        $horario = Horario::find($id);
        $horario->eliminado=true;
        $horario->save();
        return redirect()->route('horarios.index');
    }
}
