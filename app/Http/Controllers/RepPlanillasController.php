<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gestion;
use App\Models\Periodo;
use App\Models\Empleado;
class RepPlanillasController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_planillas',
        'titulo' =>'Rep. Planillas',
    ];

    public function index(Request $request)
    {
        $periodo_id = $request->periodo_id;
        $periodo= new Periodo();
        $periodos = $periodo->obtenerPeriodosActivos();

        $resultados=null;
        if( $periodo_id >0){
            $empleado = new Empleado();
            $sql = "select bo.id, c.id as contrato_id,c.empleado_id ,p.nombres, p.primer_apellido ,p.segundo_apellido ,p.ci,p.ci_exp 
                ,bo.haber_basico,bo.bono, bo.descuento,bo.anticipo,bo.liquido_pagable 
                ,car.nombre as cargo, concat(ge.nombre,'-',pe.nombre) as periodo, bo.anulado, bo.created_at, bo.pagado, bo.fecha_pago
                from boletas bo 
                inner join contratos c on bo.contrato_id=c.id 
                inner join empleados e on e.id=c.empleado_id 
                inner join personas p on e.id=p.id
                inner join periodos pe on pe.id=bo.periodo_id
                inner join gestiones ge on ge.id=pe.gestion_id 
                inner join cargos car on  car.id=c.cargo_id
                where bo.anulado=0 and c.eliminado = 0 and bo.pagado=1 and bo.periodo_id=$periodo_id
            ";
            $resultados=  DB::select($sql);;
        }

        $mergeData = [
            'periodos'=>$periodos,
            'periodo_id'=>$periodo_id,
            'resultados'=>$resultados,
            'parControl'=>$this->parControl
        ];
        return view('RepPlanillas.index',$mergeData);
    }

}
