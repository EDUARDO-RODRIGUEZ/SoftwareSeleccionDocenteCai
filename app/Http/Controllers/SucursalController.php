<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//ModuloController
class SucursalController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'sucursales',
        'titulo' =>'Sucursales',
    ];

    public function index(Request $request)
    {
        $sucursal = new Sucursal();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $sucursal->obtenerSucursales($buscar,$pagina);
        $mergeData = ['sucursales'=>$resultado['sucursales'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('sucursales.index',$mergeData);
    }
    public function mostrar($id)
    {
        $sucursal = Sucursal::find($id);
        $mergeData = ['id'=>$id,'sucursal'=>$sucursal,'parControl'=>$this->parControl];
        return view('sucursales.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $mergeData = ['parControl'=>$this->parControl];
        return view('sucursales.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'ubicacion'=>'required|max:200',
            'activo'=>'required',
        ]);

        $sucursal = new Sucursal();
        $sucursal->nombre = $request->nombre;
        $sucursal->ubicacion = $request->ubicacion;
        $sucursal->activo = $request->activo?true:false;
        $sucursal->save();

        return redirect()->route('sucursales.mostrar',$sucursal->id);
    }

    public function modificar($id)
    {
        $sucursal = Sucursal::find($id);
        $mergeData = ['id'=>$id,'sucursal'=>$sucursal,'parControl'=>$this->parControl];
        return view('sucursales.modificar',$mergeData);
    }

    public function actualizar(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre'=>'required|max:50',
            'ubicacion'=>'required|max:200',
            'activo'=>'required',
        ]);
        $sucursal->nombre = $request->nombre;
        $sucursal->ubicacion = $request->ubicacion;
        $sucursal->activo = $request->activo?true:false;
        $sucursal->save();

        return redirect()->route('sucursales.mostrar',$sucursal->id);
    }

    public function eliminar($id)
    {
        $sucursal = Sucursal::find($id);
        $sucursal->eliminado=true;
        $sucursal->save();
        return redirect()->route('sucursales.index');
    }
}
