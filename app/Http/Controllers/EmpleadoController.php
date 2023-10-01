<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Persona;
use App\Models\TipoEmpleado;
use App\Models\Sucursal;
use App\Models\Cargo;
use App\Models\Postulacion;
use App\Models\Convocatoria;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'empleados',
        'titulo' =>'Empleados',
    ];

    public function index(Request $request)
    {
        $empleado = new Empleado();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $empleado->obtenerEmpleados($buscar,$pagina);
        $mergeData = [
            'empleados'=>$resultado['empleados'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('empleados.index',$mergeData);
    }
    
    public function mostrar($id)
    {
        $empleado = Empleado::getEmpleado($id);
        
        $mergeData = ['id'=>$id,'empleado'=>$empleado,'parControl'=>$this->parControl];
        return view('empleados.mostrar',$mergeData);
    }

    public function agregar(Request $request)
    { 
        $postulacion_id=$request->postulacion_id;
        $nombrePersona='';
        $persona_id=0;
        $cargo_id=0;
        if($postulacion_id){
            $postulacion = Postulacion::find($postulacion_id);
            $oPersona = new Persona();
            $nombrePersona = $oPersona->getNombreCompleto($postulacion->postulante_id);
            $convocatoria = Convocatoria::find($postulacion->convocatoria_id);
            $persona_id=$postulacion->postulante_id;
            $cargo_id=$convocatoria->cargo_id;
        }
        

        $tipo_empleado = new  TipoEmpleado();
        $tipos_empleados=$tipo_empleado->obtenerTiposEmpleadosActivos();

        $sucursal = new  Sucursal();
        $sucursales=$sucursal->obtenerSucursalesActivos();
        
        $cargo = new  Cargo();
        $cargos=$cargo->obtenerCargosActivos();

        $mergeData = ['parControl'=>$this->parControl, 'tipos_empleados'=>$tipos_empleados,'sucursales'=>$sucursales,'cargos'=>$cargos,'id'=>$persona_id,'nombreCompleto'=>$nombrePersona,'cargo_id'=>$cargo_id];
        return view('empleados.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
          'id'=>'required',
          'correo_corporativo'=>'required|max:100',
     
          'profesion'=>'required',
          
          'cargo_id'=>'required',
          'sucursal_id'=>'required',
          'activo'=>'required',
        ]);
        $persona = Persona::find($request->id);
        $empleado = new Empleado();
        $empleado->id = $request->id;
        $empleado->correo_corporativo = $request->correo_corporativo;
        $empleado->usuario = $persona->ci ;
        $empleado->pass = md5($persona->ci) ;
        $empleado->profesion = $request->profesion;
        $empleado->perfil_id = 1;
        $empleado->cargo_id = $request->cargo_id;
        $empleado->sucursal_id = $request->sucursal_id;
        $empleado->activo = $request->activo?true:false;
        $empleado->save();

        return redirect()->route('empleados.mostrar',$request->id);
    }

    public function modificar($id)
    {
        $empleado = Empleado::find($id);
        $oPersona = new Persona();
        $nombrePersona = $oPersona->getNombreCompleto($id);

        $tipo_empleado = new  TipoEmpleado();
        $tipos_empleados=$tipo_empleado->obtenerTiposEmpleadosActivos();

        $sucursal = new  Sucursal();
        $sucursales=$sucursal->obtenerSucursalesActivos();
        
        $cargo = new  Cargo();
        $cargos=$cargo->obtenerCargosActivos();

        $mergeData = ['id'=>$id,'empleado'=>$empleado,'nombreCompleto'=>$nombrePersona,'parControl'=>$this->parControl,'tipos_empleados'=>$tipos_empleados,'sucursales'=>$sucursales,'cargos'=>$cargos];

        return view('empleados.modificar',$mergeData);
    }

    public function actualizar(Request $request, Empleado $empleado)
    {
        $request->validate([
        
            'correo_corporativo'=>'required|max:100',
            'profesion'=>'required|max:50',
            'cargo_id'=>'required',
            'sucursal_id'=>'required',
            'activo'=>'required',
          ]);
       
       
          $empleado->correo_corporativo = $request->correo_corporativo;
          $empleado->profesion = $request->profesion;
          $empleado->cargo_id = $request->cargo_id;
          $empleado->sucursal_id = $request->sucursal_id;
          
          $empleado->activo = $request->activo?true:false;
          $empleado->save();


        return redirect()->route('empleados.mostrar',$empleado->id);
    }

    public function eliminar($id)
    {
        $empleado = Empleado::find($id);
        $empleado->eliminado=true;
        $empleado->save();
        return redirect()->route('empleados.index');
    }

    public function personasActivas(Request $request)
    {
        $buscar=$request->q;
        $empleado = new Empleado();
        $personas = $empleado->buscarPersonas($buscar);
        $resultado=[];
        foreach ($personas as $persona){
            $resultado[]=(object)['name'=>$persona->nombre,'id'=>$persona->id];
        }
        return json_encode($resultado);
    }

    public function empleadosActivos(Request $request)
    {
        $buscar=$request->q;
        $empleado = new Empleado();
        $personas = $empleado->BuscarEmpleadosActivos($buscar);
        $resultado=[];
        foreach ($personas as $persona){
            $resultado[]=(object)['name'=>$persona->nombre,'id'=>$persona->id];
        }
        return json_encode($resultado);
    }
}
