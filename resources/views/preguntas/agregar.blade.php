@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Preguntas</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('preguntas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("preguntas.insertar")}}" method="post">
                            @csrf
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pregunta:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="pregunta" value="{{old('pregunta')}}" required=""></div>
                            </div>
                            @error('pregunta')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Orden:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="number" class="form-control" name="orden" value="{{old('orden')}}" required=""></div>
                            </div>
                            @error('orden')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tipo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tipo"  id="tipo">
                                        <option value="" @if(old('')=='') selected="" @endif></option>
                                        <option value="SelUnica" @if(old('tipo')=='SelUnica') selected="" @endif>Seleccion Unica</option>
                                        <option value="SelMultiple" @if(old('tipo')=='SelMultiple') selected="" @endif>Seleccion Multiple</option>  
                                    </select>
                                </div>
                            </div>
                            @error('tipo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Plantilla:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="plantilla_id"  id="plantilla_id">
                                        <option value="" ></option>
                                        @foreach ($plantillas as $plantilla)
                                            <option value="{{$plantilla->id}}" @if(old('plantilla_id')==$plantilla->id) selected="" @endif>{{$plantilla->plantilla}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('plantilla_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo')=='1') checked="" @endif> <i></i>SI</label>&nbsp;&nbsp;
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo')=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('preguntas.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
