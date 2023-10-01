<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Departamento extends Model
{
    use HasFactory;
    protected $table="departamentos";

    public function obtenerDepartamentos($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (d.nombre like '%$buscar%')";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select * from departamentos d where d.eliminado=0 $filtro order by id asc limit $inicio,$limite ";
        $departamentos = DB::select($sql);

        $sqlTotal = "select count(*) as total from departamentos d where d.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'departamentos'=>$departamentos,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerDepartamentosActivos()
    {
        $sql = "select id,nombre from departamentos a where a.eliminado =0 and activo=1 order by id asc";
        $departamentos = DB::select($sql);
        return $departamentos;
    }
}
