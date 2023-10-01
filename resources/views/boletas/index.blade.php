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
                    <a class="btn btn-primary" href="{{route('boletas.generar')}}">Generar Boletas</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("boletas.index")}}" method="get">
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
                                <th>Haber basico</th>
                                <th>Bono</th>
                                <th>Descuento</th>
                                <th>Anticipo</th>
                                <th>Liquido pagable</th>
                                <th>Periodo</th>
                                <th>Pagado</th>
                                <th>Creado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boletas as $boleta)
                                <tr>
                                    <td>{{$boleta->id}}</td>
                                    <td>{{"$boleta->primer_apellido $boleta->segundo_apellido $boleta->nombres"}}</td>
                                    <td>{{$boleta->haber_basico}}</td>
                                    <td>{{$boleta->bono}}</td>
                                    <td>{{$boleta->descuento}}</td>
                                    <td>{{$boleta->anticipo}}</td>
                                    <td>{{$boleta->liquido_pagable}}</td>
                                    <td>{{$boleta->periodo}}</td>
                                    <td>
                                        @if ($boleta->pagado) 
                                            <span class="label label-success">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($boleta->created_at) }}</td>
                                    <td data-texto="{{"$boleta->primer_apellido $boleta->segundo_apellido $boleta->nombres"}}">
                                        @if (!$boleta->pagado) 
                                            <a href="{{route('boletas.pagar',$boleta->id)}}" title="Pagar Boleta"><img width="17px" src="{{asset('img/iconos/mensualidades.png')}}" alt="PagarBoleta"></a>
                                            <a data-ruta="{{route('boletas.eliminar',$boleta->id)}}" class="btn-eliminar" title="Eliminar"><img width="17px" src="{{asset('img/iconos/eliminar.png')}}" alt="Eliminar"></a>
                                        @else
                                        <a href="{{route('boletas.recibo',$boleta->id)}}" title="Recibo Boleta"><img width="17px" src="{{asset('img/iconos/recibo.png')}}" alt="ReciboBoleta"></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <form name="formEliminar" id="formEliminar"  action="" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Eliminar" hidden="">
                        </form>
                        <script>
                            $(document).ready(function(){
                                $('.btn-eliminar').click(function(){
                                    var ruta=$(this).data('ruta');
                                    var texto = $(this).closest('td').data('texto');
                                    var esEliminar = confirm('Esta seguro de eliminar el registro "'+texto+'"');
                                    if(esEliminar){
                                        $('#formEliminar').attr('action',ruta);
                                        document.formEliminar.submit();
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
