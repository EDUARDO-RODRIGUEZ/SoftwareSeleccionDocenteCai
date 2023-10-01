<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Convocatoria;
use App\Models\Postulacion;
class RepEntrevistasRealizadasController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_entrevistas_realizadas',
        'titulo' =>'Rep. Entrevistas Realizadas',
    ];

    public function index(Request $request)
    {

        $convocatoria_id = $request->convocatoria_id;
        $convocatoria= new Convocatoria();
        $convocatorias = $convocatoria->obtenerConvocatoriasActivas();
        $resultados=null;
        if($convocatoria_id >0){
            $postulacion = new Postulacion();
            $sql = "select er.id, p.primer_apellido, p.segundo_apellido, p.nombres, p.ci, p.ci_exp,
            er.fecha, er.hora, er.observacion, concat(p.primer_apellido,' ', p.segundo_apellido,' ', p.nombres)as empleado,
            COALESCE(res.puntaje,0) as puntaje
            from entrevistas_realizadas er
            inner join entrevistas_programadas ep on ep.id=er.entrevista_programada_id
            inner join postulaciones posts on posts.id=ep.postulacion_id
            inner join postulantes po on po.id=posts.postulante_id
            inner join personas p on p.id=po.id
            inner join convocatorias c on c.id=posts.convocatoria_id
            left join(
                select e.postulacion_id, sum(r.valor) as puntaje
                from evaluaciones e
                inner join postulaciones posts on posts.id=e.postulacion_id
                inner join convocatorias c on c.id=posts.convocatoria_id
                inner join evaluaciones_respuestas er2 on er2.id=e.id
                inner join respuestas r on r.id=er2.respuesta_id
                where posts.convocatoria_id = $convocatoria_id
                group by e.postulacion_id
            )res on res.postulacion_id=posts.id
            where posts.convocatoria_id = $convocatoria_id
            order by res.puntaje desc;";
            $resultados=  DB::select($sql);;
        }

        $mergeData = [
            'convocatorias'=>$convocatorias,
            'convocatoria_id'=>$convocatoria_id,
            'resultados'=>$resultados,
            'parControl'=>$this->parControl
        ];
        return view('RepEntrevistasRealizadas.index',$mergeData);
    }

}
