<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vacacion extends Model
{
    use HasFactory;
    protected $table="vacaciones";

    public function obtenerVacaciones($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio = ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (f.fecha_ini or f.fecha_fin like '%$buscar%' ) ";
        }

        $sql = "select f.*, concat(p.primer_apellido,' ',p.segundo_apellido,' ',p.nombres) as empleado 
        from vacaciones f
        inner join empleados m on m.id =f.empleado_id
        inner join personas p on p.id= m.id
        where f.eliminado =0 $filtro order by f.id desc limit $inicio,$limite";
        $vacaciones = DB::select($sql);

        $sqlTotal = "select count(*) as total from vacaciones f
        inner join empleados m on m.id =f.empleado_id 
        where f.eliminado =0 $filtro ";
        $result = DB::select($sqlTotal); //no tocar
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'vacaciones'=>$vacaciones,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas], //NT
        ];
    }
    public static function getVacacion($id)
    {
        $sql = "select f.*, concat(p.primer_apellido,' ',p.segundo_apellido,' ',p.nombres) as empleado 
                    from vacaciones f
                    inner join empleados m on m.id =f.empleado_id
                    inner join personas p on p.id= m.id
                    where f.eliminado =0 and f.id=$id";
        $vacaciones = DB::select($sql);
        if (count($vacaciones)>0) {
            return $vacaciones[0];
        } else {
            return null;
        }
    }
    public static function getSolicitudesVacaciones($empleado_id)
    {
        $sql = "select id, fecha_ini ,fecha_fin ,dias, observacion,estado from solicitudes_vacaciones sv where empleado_id =$empleado_id order by id desc";
        $vacaciones = DB::select($sql);
        return $vacaciones;
    }

    public function obtenerDiasVacacionesEmpleado($empleado_id)
    {
        $anio = date("Y");
        $sql = "select sum(dias) as dias from vacaciones v where empleado_id=$empleado_id and eliminado=0 and activo =1 and fecha_ini >='$anio-01-01' and fecha_fin <='$anio-12-31'";
        $numVacaciones = 0;
        $vacaciones = DB::select($sql);
        if (count($vacaciones)>0) {
            if ($vacaciones[0]->dias){
                $numVacaciones= $vacaciones[0]->dias;
            }
        }
        
        $anio = date("Y");
        $sql = "select sum(dias) as dias from solicitudes_vacaciones v where estado ='PENDIENTE' and empleado_id=$empleado_id and eliminado=0 and activo =1 and fecha_ini >='$anio-01-01' and fecha_fin <='$anio-12-31'";
        $numVacacionesSolicitud = 0;
        $vacaciones = DB::select($sql);
        if (count($vacaciones)>0) {
            if ($vacaciones[0]->dias){
                $numVacacionesSolicitud= $vacaciones[0]->dias;
            }
        }
        return $numVacaciones+$numVacacionesSolicitud;

    }
    

    public function CalcularDiasVacaciones($fecha_ini,$fecha_fin){

        $fecha_seek=$fecha_ini;
        $nroDias=0;
        while($fecha_seek<=$fecha_fin){
            $strDia =$this->diaSemana($fecha_seek);
            if($strDia!='Sabado' && $strDia!='Domingo'){
                if(!$this->esFeriado($fecha_seek)){
                    $nroDias++;
                }
            }
            $fecha_seek = $this->sumar_dias($fecha_seek,1);
        }
        return $nroDias;
    }

    public function sumar_dias($fecha, $dias) {
        $nuevafecha = strtotime ( "+{$dias} day" , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        return $nuevafecha;
    }
    function diaSemana($nombredia)
    {
        
        $dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $strDia = $dias[date('N', strtotime($nombredia))];
        
        return $strDia;
    }
    function esFeriado($fecha){
        $sql="select count(*) as cantidad from feriados where fecha='$fecha' and activo =1 and eliminado =0";
        $feriados = DB::select($sql);
        if (count($feriados)>0) {
            if ($feriados[0]->cantidad>0){
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    
}
