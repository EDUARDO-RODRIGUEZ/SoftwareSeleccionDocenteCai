<?php

namespace App\Http\Controllers;
use App\Models\Pregunta;
use App\Models\Plantilla;
use App\Models\Cargo;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    public $parControl=[
        'modulo'=>'seleccion',
        'funcionalidad'=>'plantillas',
        'titulo' =>'Plantillas',
    ];

    public function index(Request $request)
    {
        $plantilla = new Plantilla();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $plantilla->obtenerPlantillas($buscar,$pagina);
        $mergeData = [
            'plantillas'=>$resultado['plantillas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('plantillas.index',$mergeData);
    }
    public function mostrar($id)
    {
        $plantilla = Plantilla::getPlantilla($id);
        $mergeData = ['id'=>$id,'plantilla'=>$plantilla,'parControl'=>$this->parControl];
        return view('plantillas.mostrar',$mergeData);
    }

    public function agregar()
    {
        $plantilla = new Plantilla();
        $cargo = new Cargo();
        $cargos = $cargo->obtenerCargosActivos();

        $mergeData = ['parControl'=>$this->parControl,'cargos'=>$cargos];
        return view('plantillas.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'tipo_enum'=>'required',
            'cargo_id'=>'required',
            'activo'=>'required',
        ]);

        $plantilla = new Plantilla();
        $plantilla->nombre = $request->nombre;
        $plantilla->tipo_enum = $request->tipo_enum;
        $plantilla->cargo_id = $request->cargo_id;
        $plantilla->activo = $request->activo?true:false;
        $plantilla->save();        
        return redirect()->route('plantillas.mostrar',$plantilla->id);
    }

    public function modificar($id)
    {
        $plantilla = Plantilla::find($id);
        $cargo = new Cargo();
        $cargos = $cargo->obtenerCargosActivos();
      
        $mergeData = ['id'=>$id,'plantilla'=>$plantilla,'cargos'=>$cargos,'parControl'=>$this->parControl];
        return view('plantillas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Plantilla $plantilla)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'tipo_enum'=>'required',
            'cargo_id'=>'required',
            'activo'=>'required',
        ]);

        $plantilla->nombre = $request->nombre;
        $plantilla->tipo_enum = $request->tipo_enum;
        $plantilla->cargo_id = $request->cargo_id;
        $plantilla->activo = $request->activo?true:false;
        $plantilla->save();        

        return redirect()->route('plantillas.mostrar',$plantilla->id);
    }

    public function eliminar($id)
    {
        $plantilla = Plantilla::find($id);
        $plantilla->eliminado=true;
        $plantilla->save();
        return redirect()->route('plantillas.index');
    }

    public function editarcontenido($id)
    {
        $pregunta = new Pregunta();
        $preguntas = $pregunta->obtenerPreguntas();  
    }

    
}
