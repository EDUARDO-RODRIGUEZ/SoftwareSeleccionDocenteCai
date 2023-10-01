<?php

namespace App\Http\Controllers;

use App\Models\BajaMedica;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//BonoController
class BajaMedicaController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'bajasmedicas',
        'titulo' =>'Bajas Medicas',
    ];

    public function index(Request $request)
    {
        $bajamedica = new BajaMedica();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $bajamedica->obtenerBajasMedicas($buscar,$pagina);
        $mergeData = ['bajasmedicas'=>$resultado['bajasmedicas'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('bajasmedicas.index',$mergeData);
    }
    public function mostrar($id)
    {
        $bajamedica = BajaMedica::find($id);
        $persona = new Persona();
        $empleado = $persona->getNombreCompleto($bajamedica->empleado_id);
        $mergeData = ['id'=>$id,'bajamedica'=>$bajamedica,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('bajasmedicas.mostrar',$mergeData);
    }

    public function agregar()
    {
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados];
        return view('bajasmedicas.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'empleado_id'=>'required|max:30',
            'fecha_ini'=>'required|max:30',
            'fecha_fin'=>'required|max:100',
            'observacion'=>'max:250',
            'modalidad'=>'required',
        ]);

        $bajamedica = new BajaMedica();
        $bajamedica->empleado_id = $request->empleado_id;
        $bajamedica->fecha_ini = $request->fecha_ini;
        $bajamedica->fecha_fin = $request->fecha_fin;
        $bajamedica->observacion = $request->observacion;
        $bajamedica->modalidad = $request->modalidad;
        $bajamedica->activo = true;
        $bajamedica->eliminado = false;
        $bajamedica->save();
        return redirect()->route('bajasmedicas.mostrar',$bajamedica->id);
    }

    public function modificar($id)
    {
        $empleado = new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $bajamedica = BajaMedica::find($id);
        $mergeData = ['id'=>$id,'bajamedica'=>$bajamedica,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('bajasmedicas.modificar',$mergeData);
    }

    public function actualizar(Request $request, BajaMedica $bajamedica)
    {
        $request->validate([
            'empleado_id'=>'required|max:30',
            'fecha_ini'=>'required|max:30',
            'fecha_fin'=>'required|max:100',
            'observacion'=>'max:250',
            'modalidad'=>'required',
        ]);

        $bajamedica->empleado_id = $request->empleado_id;
        $bajamedica->fecha_ini = $request->fecha_ini;
        $bajamedica->fecha_fin = $request->fecha_fin;
        $bajamedica->observacion = $request->observacion;
        $bajamedica->modalidad = $request->modalidad;
        $bajamedica->activo = $request->activo?true:false;
        $bajamedica->save();

        return redirect()->route('bajasmedicas.mostrar',$bajamedica->id);
    }

    public function eliminar($id)
    {
        $bono = BajaMedica::find($id);
        $bono->eliminado=true;
        $bono->activo=false;
        $bono->save();
        return redirect()->route('bajasmedicas.index');
    }
}
