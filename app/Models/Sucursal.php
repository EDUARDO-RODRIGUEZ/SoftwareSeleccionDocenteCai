<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sucursal extends Model
{
    use HasFactory;
    protected $table="sucursales";

    public function obtenerSucursales($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (s.nombre like '%$buscar%')";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select * from sucursales s where s.eliminado=0 $filtro order by id asc limit $inicio,$limite ";
        $sucursales = DB::select($sql);

        $sqlTotal = "select count(*) as total from sucursales s where s.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'sucursales'=>$sucursales,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerSucursalesActivos()
    {
        $sql = "select id,nombre from sucursales s where s.eliminado =0 and activo=1 order by nombre asc";
        $sucursales = DB::select($sql);
        return $sucursales;
    }
}
