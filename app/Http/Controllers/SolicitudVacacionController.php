<?php

namespace App\Http\Controllers;

use App\Models\SolicitudVacacion;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Vacacion;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class SolicitudVacacionController extends Controller
{
    public $parControl=[
        'modulo'=>'recurso',
        'funcionalidad'=>'solicitudvacaciones',
        'titulo' =>'Solicitudes de Vacaciones',
    ];

    public function index(Request $request)
    {
        $solicitudvacacion = new SolicitudVacacion();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $solicitudvacacion->obtenerSolicitudesVacaciones($buscar,$pagina);
        $mergeData = ['solicitudvacaciones'=>$resultado['solicitudvacaciones'],'total'=>$resultado['total'],'buscar'=>$buscar,'parPaginacion'=>$resultado['parPaginacion'],'parControl'=>$this->parControl];
        return view('solicitud_vacaciones.index',$mergeData);
    }

    public function resolver($solitud_vacacion_id, $resolucion)
    {
        $solicitudvacacion = SolicitudVacacion::find($solitud_vacacion_id);
        if($solicitudvacacion->estado=='PENDIENTE'){
            $estado='RECHAZADO';
            if($resolucion){
                $estado='APROBADO';
            }
            $solicitudvacacion->estado=$estado;
            $solicitudvacacion->save();

            if($estado=='APROBADO'){
                $vacacion = new Vacacion();
                
                $vacacion->fecha_ini = $solicitudvacacion->fecha_ini;
                $vacacion->fecha_fin = $solicitudvacacion->fecha_fin;
                $vacacion->dias = $solicitudvacacion->dias;
                $vacacion->observacion = $solicitudvacacion->observacion;
                $vacacion->empleado_id = $solicitudvacacion->empleado_id;
                $vacacion->activo = true;
                $vacacion->eliminado = false;
                $vacacion->save();
            }
        }

        return redirect()->route('solicitud_vacaciones.index');
    }

}
