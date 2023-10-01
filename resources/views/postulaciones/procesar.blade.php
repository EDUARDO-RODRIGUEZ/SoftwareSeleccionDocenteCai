@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Procesar Postulaciones</h2>
           
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
                        <form action="{{route("postulaciones.guardarEntrevistas")}}" method="post">
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
                                        <th>&nbsp;</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Entrevistador</th>
                                        <th>Id</th>
                                        <th>Postulante</th>
                                        <th>CI</th>
                                        <th>Telefono</th>
                                        <th>Curriculum</th>
                                        <th>Contactar</th>
                                        
                                        <th>Puntaje</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($resultados!=null)
                                        @foreach($resultados as $resultado)
                                        <tr>
                                            @if(!$resultado->entrevista_programada_id)
                                                <td>
                                                    <input type="checkbox" name="postulaciones_ids[]" class="" value="{{$resultado->id}}">
                                                </td>
                                                <td>
                                                    <input type="date" name="fecha_{{$resultado->id}}" value="" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="time" name="hora_{{$resultado->id}}" value="" class="form-control">
                                                </td>
                                                <td>
                                                    <select name="empleado_id_{{$resultado->id}}"  class="form-control">
                                                        <option value=""></option>
                                                        @foreach ($empleados as $empleado)
                                                            <option value="{{$empleado->id}}">{{$empleado->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @else
                                                <td></td><td></td><td></td><td></td>
                                            @endif
                                            
                                            <td>{{$resultado->id}}</td>
                                            <td>{{"$resultado->primer_apellido $resultado->segundo_apellido $resultado->nombres"}}</td>
                                            <td>{{$resultado->ci}}</td>
                                            <td>{{$resultado->celular}}</td>
                                            <td>
                                                @if ($resultado->curriculum)
                                                    <a href="{{asset('curriculum/'.$resultado->curriculum)}}" target="_blank"> Ver Curriculum</a>    
                                                @endif
                                            </td>
                                            <td><a style="background-color: #1FA41E" target="_blank" href="https://wa.me/591{{$resultado->celular}}?text=Buenas tardes, se comunica el CAI-UAGRM, le infomamos que esta usted esta apto para realizarle la entrevista, que hora esta disponible del dia de mañana? o en que dia ve pertinente hacerlo." class="btn btn-success" >>Click<</a></td>
                                            
                                            <td>{{$resultado->puntaje}}</td>
                                           
                                            
                                            
                     
                                        </tr>
                                    @endforeach    
                                    @endif
                                </tbody>       
                            </table>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Programar Entrevistas</button>
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
                        location.href='{{route('postulaciones.procesar')}}?convocatoria_id='+convocatoria_id;
                    }
                });
            });
        </script>
    </div>
@stop
