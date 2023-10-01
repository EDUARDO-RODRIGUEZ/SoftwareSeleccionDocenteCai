<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Postulante extends Model
{
    use HasFactory;
    protected $table="postulantes";

    public function obtenerPostulantes($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ) ";
        }

        $sql = "select e.*,p.nombre as perfil, concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona, 

        from postulantes e
                   inner join personas pe on pe.id=e.id
                   left join perfiles p on p.id=e.perfil_id
                   where e.eliminado =0 $filtro order by id desc limit $inicio,$limite";
        $postulantes = DB::select($sql);

        $sqlTotal = "select count(*) as total from postulantes e
                    inner join personas pe on pe.id=e.id
                    left join perfiles p on p.id=e.perfil_id
                    where e.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'postulantes'=>$postulantes,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function buscarPersonas($buscar){
        $sql="select id,concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as nombre  from personas p 
            where concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) like '%$buscar%' and p.eliminado =0
            and not exists (select e.id from empleados e where e.id=p.id )";

        $personas = DB::select($sql);
        return $personas;
    }

    public function existePostulanteRegistrado($ci)
    {
        $sql="select p.id from personas p 
        inner join postulantes c on c.id=p.id
        where p.eliminado=0 and c.eliminado =0 and p.ci='$ci'";
        $postulantes = DB::select($sql);
        if(count($postulantes)>0){
            return true;
        }else{
            return false;
        }
        
    }
    
}
