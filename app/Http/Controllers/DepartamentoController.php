<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//ModuloController
class DepartamentoController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'departamentos',
        'titulo' =>'Departamentos',
    ];

    public function index(Request $request)
    {
        $departamento = new Departamento();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $departamento->obtenerDepartamentos($buscar,$pagina);
        $mergeData = ['departamentos'=>$resultado['departamentos'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('departamentos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $departamento = Departamento::find($id);
        $mergeData = ['id'=>$id,'departamento'=>$departamento,'parControl'=>$this->parControl];
        return view('departamentos.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $mergeData = ['parControl'=>$this->parControl];
        return view('departamentos.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'activo'=>'required',
        ]);

        $departamento = new Departamento();
        $departamento->nombre = $request->nombre;
        $departamento->activo = $request->activo?true:false;
        $departamento->save();

        return redirect()->route('departamentos.mostrar',$departamento->id);
    }

    public function modificar($id)
    {
        $departamento = Departamento::find($id);
        $mergeData = ['id'=>$id,'departamento'=>$departamento,'parControl'=>$this->parControl];
        return view('departamentos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'activo'=>'required',
        ]);
        $departamento->nombre = $request->nombre;
        $departamento->activo = $request->activo?true:false;
        $departamento->save();

        return redirect()->route('departamentos.mostrar',$departamento->id);
    }

    public function eliminar($id)
    {
        $departamento = Departamento::find($id);
        $departamento->eliminado=true;
        $departamento->save();
        return redirect()->route('departamentos.index');
    }
}
