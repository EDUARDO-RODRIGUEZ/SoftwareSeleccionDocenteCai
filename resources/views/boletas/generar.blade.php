@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Procesar Boletas</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('boletas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("boletas.guardarBoletas")}}" method="post">
                            @csrf
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Periodo:<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="periodo_id" id="periodo_id" class="form-control">
                                        <option value=""></option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{$periodo->id}}" @if ($periodo->id==$periodo_id) selected="selected" @endif>{{$periodo->periodo}}</option>    
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
                                        <th><input type="checkbox" id="check-all" ></th>
                                        <th>Nombre </th>
                                        <th>Ci </th>
                                        <th>Sueldo Basico</th>
                                        <th>Cargo</th>
                                        <th>Bono</th>
                                        <th>Descuento</th>
                                        <th>Anticipo</th>
                                        <th>Liquido Pagable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($resultados!=null)
                                        @foreach($resultados as $resultado)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="contratos_ids[]" value="{{$resultado->contrato_id}}" class="contratos_ids">
                                                <input type="hidden" name="haber_basico_{{$resultado->contrato_id}}" value="{{$resultado->sueldo_basico}}">
                                                <input type="hidden" name="bono_{{$resultado->contrato_id}}" value="{{$resultado->bono}}">
                                                <input type="hidden" name="descuento_{{$resultado->contrato_id}}" value="{{$resultado->descuento}}">
                                                <input type="hidden" name="anticipo_{{$resultado->contrato_id}}" value="{{$resultado->anticipo}}">
                                            </td>
                                            <td>{{"$resultado->primer_apellido $resultado->segundo_apellido $resultado->nombres"}}</td>
                                            <td>{{"$resultado->ci $resultado->ciexp"}}</td>
                                            <td>{{"$resultado->sueldo_basico bs" }}</td>
                                            <td>{{$resultado->cargo }}</td>
                                            <td>{{"$resultado->bono"}}</td>
                                            <td>{{"$resultado->descuento"}}</td>
                                            <td>{{"$resultado->anticipo"}}</td>
                                           <td>{{$resultado->sueldo_basico+$resultado->bono-$resultado->descuento-$resultado->anticipo}}</td>
                                            
                                        </tr>
                                    @endforeach    
                                    @endif
                                </tbody>       
                            </table>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Generar Boletas</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('boletas.index')}}'">Cancelar</button>
                                    
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
                    var periodo_id = $('#periodo_id').val();
                    if(periodo_id>0){
                        location.href='{{route('boletas.generar')}}?periodo_id='+periodo_id;
                    }
                });
                $('#check-all').click(function(){
                    if($(this).is(':checked')){
                        $('.contratos_ids').prop('checked',true);
                    }else{
                        $('.contratos_ids').prop('checked',false);
                    }
                });
            });
        </script>
    </div>
@stop
