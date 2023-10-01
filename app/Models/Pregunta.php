<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pregunta extends Model
{
    use HasFactory;
    protected $table="preguntas";

    public function obtenerPreguntas($buscar='', $pagina=1)
    {
        $limite=15;
        $filtro="";
        if ($buscar!="") {
            $filtro=" and (s.pregunta like '%$buscar%')";
        }
        $pagina = $pagina ? $pagina : 1;
        $inicio =  ($pagina -1)* $limite;
        $sql = "select * from preguntas s where s.eliminado=0 $filtro order by id asc limit $inicio,$limite ";
        $preguntas = DB::select($sql);

        $sqlTotal = "select count(*) as total from preguntas s where s.eliminado=0 $filtro";
        $result = DB::select($sqlTotal);
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        }
        return [
            'preguntas'=>$preguntas,
            'total'=>$total,
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas]
        ];
    }
    public function obtenerPreguntasActivas()
    {
        $sql = "select id,pregunta from preguntas s where s.eliminado =0 and activo=1 order by pregunta asc";
        $preguntas = DB::select($sql);
        return $preguntas;
    }

    public function obtenerPreguntasActivasPlantilla($plantilla_id){
        $sql="select * from preguntas p where p.plantilla_id =$plantilla_id and activo=1 and eliminado=0 order by orden asc";
        $preguntas= DB::select($sql);
        return $preguntas;
        
    }
}
