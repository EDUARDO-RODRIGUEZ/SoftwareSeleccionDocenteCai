<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Cargo;
use App\Models\TipoEmpleado;
use App\Models\Empleado;
use App\Models\Persona;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//BonoController
class ContratoController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'contratos',
        'titulo' =>'Contratos',
    ];

    public function index(Request $request)
    {
        $contrato = new Contrato();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $contrato->obtenerContratos($buscar,$pagina);
        $mergeData = ['contratos'=>$resultado['contratos'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('contratos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $contrato = Contrato::find($id);
        $persona = new Persona();
    
        $empleado = $persona->getNombreCompleto($contrato->empleado_id);
        $mergeData = ['id'=>$id,'contrato'=>$contrato,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('contratos.mostrar',$mergeData);
    }

    public function agregar()
    {
        $empleado= new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $cargo = new Cargo();
        $cargos = $cargo->obtenerCargosActivos();

        $tipoempleado = new TipoEmpleado();
        $tipoempleados = $tipoempleado->obtenerTiposEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados,'cargos'=>$cargos,'tipoempleados'=>$tipoempleados];
        return view('contratos.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'sueldo_basico'=>'required',
            'fecha_inicio'=>'required',
            'fecha_final'=>'required',
            'empleado_id'=>'required',
            'tipo_empleado_id'=>'required',
            'cargo_id'=>'required',
        ]);

        $contrato = new Contrato();
        $contrato->sueldo_basico = $request->sueldo_basico;
        $contrato->fecha_inicio = $request->fecha_inicio;
        $contrato->fecha_final = $request->fecha_final;
        $contrato->empleado_id = $request->empleado_id;
        $contrato->tipo_empleado_id = $request->tipo_empleado_id;
        $contrato->cargo_id = $request->cargo_id;
        $contrato->activo = true;
        $contrato->eliminado = false;
        $contrato->save();
        return redirect()->route('contratos.mostrar',$contrato->id);
    }

    public function modificar($id)
    {
        $empleado = new Empleado();
        $empleados = $empleado->obtenerEmpleadosActivos();

        $bono = Bono::find($id);
        
        $cargo = new Cargo();
        $cargos = $cargo->obtenerCargosActivos();

        $tipoempleado = new TipoEmpleado();
        $tipoempleados = $tipoempleado->obtenerTiposEmpleadosActivos();

        $mergeData = ['parControl'=>$this->parControl,'empleados'=>$empleados,'cargos'=>$cargos,'tipoempleados'=>$tipoempleados];
        return view('contratos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Contrato $contrato)
    {
        $request->validate([
            'sueldo_basico'=>'required',
            'bono_transporte'=>'required',
            'fecha_inicio'=>'required',
            'fecha_final'=>'required',
            'empleado_id'=>'required',
            'tipo_empleado_id'=>'required',
            'cargo_id'=>'required',
        ]);

        $contrato->sueldo_basico = $request->sueldo_basico;
        $contrato->bono_transporte = $request->bono_transporte;
        $contrato->fecha_inicio = $request->fecha_inicio;
        $contrato->fecha_final = $request->fecha_final;
        $contrato->empleado_id = $request->empleado_id;
        $contrato->tipo_empleado_id = $request->tipo_empleado_id;
        $contrato->cargo_id = $request->cargo_id;
        $bocontratono->activo = true;
        $contrato->eliminado = false;
        $contrato->save();

        return redirect()->route('contratos.mostrar',$contrato->id);
    }

    public function eliminar($id)
    {
        $contrato = Contrato::find($id);
        $contrato->activo=false;
        $contrato->save();
        return redirect()->route('contratos.index');
    }
}
