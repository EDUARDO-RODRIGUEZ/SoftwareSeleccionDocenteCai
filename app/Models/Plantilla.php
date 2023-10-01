<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Plantilla extends Model
{
    use HasFactory;
    protected $table="plantillas";

    public function obtenerPlantillas($buscar='', $pagina=1){
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (p.nombre like '%$buscar%' ) ";
        }

        $sql = "select p.*, c.nombre as cargo 
                from plantillas p
                inner join cargos c on c.id = p.cargo_id
                where p.eliminado =0 $filtro order by id desc limit $inicio,$limite";
        $plantillas = DB::select($sql);

        $sqlTotal = "select count(*) as total from plantillas p
                    where p.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'plantillas'=>$plantillas,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }
    
    public static function getPlantilla($id){
        $sql = "select p.*, c.nombre as cargo from plantillas p
                    inner join cargos c on c.id =p.cargo_id 
                    where p.eliminado =0 and p.id=$id";
        $plantillas = DB::select($sql);
        if (count($plantillas)>0) {
            return $plantillas[0];
        } else {
            return null;
        }
    }
    public function obtenerPlantillaActivaCargo($cargo_id,$tipo){
        $sql="select * from plantillas p where p.cargo_id =$cargo_id and tipo='$tipo' and activo =1 and eliminado =0 limit 1";
        $plantillas= DB::select($sql);
        if(count($plantillas)>0){
            return $plantillas[0];
        }else{
            return null;
        }
    }
}
