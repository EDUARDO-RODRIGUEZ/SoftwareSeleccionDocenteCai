@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Procesar Entrevistas</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('postulaciones.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form  method="post">
                            @csrf
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Convocatoria {{$convocatoria_id}}:<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="convocatoria_id" id="convocatoria_id" class="form-control">
                                        <option value=""></option>
                                        @foreach ($convocatorias as $convocatoria)
                                            <option value="{{$convocatoria->id}}" @if ($convocatoria->id==$convocatoria_id) selected="selected" @endif>{{$convocatoria->nombre}}</option>    
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success" id="btn-cargar" type="button">Cargar</button>
                                </div>
                            </div>
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Postulante</th>
                                        <th>CI</th>
                                        <th>Telefono</th>
                                        <th>Observacion</th>
                                        <th>Curriculum</th>
                                        <th>Puntaje</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($resultados!=null)
                                        @foreach($resultados as $resultado)
                                        <tr>
                                            <td>{{$resultado->id}}</td>
                                            <td>{{"$resultado->primer_apellido $resultado->segundo_apellido $resultado->nombres"}}</td>
                                            <td>{{$resultado->ci}}</td>
                                            <td>{{$resultado->celular}}</td>
                                            <td>{{$resultado->observacion}}</td>
                                            <td>
                                                @if ($resultado->curriculum)
                                                    <a href="{{asset('curriculum/'.$resultado->curriculum)}}" target="_blank"> Ver Curriculum</a>    
                                                @endif
                                            </td>
                                            <td>{{$resultado->puntaje}}</td>

                                            <td>
                                                <a href="{{route('empleados.agregar')}}?postulacion_id={{$resultado->id}}" title="Agregar como empleado" target="_blank"><img width="17px" src="{{asset('img/iconos/ok.png')}}" ></a>
                                            </td>
                                            
                                        </tr>
                                    @endforeach    
                                    @endif
                                </tbody>       
                            </table>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('postulaciones.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('#btn-cargar').click(function(){
                    var convocatoria_id = $('#convocatoria_id').val();
                    if(convocatoria_id>0){
                        location.href='{{route('entrevistas_programadas.procesar')}}?convocatoria_id='+convocatoria_id;
                    }
                });
            });
        </script>
    </div>
@stop
