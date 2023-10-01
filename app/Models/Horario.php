<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Horario extends Model
{
    use HasFactory;
    protected $table="horarios";

    public function obtenerHorarios($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio = ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (f.hora_ing or f.hora_sal like '%$buscar%' ) ";
        }

        $sql = "select f.*, concat(p.primer_apellido,' ',p.segundo_apellido,' ',p.nombres) as empleado m
        from horarios f
        inner join personas p on p.id= m.id
        inner join empleados m on m.id =f.empleado_id 
        where f.eliminado =0 $filtro order by f.id desc limit $inicio,$limite";
        $horarios = DB::select($sql);

        $sqlTotal = "select count(*) as total from horarios f
        inner join empleados m on m.id =f.empleado_id 
        where f.eliminado =0 $filtro ";
        $result = DB::select($sqlTotal); //no tocar
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'horarios'=>$horarios,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas], //NT
        ];
    }
    public static function getHorario($id)
    {
        $sql = "select f.*, concat(p.primer_apellido,' ',p.segundo_apellido,' ',p.nombres) as empleado m
                    from horarios f
                    inner join personas p on p.id= m.id
                    inner join empleados m on m.id =f.empleado_id 
                    where f.eliminado =0 and f.id=$id";
        $horarios = DB::select($sql);
        if (count($horarios)>0) {
            return $horarios[0];
        } else {
            return null;
        }
    }

    public function obtenerHorariosActivas($empleado_id)
    {
        $sql = "select id from horarios f where f.activo =1 and f.eliminado =0 and empleado_id=$empleado_id order by f.orden asc";
        $horarios = DB::select($sql);
        return $horarios;
    }
    /*
    public function obtenerVacacionesActivasEnPerfil($modulo_id,$perfil_id)
    {
        $sql = "select f.id,f.titulo, p.perfil_id 
                from vacaciones f 
                left join permisos p on p.funcionalidad_id = f.id and p.perfil_id =$perfil_id
                where f.activo =1 and f.eliminado =0 and f.modulo_id =$modulo_id order by f.orden asc";
        $vacaciones = DB::select($sql);
        
        return $vacaciones;
    }*/

}
