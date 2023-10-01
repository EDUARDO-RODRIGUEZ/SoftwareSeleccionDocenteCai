<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Convocatoria;
use App\Models\Postulacion;
class RepPostulacionesController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_postulaciones',
        'titulo' =>'Rep. Postulaciones',
    ];

    public function index(Request $request)
    {   

        $convocatoria_id = $request->convocatoria_id;
        $convocatoria= new Convocatoria();
        $convocatorias = $convocatoria->obtenerConvocatoriasActivas();
        $resultados=null;        
        if($convocatoria_id >0){
            $postulacion = new Postulacion();
            $sql = "select pos.id, p.nombres ,p.primer_apellido ,p.segundo_apellido ,p.ci,p.celular,p.ci_exp 
            ,COALESCE(res.puntaje,0) as puntaje,ep.id as entrevista_programada_id,po.curriculum
            ,pos.created_at,car.nombre as cargo
                from postulaciones pos
                inner join postulantes po on po.id=pos.postulante_id 
                inner join convocatorias c on c.id=pos.convocatoria_id 
                inner join cargos car on car.id=c.cargo_id 
                inner join personas p on p.id=po.id
                left join (
                    select e.postulacion_id, sum(r.valor) as puntaje 
                    from evaluaciones e
                    inner join evaluaciones_respuestas er on er.evaluacion_id =e.id
                    inner join respuestas r on r.id=er.respuesta_id 
                    inner join postulaciones pos on pos.id=e.postulacion_id 
                    where pos.convocatoria_id =$convocatoria_id
                    group by e.postulacion_id 
                ) res on res.postulacion_id=pos.id
                left join entrevistas_programadas ep on ep.eliminado =0 and ep.postulacion_id =pos.id 
                where pos.convocatoria_id =$convocatoria_id
                order by res.puntaje desc";
            $resultados=  DB::select($sql);;
        }

        $mergeData = [
            'convocatorias'=>$convocatorias,
            'convocatoria_id'=>$convocatoria_id,
            'resultados'=>$resultados,
            'parControl'=>$this->parControl
        ];
        return view('RepPostulaciones.index',$mergeData);
    }

}
