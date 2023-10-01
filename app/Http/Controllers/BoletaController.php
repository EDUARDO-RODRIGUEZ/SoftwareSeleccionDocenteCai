<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Contrato;
use App\Models\Periodo;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class BoletaController extends Controller
{
    public $parControl=[
        'modulo'=>'planilla',
        'funcionalidad'=>'boletas',
        'titulo' =>'Boletas',
    ];

    public function index(Request $request)
    {
        $boletas = new Boleta();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $boletas->obtenerBoletas($buscar,$pagina);
        $mergeData = [
            'boletas'=>$resultado['boletas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('boletas.index',$mergeData);
    }


    public function agregar()
    { 
        $contrato= new Contrato();
        $contratos = $modulo->obtenerModulosActivos();

        $mergeData = ['parControl'=>$this->parControl,'modulos'=>$modulos];
        return view('boletas.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'titulo'=>'required|max:50',
            'ruta'=>'required|max:20',
            'modulo_id'=>'required',
            'activo'=>'required',
        ]);

        $funcionalidad = new Funcionalidad();
        $funcionalidad->titulo = $request->titulo;
        $funcionalidad->ruta = $request->ruta;
        $funcionalidad->modulo_id = $request->modulo_id;
        $funcionalidad->activo = $request->activo?true:false;
        $funcionalidad->save();

        return redirect()->route('boletas.mostrar',$funcionalidad->id);
    }
    
    public function eliminar($id)
    {
        $boleta = Boleta::find($id);
        $boleta->anulado=true;
        $boleta->save();
        return redirect()->route('boletas.index');
    }

    public function generar(Request $request)
    {
        $oPeriodo = new Periodo();
        $periodo_id = $request->periodo_id;
        $resultados=[];
        $periodos = $oPeriodo->obtenerPeriodosActivos();
        if($periodo_id){
            $boleta = new Boleta();
            $periodo = Periodo::find($periodo_id);
            $resultados = $boleta->generarBoletasContratos($periodo->fecha_ini,$periodo->fecha_fin,$periodo_id);
        }
        $mergeData = [
            'resultados'=>$resultados,
            'periodos'=>$periodos,
            'periodo_id'=>$periodo_id,
            'parControl'=>$this->parControl
        ];
        return view('boletas.generar',$mergeData);
    }
    public function guardarBoletas(Request $request)
    {
        $periodo_id = $request->periodo_id;
        $contratos_ids=$request->contratos_ids;

        for ($i=0; $i < count($contratos_ids); $i++) { 
            $contrato_id = $contratos_ids[$i];
            $boleta = new Boleta(); 
            $boleta->contrato_id=$contrato_id;
            $boleta->periodo_id=$periodo_id;
            $boleta->haber_basico=$request->{"haber_basico_$contrato_id"};
            $boleta->bono=$request->{"bono_$contrato_id"};
            $boleta->descuento=$request->{"descuento_$contrato_id"};
            $boleta->anticipo=$request->{"anticipo_$contrato_id"};
            $boleta->liquido_pagable =$boleta->haber_basico+$boleta->bono-$boleta->descuento-$boleta->anticipo;
            $boleta->anulado=false;
            $boleta->pagado=false;
            $boleta->save();
        }
        return redirect()->route('boletas.index');
    }
    public function pagar($boleta_id)
    {
        $oBoleta = new Boleta();
        
        $boleta = $oBoleta->obtenerBoletaEmpleado($boleta_id);
        
        $mergeData = [
            'boleta'=>$boleta,
            'boleta_id'=>$boleta_id,
            'parControl'=>$this->parControl
        ];
        return view('boletas.pagar',$mergeData);
    }
    
    public function recibo($boleta_id)
    {
        $oBoleta = new Boleta();
        
        $boletaPag = $oBoleta->obtenerBoletaEmpleado($boleta_id);
        $mergeData = [
            'boletaPag'=>$boletaPag,
            'parControl'=>$this->parControl
        ];
        return view('boletas.recibo',$mergeData);
    }

    public function guardarPago(Request $request)
    {
        $boleta_id = $request->id;
        $boleta = Boleta::find($boleta_id);
        $boleta->pagado=true;
        $boleta->fecha_pago=date('Y-m-d H:i:s');
        $boleta->save();
        return redirect()->route('boletas.recibo',$boleta_id);
    }
}
