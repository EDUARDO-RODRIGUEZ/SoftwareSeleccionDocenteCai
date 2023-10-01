<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Anticipo extends Model
{
    use HasFactory;
    protected $table="anticipos";

    public function obtenerAnticipos($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (a.fecha like '%$buscar%' or a.motivo like '%$buscar%' or concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ))";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select a.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as empleado
        from anticipos a
        inner join empleados e on e.id = a.empleado_id
        inner join personas pe on pe.id = e.id
        where a.eliminado=0 $filtro order by id asc limit $inicio,$limite ";

        $anticipos  = DB::select($sql);

        $sqlTotal = "select count(*) as total from anticipos a where a.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'anticipos'=>$anticipos,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerAnticiposActivos()
    {
        $sql = "select a.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as persona
        from anticipos a
        inner join empleados e on e.id = a.empleado_id
        inner join personas pe on pe.id = e.id
        where a.eliminado =0 and activo=1 order by orden asc";
        $anticipos= DB::select($sql);
        return $anticipos;
    }
}
