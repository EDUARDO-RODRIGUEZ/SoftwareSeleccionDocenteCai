<?php

namespace App\Http\Controllers;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//ModuloController
class RespuestaController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'respuestas',
        'titulo' =>'Respuestas',
    ];

    public function index(Request $request)
    {
        $respuesta = new Respuesta();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $respuesta->obtenerRespuestas($buscar,$pagina);
        $mergeData = ['respuestas'=>$resultado['respuestas'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('respuestas.index',$mergeData);
    }
    public function mostrar($id)
    {
        $respuesta = Respuesta::find($id);
        $mergeData = ['id'=>$id,'respuesta'=>$respuesta,'parControl'=>$this->parControl];
        return view('respuestas.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $pregunta = new Pregunta();
        $preguntas = $pregunta->obtenerPreguntasActivas();

        $mergeData = ['parControl'=>$this->parControl,'preguntas'=>$preguntas];
        return view('respuestas.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'orden'=>'required|max:50',
            'respuesta'=>'required',
            'valor'=>'required|max:50',
            'pregunta_id'=>'required',
            'activo'=>'required',
        ]);

        $respuesta = new Respuesta();
        $respuesta->orden = $request->orden;
        $respuesta->respuesta = $request->respuesta;
        $respuesta->valor = $request->valor;
        $respuesta->pregunta_id = $request->pregunta_id;
        $respuesta->activo = $request->activo?true:false;
        $respuesta->save();

        return redirect()->route('respuestas.mostrar',$respuesta->id);
    }

    public function modificar($id)
    {
        $respuesta = Respuesta::find($id);

        $pregunta = new Pregunta();
        $preguntas = $pregunta->obtenerPreguntasActivas();

        $mergeData = ['id'=>$id,'pregunta'=>$respuesta,'preguntas'=>$preguntas,'parControl'=>$this->parControl];
        return view('respuestas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Respuesta $respuesta)
    {
        $request->validate([
            'orden'=>'required|max:50',
            'respuesta'=>'required',
            'valor'=>'required|max:50',
            'pregunta_id'=>'required',
            'activo'=>'required',
        ]);

        $respuesta->orden = $request->orden;
        $respuesta->respuesta = $request->respuesta;
        $respuesta->valor = $request->valor;
        $respuesta->pregunta_id = $request->pregunta_id;
        $respuesta->activo = $request->activo?true:false;
        $respuesta->save();

        return redirect()->route('respuestas.mostrar',$respuesta->id);
    }

    public function eliminar($id)
    {
        $respuesta = Respuesta::find($id);
        $respuesta->eliminado=true;
        $respuesta->save();
        return redirect()->route('respuestas.index');
    }
}
