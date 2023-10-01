@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Empleado</h2>
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
                        <form action="{{route("empleados.insertar")}}" method="post">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Persona:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Persona" name="txtPersona" id="txtPersona" value="{{$nombreCompleto}}" class="typeahead_2 form-control" />
                                    <input type="hidden" name="id" id="id" value="{{old('id',$id)}}">
                                    {{-- <input type="text" class="form-control" name="id" value="{{old('id')}}" required=""> --}}
                                </div>
                            </div>
                            @error('id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Correo Corporativo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="correo_corporativo" value="{{old('correo_corporativo')}}" required="">
                                </div>
                            </div>
                            @error('correo_corporativo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Profesion:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="profesion" value="{{old('profesion')}}" required="">
                                </div>
                            </div>
                            @error('profesion')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargos:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="cargo_id"  id="cargo_id">
                                        <option value="" ></option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{$cargo->id}}" @if(old('cargo_id',$cargo_id)==$cargo->id) selected="" @endif>{{$cargo->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('cargo_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sucursales:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="sucursal_id"  id="sucursal_id">
                                        <option value="" ></option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" @if(old('sucursal_id')==$sucursal->id) selected="" @endif>{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('sucursal_id')
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
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('empleados.index')}}'">Cancelar</button>
                                    
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
            $('#txtPersona').keyup(function(){
                var nombre=$(this).val();
                if(nombre.length>=3){
                    $.get('{{route('empleados.personasActivas')}}?q='+nombre, function(data){
                        $("#txtPersona").typeahead(
                            { 
                                source:data,
                                afterSelect:function(item){
                                    $('#id').val(item.id);
                                }
                            }
                            );
                    },'json');    
                }else{
                    if(nombre.length==0){
                        $('#id').val('');
                    }
                }
                
            });
        });
    </script>

@stop
