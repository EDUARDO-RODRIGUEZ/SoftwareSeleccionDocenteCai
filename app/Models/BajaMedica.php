<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BajaMedica extends Model
{
    use HasFactory;
    protected $table="bajasmedicas";

    public function obtenerBajasMedicas($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (b.fecha_ini like '%$buscar%' or b.fecha_fin like '%$buscar%' or concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ))";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select b.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as empleado
        from bajasmedicas b
        inner join empleados e on e.id = b.empleado_id
        inner join personas pe on pe.id = e.id
        where b.eliminado=0 $filtro order by id asc limit $inicio,$limite ";

        $bajasmedicas = DB::select($sql);

        $sqlTotal = "select count(*) as total from bajasmedicas b where b.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'bajasmedicas'=>$bajasmedicas,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerbajasmedicasActivas()
    {
        $sql = "select b.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as persona
        from bajasmedicas b
        inner join empleados e on e.id = b.empleado_id
        inner join personas pe on pe.id = e.id
        where b.eliminado =0 and activo=1 order by orden asc";
        $bajasmedicas = DB::select($sql);
        return $bajasmedicas;
    }
}
