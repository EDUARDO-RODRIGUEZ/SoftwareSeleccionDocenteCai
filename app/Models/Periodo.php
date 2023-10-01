<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Periodo extends Model
{
    use HasFactory;
    protected $table="periodos";

    public function obtenerPeriodosActivos()
    {
        $sql = "select p.id ,concat(g.nombre ,' - ', p.nombre) as periodo
                from periodos p 
                inner join gestiones g on g.id=p.gestion_id 
                where p.activo =1 and p.eliminado =0  order by p.fecha_ini";
        $periodos = DB::select($sql);
        return $periodos;
    }
}
