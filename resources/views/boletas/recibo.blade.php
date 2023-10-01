@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Pagar Boleta de {{$boletaPag->periodo}}</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('boletas.index')}}">Boletas</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content" >
                        <form method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}
                            <div id="print-area">
                                <div style="text-align: center ; width: 300px" >
                                    <strong>SISTEMA DE RECURSOS HUMANOS</strong><BR>
                                    <strong>RECIBO DE PAGO DE MES</strong><BR>
                                    <strong>{{$boletaPag->periodo}}</strong><BR>
                                    <HR>
                                </div>
                                
                                <div  style="width: 300px">
                                    <strong>EMPLEADO:</strong><BR>
                                    <span style="padding-left:110px;">{{"$boletaPag->primer_apellido $boletaPag->segundo_apellido $boletaPag->nombres"}}</span><BR>
                                    <strong>HABER BASICO:</strong><BR>
                                    <span style="padding-left:110px;">{{$boletaPag->haber_basico}}</span><BR>
                                    <strong>BONO:</strong><BR>
                                    <span style="padding-left:110px;">{{$boletaPag->bono}}</span><BR>
                                    <strong>DESCUENTO:</strong><BR>
                                    <span style="padding-left:110px;">{{$boletaPag->descuento}}</span><BR>
                                    <strong>ANTICIPO:</strong><BR>
                                    <span style="padding-left:110px;">{{$boletaPag->anticipo}}</span>
                                        <hr>
                                    <strong>LIQUIDO PAGABLE:</strong><BR>
                                    <span style="padding-left:110px;">{{$boletaPag->liquido_pagable}}</span><BR>
                                    <strong>FECHA PAGO:</strong><BR>
                                    <span style="padding-left:110px;">{{fecha_latina($boletaPag->fecha_pago)}}</span><BR><BR><BR>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="button" id="btn-imprimir">Imprimir</button>
                                    <button class="btn btn-info " type="button" onclick="location.href='{{route('boletas.index')}}'">Volver</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="urlPersonasActivas">
    <script>
        $(document).ready(function(){
           $('#btn-imprimir').click(function(){
            $("div#print-area").printArea();
           });
        });

        
    </script>
@stop
