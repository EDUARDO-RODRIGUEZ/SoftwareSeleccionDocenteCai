<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\Empleado;
class RepEmpleadosController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_empleados',
        'titulo' =>'Rep. Empleados',
    ];

    public function index(Request $request)
    {

        $departamento_id = $request->departamento_id;
        $departamento= new Departamento();
        $departamentos = $departamento->obtenerDepartamentosActivos();
        $resultados=null;
        if($departamento_id >0){
            $empleado = new Empleado();
            $sql = "select e.id, p.primer_apellido, p.segundo_apellido, p.nombres, p.ci, p.ci_exp,
            e.profesion, e.correo_corporativo, c.nombre as cargo, s.nombre as sucursal
            from empleados e
            inner join personas p on p.id=e.id
            inner join cargos c on c.id=e.cargo_id
            inner join departamentos d on d.id=c.departamento_id
            inner join sucursales s on s.id=e.sucursal_id
            where d.id=$departamento_id";
            $resultados=  DB::select($sql);;
        }

        $mergeData = [
            'departamentos'=>$departamentos,
            'departamento_id'=>$departamento_id,
            'resultados'=>$resultados,
            'parControl'=>$this->parControl
        ];
        return view('RepEmpleados.index',$mergeData);
    }

}
