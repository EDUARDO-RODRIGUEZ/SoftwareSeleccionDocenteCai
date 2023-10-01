<?php
//eddyamnia

namespace App\Http\Controllers;

use App\Models\TipoEmpleado;
use App\Libs\Funciones;
use Illuminate\Http\Request;
//hecho por will
class TipoEmpleadoController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'tipos_empleados',
        'titulo' =>'Tipos de Empleados',
    ];

    public function index(Request $request)
    {
        $tipoEmpleado = new TipoEmpleado();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $tipoEmpleado->obtenerTipoEmpleados($buscar,$pagina);
        $mergeData = [
        'tipos_empleados'=>$resultado['tipos_empleados'],
        'total'=>$resultado['total'],
        'buscar'=>$buscar,
        'parPaginacion'=>$resultado['parPaginacion'],
        'parControl'=>$this->parControl];
        return view('tipos_empleados.index',$mergeData);
    }
    public function mostrar($id)
    {
        $tipoEmpleado = TipoEmpleado::find($id);
        $mergeData = ['id'=>$id,'tipo_empleado'=>$tipoEmpleado,'parControl'=>$this->parControl];
        return view('tipos_empleados.mostrar',$mergeData);
    }

    public function agregar()
    {   
        $mergeData = ['parControl'=>$this->parControl];
        return view('tipos_empleados.agregar',$mergeData);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'activo'=>'required',
        ]);

        $tipoEmpleado = new TipoEmpleado();
        $tipoEmpleado->nombre = $request->nombre;
        $tipoEmpleado->activo = $request->activo?true:false;
        $tipoEmpleado->save();

        return redirect()->route('tipos_empleados.mostrar',$tipoEmpleado->id);
    }

    public function modificar($id)
    {
        $tipoEmpleado = TipoEmpleado::find($id);
        $mergeData = ['id'=>$id,'tipo_empleado'=>$tipoEmpleado,'parControl'=>$this->parControl];
        return view('tipos_empleados.modificar',$mergeData);
    }

    public function actualizar(Request $request, TipoEmpleado $tipoEmpleado)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'activo'=>'required',
        ]);
        $tipoEmpleado->nombre = $request->nombre;
        $tipoEmpleado->activo = $request->activo?true:false;
        $tipoEmpleado->save();

        return redirect()->route('tipos_empleados.mostrar',$tipoEmpleado->id);
    }

    public function eliminar($id)
    {
        $tipoEmpleado = TipoEmpleado::find($id);
        $tipoEmpleado->eliminado=true;
        $tipoEmpleado->save();
        return redirect()->route('tipos_empleados.index');
    }
}
