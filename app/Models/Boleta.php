<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Boleta extends Model
{
    use HasFactory;
    protected $table="boletas";

    public function obtenerBoletas($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio = ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (p.nombres like '%$buscar%' or p.primer_apellido or p.segundo_apellido or p.ci like '%$buscar%')";
        }

        $sql = "select bo.id, c.id as contrato_id,c.empleado_id ,p.nombres, p.primer_apellido ,p.segundo_apellido ,p.ci,p.ci_exp as ciexp 
        ,bo.haber_basico,bo.bono, bo.descuento,bo.anticipo,bo.liquido_pagable 
        ,car.nombre as cargo, concat(ge.nombre,'-',pe.nombre) as periodo, bo.anulado, bo.created_at, bo.pagado, bo.fecha_pago
        from boletas bo 
        inner join contratos c on bo.contrato_id=c.id 
        inner join empleados e on e.id=c.empleado_id 
        inner join personas p on e.id=p.id
        inner join periodos pe on pe.id=bo.periodo_id
        inner join gestiones ge on ge.id=pe.gestion_id 
        inner join cargos car on  car.id=c.cargo_id
        where bo.anulado=0 and c.eliminado = 0 $filtro order by bo.id desc limit $inicio,$limite";
        $boletas = DB::select($sql);

        $sqlTotal = "select count(*) as total 
        from boletas b
        inner join contratos c on c.id =b.contrato_id 
        where b.anulado =0 $filtro ";

        $result = DB::select($sqlTotal); //no tocar
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'boletas'=>$boletas,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas], //NT
        ];
    }

    
    public static function generarBoletasContratos($fecha_ini,$fecha_fin,$periodo_id)
    {
        $sql = "select c.id as contrato_id,c.empleado_id ,p.nombres, p.primer_apellido ,p.segundo_apellido ,p.ci,p.ci_exp as ciexp ,c.sueldo_basico
                ,car.nombre as cargo,bonos.monto as bono, descuentos.monto as descuento
                ,anticipos.monto as anticipo
                from contratos c 
                inner join empleados e on e.id=c.empleado_id 
                inner join personas p on e.id=p.id
                inner join cargos car on  car.id=c.cargo_id 
                left join (
                    select empleado_id ,sum(monto) as monto from bonos b 
                    where fecha >='$fecha_ini' and fecha <='$fecha_fin'
                    group by empleado_id 
                )as bonos on bonos.empleado_id =c.empleado_id 
                left join (
                    select empleado_id ,sum(monto) as monto from descuentos  
                    where fecha >='$fecha_ini' and fecha <='$fecha_fin'
                    group by empleado_id 
                )as descuentos on descuentos.empleado_id =c.empleado_id 
                left join (
                    select empleado_id ,sum(monto) as monto from anticipos  
                    where fecha >='$fecha_ini' and fecha <='$fecha_fin'
                    group by empleado_id 
                )as anticipos on anticipos.empleado_id =c.empleado_id
                left join boletas bo on bo.contrato_id=c.id and bo.periodo_id=$periodo_id and anulado=0
                where c.activo =1 and c.eliminado =0 and bo.id is null";
                
                $resultados = DB::select($sql);
                return $resultados;
    }

    public function obtenerBoletaEmpleado($boleta_id){
        $sql = "select bo.id, c.id as contrato_id,c.empleado_id ,p.nombres, p.primer_apellido ,p.segundo_apellido ,p.ci,p.ci_exp as ciexp 
        ,bo.haber_basico,bo.bono, bo.descuento,bo.anticipo,bo.liquido_pagable 
        ,car.nombre as cargo, concat(ge.nombre,'-',pe.nombre) as periodo, bo.anulado, bo.created_at,bo.fecha_pago, bo.pagado
        from boletas bo 
        inner join contratos c on bo.contrato_id=c.id 
        inner join empleados e on e.id=c.empleado_id 
        inner join personas p on e.id=p.id
        inner join periodos pe on pe.id=bo.periodo_id
        inner join gestiones ge on ge.id=pe.gestion_id 
        inner join cargos car on  car.id=c.cargo_id
        where bo.anulado=0 and c.eliminado = 0 and bo.id=$boleta_id";
        $boletas = DB::select($sql);
        if (count($boletas)>0) {
            return $boletas[0];
        } else {
            return null;
        }
    }

    public function obtenerListadoBoletas($empleado_id){
        $sql = "select bo.id, c.empleado_id ,p.nombres, p.primer_apellido ,p.segundo_apellido ,p.ci,p.ci_exp as ciexp 
        ,bo.liquido_pagable 
        ,car.nombre as cargo, concat(ge.nombre,'-',pe.nombre) as periodo, bo.created_at, bo.pagado, bo.fecha_pago                
        from boletas bo 
        inner join contratos c on bo.contrato_id=c.id 
        inner join empleados e on e.id=c.empleado_id 
        inner join personas p on e.id=p.id
        inner join periodos pe on pe.id=bo.periodo_id
        inner join gestiones ge on ge.id=pe.gestion_id 
        inner join cargos car on  car.id=c.cargo_id
        where bo.anulado=0 and c.eliminado = 0 and c.empleado_id =$empleado_id order by pe.fecha_ini desc";
        $boletas = DB::select($sql);
        return $boletas;
    }
    /*
    public static function getFuncionalidad($id)
    {
        $sql = "select f.*, m.titulo as modulo from funcionalidades f
                    inner join modulos m on m.id =f.modulo_id 
                    where f.eliminado =0 and f.id=$id";
        $funcionalidades = DB::select($sql);
        if (count($funcionalidades)>0) {
            return $funcionalidades[0];
        } else {
            return null;
        }
    }

    public function obtenerFuncionalidadesActivas($modulo_id)
    {
        $sql = "select id,titulo from funcionalidades f where f.activo =1 and f.eliminado =0 and modulo_id=$modulo_id order by f.orden asc";
        $funcionalidades = DB::select($sql);
        return $funcionalidades;
    }
    
*/
}
