<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gestion extends Model
{
    use HasFactory;
    protected $table="gestiones";

    public function obtenerGestiones($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (g.nombre like '%$buscar%')";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select * from gestiones g where g.eliminado=0 $filtro order by id asc limit $inicio,$limite ";
        $gestiones = DB::select($sql);

        $sqlTotal = "select count(*) as total from  gestiones g where g.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'gestiones'=>$gestiones,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerGestionesActivas()
    {
        $sql = "select g.* from gestiones g where g.eliminado =0 and activo=1 order by nombre asc";
        $gestiones = DB::select($sql);
        return $gestiones;
    }
}
