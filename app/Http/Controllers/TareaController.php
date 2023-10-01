<?php

namespace App\Http\Controllers;
use App\Models\Tarea;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public $parControl=[
        'modulo'=>'seguridad',
        'funcionalidad'=>'tareas',
        'titulo' =>'Tareas',
    ];

    public function index(Request $request)
    {
        $tarea = new Tarea();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $tarea->obtenerTareas($buscar,$pagina);
        $mergeData = ['tareas'=>$resultado['tareas'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('tareas.index',$mergeData);
    }
    public function mostrar($id)
    {
        $tarea = Tarea::find($id);
        $mergeData = ['id'=>$id,'tarea'=>$tarea,'parControl'=>$this->parControl];
        return view('tareas.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $mergeData = ['parControl'=>$this->parControl];
        return view('tareas.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'activo'=>'required',
        ]);

        $tarea = new Tarea();
        $tarea->nombre = $request->nombre;
        $tarea->activo = $request->activo?true:false;
        $tarea->save();

        return redirect()->route('tareas.mostrar',$tarea->id);
    }

    public function modificar($id)
    {
        $tarea = Tarea::find($id);
        $mergeData = ['id'=>$id,'tarea'=>$tarea,'parControl'=>$this->parControl];
        return view('tareas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Tarea $tarea)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'activo'=>'required',
        ]);
        $tarea->nombre = $request->nombre;
        $tarea->activo = $request->activo?true:false;
        $tarea->save();

        return redirect()->route('tareas.mostrar',$tarea->id);
    }

    public function eliminar($id)
    {
        $tarea = Tarea::find($id);
        $tarea->eliminado=true;
        $tarea->save();
        return redirect()->route('tareas.index');
    }
}
