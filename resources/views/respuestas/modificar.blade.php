@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Modificar Respuesta</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('respuestas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("respuestas.actualizar",$respuesta)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Respuesta:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="respuesta" value="{{old('respuesta',$respuesta->respuesta)}}" required=""></div>
                            </div>
                            @error('respuesta')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Orden:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="number" class="form-control" name="orden" value="{{old('orden',$respuesta->orden)}}" required=""></div>
                            </div>
                            @error('orden')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Valor:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="number" class="form-control" name="valor" value="{{old('valor',$respuesta->valor)}}" required=""></div>
                            </div>
                            @error('valor')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pregunta:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="pregunta_id"  id="pregunta_id">
                                        <option value="" ></option>
                                        @foreach ($preguntas as $pregunta)
                                            <option value="{{$pregunta->id}}" @if(old('pregunta_id',$respuesta->pregunta)==$pregunta->id) selected="" @endif >{{$pregunta->pregunta}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('pregunta_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo',$respuesta->activo)=='1') checked="" @endif> <i></i>SI</label>
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo',$respuesta->activo)=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('respuestas.index')}}'">Cancelar</button>   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
