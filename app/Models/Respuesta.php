<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Respuesta extends Model
{
    use HasFactory;
    protected $table="respuestas";

    public function obtenerRespuestas($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (s.respuesta like '%$buscar%')";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select * from respuestas s where s.eliminado=0 $filtro order by id asc limit $inicio,$limite ";
        $respuestas = DB::select($sql);

        $sqlTotal = "select count(*) as total from respuestas s where s.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'respuestas'=>$respuestas,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerRespuestasActivas()
    {
        $sql = "select id,respuesta from respuestas s where s.eliminado =0 and activo=1 order by respuesta asc";
        $respuestas = DB::select($sql);
        return $respuestas;
    }

    public function obtenerRespuestasActivasPregunta($pregunta_id){
        $sql="select * from respuestas r where r.pregunta_id =$pregunta_id and activo=1 and eliminado=0 order by orden asc";
        $respuestas= DB::select($sql);
        return $respuestas;
        
    }
}
