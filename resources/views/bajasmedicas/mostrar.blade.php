@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Mostrar Baja Medica</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('bajasmedicas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form >
                           {{--}} <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Empleado</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$bajamedica->empleado}}" disabled=""></div>
                            </div>{{--}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Empleado</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$empleado}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Inicio</label>
                                <div class="col-sm-10"><input type="date" class="form-control" value="{{$bajamedica->fecha_ini}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Fin</label>
                                <div class="col-sm-10"><input type="date" class="form-control" value="{{$bajamedica->fecha_fin}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observacion</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$bajamedica->observacion}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Modalidad</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$bajamedica->modalidad}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    @if ($bajamedica->activo)
                                        <span class="label label-primary">SI</span>
                                    @else
                                        <span class="label label-warning">NO</span>
                                    @endif
                                    {{-- <input class="form-control" @if($bajamedica->activo) value="SI" @else value="NO" @endif  disabled=""> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Creado</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{fecha_latina($bajamedica->created_at) }}" disabled=""></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
