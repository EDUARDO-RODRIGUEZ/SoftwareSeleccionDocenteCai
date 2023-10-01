<?php

namespace App\Http\Controllers;
use App\Models\Plantilla;
use App\Models\Pregunta;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//ModuloController
class PreguntaController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'preguntas',
        'titulo' =>'Preguntas',
    ];

    public function index(Request $request)
    {
        $pregunta = new Pregunta();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $pregunta->obtenerPreguntas($buscar,$pagina);
        $mergeData = ['preguntas'=>$resultado['preguntas'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('preguntas.index',$mergeData);
    }
    public function mostrar($id)
    {
        $pregunta = Pregunta::find($id);
        $mergeData = ['id'=>$id,'pregunta'=>$pregunta,'parControl'=>$this->parControl];
        return view('preguntas.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $plantilla = new Plantilla();
        $plantillas = $plantilla->obtenerPlantillasActivas();

        $mergeData = ['parControl'=>$this->parControl, 'plantillas'=>$plantillas];
        return view('preguntas.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'orden'=>'required|max:50',
            'pregunta'=>'required',
            'tipo'=>'required|max:50',
            'plantilla_id'=>'required',
            'activo'=>'required',
        ]);

        $pregunta = new Pregunta();
        $pregunta->orden = $request->orden;
        $pregunta->pregunta = $request->pregunta;
        $pregunta->tipo = $request->tipo;
        $pregunta->plantilla_id = $request->plantilla_id;
        $pregunta->activo = $request->activo?true:false;
        $pregunta->save();

        return redirect()->route('preguntas.mostrar',$pregunta->id);
    }

    public function modificar($id)
    {
        $pregunta = Pregunta::find($id);

        $plantilla = new Plantilla();
        $plantilla = $plantilla->obtenerPlantillasActivas();

        $mergeData = ['id'=>$id,'pregunta'=>$pregunta,'plantillas'=>$plantillas,'parControl'=>$this->parControl];
        return view('preguntas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Pregunta $pregunta)
    {
        $request->validate([
            'orden'=>'required|max:50',
            'pregunta'=>'required',
            'tipo'=>'required|max:50',
            'plantilla_id'=>'required',
            'activo'=>'required',
        ]);

        $pregunta->orden = $request->orden;
        $pregunta->pregunta = $request->pregunta;
        $pregunta->tipo = $request->tipo;
        $pregunta->plantilla_id = $request->plantilla_id;
        $pregunta->activo = $request->activo?true:false;
        $pregunta->save();

        return redirect()->route('preguntas.mostrar',$pregunta->id);
    }

    public function eliminar($id)
    {
        $pregunta = Pregunta::find($id);
        $pregunta->eliminado=true;
        $pregunta->save();
        return redirect()->route('preguntas.index');
    }
}
