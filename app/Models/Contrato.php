<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    use HasFactory;
    protected $table="contratos";

    public function obtenerContratos($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (c.id like '%$buscar%' or concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ))";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select c.*,tp.nombre as tipo_empleado, ca.nombre as cargo, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as empleado
        from contratos c
        inner join empleados e on e.id = c.empleado_id
        inner join personas pe on pe.id = e.id
        inner join tipos_empleados tp on tp.id = c.tipo_empleado_id
        inner join cargos ca on ca.id = c.cargo_id
        where c.eliminado=0 $filtro order by id desc limit $inicio,$limite ";

        $contratos = DB::select($sql);

        $sqlTotal = "select count(*) as total from contratos c where c.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'contratos'=>$contratos,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }

/*    
    public function obtenerContratossActivos()
    {
        $sql = "select b.*, concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) as persona
        from bonos b
        inner join empleados e on e.id = b.empleado_id
        inner join personas pe on pe.id = e.id
        where b.eliminado =0 and activo=1 order by orden asc";
        $bonos = DB::select($sql);
        return $bonos;
    }
    */
}
