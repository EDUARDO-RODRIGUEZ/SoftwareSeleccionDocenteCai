<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gestion;
use App\Models\Empleado;
class RepBajasMedicasController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_bajas_medicas',
        'titulo' =>'Rep. Bajas Medicas',
    ];

    public function index(Request $request)
    {

        $gestion_id = $request->gestion_id;
        $gestion= new Gestion();
        $gestiones = $gestion->obtenerGestionesActivas();
        $resultados=null;
        if($gestion_id >0){
            $empleado = new Empleado();
            $sql = "";
            $resultados=  DB::select($sql);;
        }

        $mergeData = [
            'gestiones'=>$gestiones,
            'gestion_id'=>$gestion_id,
            'resultados'=>$resultados,
            'parControl'=>$this->parControl
        ];
        return view('RepBajasMedicas.index',$mergeData);
    }

}
