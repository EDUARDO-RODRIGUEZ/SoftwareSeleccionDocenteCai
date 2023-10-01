@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Pagar Boleta de {{$boleta->periodo}}</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('boletas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("boletas.guardarPago")}}" method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Empleado:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Empleado" value="{{"$boleta->primer_apellido $boleta->segundo_apellido $boleta->nombres"}}" class="typeahead_2 form-control" disabled=""/>
                                    <input type="hidden" name="id" id="id" value="{{$boleta->id}}">
                                </div>
                            </div>
                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Haber Basico:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->haber_basico}}" disabled="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bono:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->bono}}" disabled="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Descuento:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->descuento}}" disabled="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Anticipo:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->anticipo}}" disabled="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Liquido Pagable:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->liquido_pagable}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Periodo:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$boleta->periodo}}" disabled="">
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Pagar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('boletas.index')}}'">Cancelar</button>
                                    
                                    
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
            
        });

        
    </script>
@stop
