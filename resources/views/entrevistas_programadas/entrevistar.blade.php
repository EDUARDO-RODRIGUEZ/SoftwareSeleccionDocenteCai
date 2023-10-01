@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Entrevista</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('entrevistas_programadas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("entrevistas_programadas.guardarEntrevistaRealizada")}}" method="post">
                            @csrf
                            <input type="hidden" name="entrevista_programada_id" value="{{$entrevistaProgramada->id}}">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Postulante:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="titulo" value="{{$entrevistaProgramada->persona}}" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargo:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="titulo" value="{{$entrevistaProgramada->cargo}}" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observacion:</label>
                                <div class="col-sm-10">
                                    <textarea name="observacion" id="observacion" class="form-control" ></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="plantilla_id" value="{{$plantilla->id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Preguntas Entrevista</h5>
                                    </div>
                                    <div class="ibox-content">
                                        @foreach ($preguntas as $pregunta)
                                            <div><strong>{{$pregunta->pregunta}}</strong> </div>    
                                            @foreach ($pregunta->respuestas as $respuesta)
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        @if($pregunta->tipo=='SelUnica')
                                                            <div class="i-checks">
                                                                <label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                     <input type="radio" value="{{$respuesta->id}}" name="respuesta_{{$pregunta->id}}"> <i></i>
                                                                     {{$respuesta->respuesta}} 
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="i-checks">
                                                                <label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" value="{{$respuesta->id}}" name="respuesta_{{$pregunta->id}}[]"> <i></i>  
                                                                    {{$respuesta->respuesta}} 
                                                                </label>
                                                            </div>
                                                        @endif
                                                        
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('entrevistas_programadas.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
