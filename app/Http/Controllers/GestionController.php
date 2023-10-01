<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public $parControl=[
        'modulo'=>'planilla',
        'funcionalidad'=>'gestiones',
        'titulo' =>'Gestiones',
    ];

    public function index(Request $request)
    {
        $gestion = new Gestion();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $gestion->obtenerGestiones($buscar,$pagina);
        $mergeData = ['gestiones'=>$resultado['gestiones'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('gestiones.index',$mergeData);
    }
    public function mostrar($id)
    {
        $gestion = Gestion::find($id);
        $mergeData = ['id'=>$id,'gestion'=>$gestion,'parControl'=>$this->parControl];
        return view('gestiones.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $mergeData = ['parControl'=>$this->parControl];
        return view('gestiones.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'fecha_ini'=>'required|max:25',
            'fecha_fin'=>'required|max:20',
            'activo'=>'required',
        ]);

        $gestion = new Gestion();
        $gestion->nombre = $request->nombre;
        $gestion->fecha_ini = $request->fecha_ini;
        $gestion->fecha_fin = $request->fecha_fin;
        $gestion->activo = $request->activo?true:false;
        $gestion->save();

        return redirect()->route('gestiones.mostrar',$gestion->id);
    }

    public function modificar($id)
    {
        $gestion = Gestion::find($id);
        $mergeData = ['id'=>$id,'gestion'=>$gestion,'parControl'=>$this->parControl];
        return view('gestiones.modificar',$mergeData);
    }

    public function actualizar(Request $request, Gestion $gestion)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'fecha_ini'=>'required|max:25',
            'fecha_fin'=>'required|max:20',
            'activo'=>'required',
        ]);

        $gestion->nombre = $request->nombre;
        $gestion->fecha_ini = $request->fecha_ini;
        $gestion->fecha_fin = $request->fecha_fin;
        $gestion->activo = $request->activo?true:false;
        $gestion->save();

        return redirect()->route('gestiones.mostrar',$gestion->id);
    }

    public function eliminar($id)
    {
        $gestion = Gestion::find($id);
        $gestion->eliminado=true;
        $gestion->save();
        return redirect()->route('gestiones.index');
    }
}
