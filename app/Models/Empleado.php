<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empleado extends Model
{
    use HasFactory;
    protected $table="empleados";

    
    public function obtenerEmpleados($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ) ";
        }

        $sql = "select e.id,e.correo_corporativo,e.profesion, e.activo
            ,e.created_at,e.updated_at,e.usuario,p.nombre as perfil, concat(pe.primer_apellido,' '
            ,coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona,c.nombre as  cargo,s.nombre as sucursal 
            from empleados e
            inner join personas pe on pe.id=e.id
            left join perfiles p on p.id=e.perfil_id
            inner join cargos c on c.id=e.cargo_id
            inner join sucursales s on s.id=e.sucursal_id
            where e.eliminado =0 $filtro order by id desc limit $inicio,$limite";
        $empleados = DB::select($sql);

        $sqlTotal = "select count(*) as total from empleados e
                    inner join personas pe on pe.id=e.id
                    left join perfiles p on p.id=e.perfil_id
                    inner join cargos c on c.id=e.cargo_id
                    inner join sucursales s on s.id=e.sucursal_id
                    where e.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'empleados'=>$empleados,
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
/*               will vee esto 
    public function obtenerEstudiantesActivos()
    {
        $sql = "select id,nombre
                from grupos gr
                where gr.eliminado =0 and activo=1 order by orden asc";
        $grupos = DB::select($sql);
        return $grupos;
    }
*/
    public function BuscarEmpleadosActivos($buscar)
    {
        $sql="select e.id,concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as nombre  
                from personas p 
                inner join empleados e on e.id=p.id
                where concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) like '%$buscar%' and p.eliminado =0";

        $empleados = DB::select($sql);
        return $empleados;
    }

    public Static function getEmpleado($id){
        $sql="select e.*,p.nombre as perfil, concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona from empleados e 
        inner join personas pe on pe.id=e.id
        left join perfiles p on p.id=e.perfil_id
        
        inner join cargos c on c.id=e.cargo_id
        inner join sucursales s on s.id=e.sucursal_id
        where e.id=$id";

        $empleados= DB::select($sql);

        if(count($empleados)>0){
            return $empleados[0];
        }else{
            return null;
        }
    }

    public static function getIdPerfilEmpleado(){
        return 1;
    }

    public function obtenerEmpleadosActivos(){
        $sql="select e.id,concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as nombre  
        from personas p 
        inner join empleados e on e.id=p.id
        where e.activo and e.eliminado =0";

        $empleados = DB::select($sql);
        return $empleados;
    }
    public function obtenerDatosEmpleado($empleado_id){
        $sql="select e.id,e.correo_corporativo,e.profesion, e.activo
            ,e.usuario,concat(pe.primer_apellido,' '
            ,coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona,c.nombre as  cargo,s.nombre as sucursal 
            ,con.sueldo_basico, con.fecha_inicio, con.fecha_final
            from empleados e
            inner join personas pe on pe.id=e.id
            inner join contratos con on con.empleado_id =e.id and con.activo =1
            inner join cargos c on c.id=e.cargo_id
            inner join sucursales s on s.id=e.sucursal_id
            where e.eliminado =0 and e.id=$empleado_id";

        $empleados = DB::select($sql);
        if(count($empleados)>0){
            return $empleados[0];
        }else{
            return null;
        }
    }

}
