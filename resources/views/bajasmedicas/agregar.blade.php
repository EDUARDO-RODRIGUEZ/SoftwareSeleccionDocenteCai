@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Baja Medica</h2>
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
                        <form action="{{route("bajasmedicas.insertar")}}" method="post">
                            @csrf
                           <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Empleado:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Empleado" name="txtEmpleado" id="txtEmpleado" value="" class="typeahead_2 form-control" />
                                    <input type="hidden" name="empleado_id" id="empleado_id" value="{{old('empleado_id')}}">
                                </div>
                            </div>
                            @error('id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Inicio:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="date" class="form-control" name="fecha_ini" value="{{old('fecha_ini')}}" required=""></div>
                            </div>
                            @error('fecha_ini')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Fin:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="date" class="form-control" name="fecha_fin" value="{{old('fecha_fin')}}" required=""></div>
                            </div>
                            @error('fecha_fin')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observacion:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="observacion" value="{{old('observacion')}}" ></div>
                            </div>
                            @error('observacion')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Modalidad:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="modalidad" value="{{old('modalidad')}}" required=""></div>
                            </div>
                            @error('motivo')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('bajasmedicas.index')}}'">Cancelar</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function(){
            $('#txtEmpleado').keyup(function(){
                var nombre=$(this).val();
                if(nombre.length>=3){
                    $.get('{{route('empleados.empleadosActivos')}}?q='+nombre, function(data){
                        $("#txtEmpleado").typeahead(
                            {
                                source:data,
                                afterSelect:function(item){
                                    $('#empleado_id').val(item.id);
                                }
                            }
                            );
                    },'json');
                }else{
                    if(nombre.length==0){
                        $('#empleado_id').val('');
                    }
                }

            });
        });
    </script>
@stop
