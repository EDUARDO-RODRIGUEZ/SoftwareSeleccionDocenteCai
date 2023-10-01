@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Modificar Empleado</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('empleados.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("empleados.actualizar",$empleado)}}" method="post">
        
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Persona:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  value="{{$nombreCompleto}}" disabled="">
                                </div>
                            </div>
                            @error('id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Correo_Corporativo:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="correo_corporativo" value="{{ $empleado->correo_corporativo }}" >
                                </div>
                            </div>
                            @error('correo_corporativo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Profesion:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="profesion" value="{{ $empleado->profesion }}" >
                                </div>
                            </div>
                            @error('profesion')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sucursales:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="sucursal_id"  id="sucursal_id">
                                        <option value="" ></option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" @if(old('sucursal_id',$empleado->sucursal)==$sucursal->id) selected="" @endif >{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('sucursal_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargos:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="cargo_id"  id="cargo_id">
                                        <option value="" ></option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{$cargo->id}}" @if(old('cargo_id',$empleado->cargo)==$cargo->id) selected="" @endif >{{$cargo->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('cargo_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            




                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo',$empleado->activo)=='1') checked="" @endif> <i></i>SI</label>
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo',$empleado->activo)=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('empleados.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop