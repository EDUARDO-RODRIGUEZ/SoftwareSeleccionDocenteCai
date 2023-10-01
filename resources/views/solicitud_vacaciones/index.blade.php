@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>{{$parControl['titulo']}}</h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row" >
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <a class="btn btn-primary" href="{{route('solicitud_vacaciones.agregar')}}">Agregar</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("solicitud_vacaciones.index")}}" method="get">
                        <div class="row">
                            <div class="col-sm-3 m-b-xs">
                                <div class="input-group">
                                    <input placeholder="Buscar" type="text" class="form-control form-control-sm" name="buscar" value="{{$buscar}}">
                                    <span class="input-group-append"> <button type="submit" class="btn btn-sm btn-success">Buscar</button> </span>
                                </div>
                            </div>
                            <div class="col-sm-7 m-b-xs" >&nbsp;</div>
                            <div class="col-sm-2 m-b-xs" style="float: right;">{{paginacion($parPaginacion)}}</div>
                        </div>
                    </form>
                    <div class="row"><div class="col-sm-12 m-b-xs"><span class="text-success">Total: <strong>{{$total}}</strong></span></div></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Empleado</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Días</th>
                                <th>Observacion</th>
                                <th>Estado</th>
                                <th>Activo</th>
                                <th>Creado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudvacaciones as $solicitudvacacion)
                                <tr>
                                    <td>{{$solicitudvacacion->id}}</td>
                                    <td>{{$solicitudvacacion->empleado}}</td>
                                    <td>{{fecha_latina($solicitudvacacion->fecha_ini)}}</td>
                                    <td>{{fecha_latina($solicitudvacacion->fecha_fin)}}</td>
                                    <td>{{$solicitudvacacion->dias}}</td>
                                    <td>{{$solicitudvacacion->observacion}}</td>
                                    <td>{{$solicitudvacacion->estado}}</td>
                                    <td>
                                        @if ($solicitudvacacion->activo)
                                            <span class="label label-primary">SI</span>
                                        @else
                                            <span class="label label-warning">NO</span>
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($solicitudvacacion->created_at) }}</td>
                                    <td data-texto="{{$solicitudvacacion->empleado}}">
                                        @if($solicitudvacacion->estado=='PENDIENTE')
                                            <a data-ruta="{{route('solicitud_vacaciones.resolver',[$solicitudvacacion->id,1])}}" class="btn-resolver" title="Aprobar"><img width="17px" src="{{asset('img/iconos/aprobado.png')}}" alt="Aprobar"></a>
                                            <a data-ruta="{{route('solicitud_vacaciones.resolver',[$solicitudvacacion->id,0])}}" class="btn-resolver" title="Rechazar"><img width="17px" src="{{asset('img/iconos/rechazado.png')}}" alt="Rechazar"></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        <script>
                            $(document).ready(function(){
                                $('.btn-resolver').click(function(){
                                    var ruta=$(this).data('ruta');
                                    var texto = $(this).closest('td').data('texto');
                                    var resolucionTitulo = $(this).attr('title');
                                    var esResolver = confirm('Esta seguro de "'+resolucionTitulo+'" las vacaciones de "'+texto+'"');
                                    if(esResolver){
                                        location.href=ruta;
                                    }

                                });
                            });
                        </script>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
