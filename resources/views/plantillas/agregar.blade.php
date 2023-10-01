@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Plantilla</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('plantillas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <h1>Configuración de la Plantilla</h1>
                        <br>
                        <form action="{{route("plantillas.insertar")}}" method="post">
                            @csrf
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre1" name="nombre" value="{{old('nombre')}}" required="">
                                </div>
                            </div>
                            @error('nombre')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            {{-- comienzo --}}
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tipo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tipo"  id="tipo">
                                        <option value="" @if(old('')=='') selected="" @endif></option>
                                        <option value="postulacion" @if(old('tipo')=='postulacion') selected="" @endif>postulacion</option>
                                        <option value="entrevista" @if(old('tipo')=='entrevista') selected="" @endif>entrevista</option>                                       
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="cargo_id"  id="cargo_id">
                                        <option value="" ></option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{$cargo->id}}" >{{$cargo->nombre}}</option>
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
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo')=='1') checked="" @endif> <i></i>SI</label>&nbsp;&nbsp;
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo')=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                        
                        {{-- FORMULARIO PARA PREGUNTAS Y RESPUESTAS--}}
                            <div class="ibox-content">
                                <h1>Contenido de la Plantilla</h1>
                                <br>
                                <div class="col-lg-12" style="text-align:center" id="labeltidtulo">
                                    <h3>Preguntas Entrevista/Postulacion - {{$cargo->nombre}} </h3>
                                    {{--<input type="text" class="form-control" id="labeltitulo">--}}
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombre1" name="nombre" placeholder="Ingrese una pregunta" required="">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombre1" name="nombre" placeholder="Ingrese una pregunta" required="">
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-10">
                                    <fieldset id="field">
                                        <input class="btn btn-dark" type="button" value="+ Agregar Pregunta" onclick="crear(this)">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('plantillas.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
 
        icremento =0;
        function crear(obj) {
            icremento++;
         
            field = document.getElementById('field');
            contenedor = document.createElement('div');
            contenedor.id = 'div'+icremento;
            field.appendChild(contenedor);
            
            boton = document.createElement('input');
            boton.type = 'text';
            boton.name = 'text'+'[ ]';
            contenedor.appendChild(boton);
         
         
        }
        function borrar(obj) {
          field = document.getElementById('field');
          field.removeChild(document.getElementById(obj));
        }
        </script>

    {{--<script>
        $(document).ready(function () {
            $("#nombre1").keyup(function () {
                var value = $(this).val();
                $("#labeltitulo").val(value);
            });
         });
    </script>--}}
@stop
