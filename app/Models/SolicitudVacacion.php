<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolicitudVacacion extends Model
{
    use HasFactory;
    protected $table="solicitudes_vacaciones";

    public function obtenerSolicitudesVacaciones($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (s.fecha_ini like '%$buscar%' or s.dias like '%$buscar%' or s.observacion like '%$buscar%' or concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ))";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select s.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as empleado
        from solicitudes_vacaciones s
        inner join empleados e on e.id = s.empleado_id
        inner join personas pe on pe.id = e.id
        where s.eliminado=0 $filtro order by id desc limit $inicio,$limite ";

        $solicitudvacaciones = DB::select($sql);

        $sqlTotal = "select count(*) as total from solicitudes_vacaciones s where s.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'solicitudvacaciones'=>$solicitudvacaciones,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerSolicitudesVacacionesActivas()
    {
        $sql = "select s.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as empleado
        from solicitudes_vacaciones s
        inner join empleados e on e.id = s.empleado_id
        inner join personas pe on pe.id = e.id
        where s.eliminado=0 and s.activo=1 order by fecha_ini asc";
        $solicitudvacaciones = DB::select($sql);
        return $solicitudvacaciones;
    }
}
