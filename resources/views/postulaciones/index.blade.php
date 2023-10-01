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
                    <a class="btn btn-primary" href="{{route('postulaciones.procesar')}}">Procesar Postulaciones</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("postulaciones.index")}}" method="get">
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
                                <th>Postulante</th>
                                <th>CI</th>
                                <th>Celular</th>
                                <th>Convocatoria</th>
                                <th>Cargo</th>
                                <th>Curriculum</th>
                                <th>Activo</th>
                                <th>Creado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($postulaciones as $postulacion)
                                <tr>
                                    <td>{{$postulacion->id}}</td>
                                    <td>{{$postulacion->persona}}</td>
                                    <td>{{$postulacion->ci}}</td>
                                    <td>{{$postulacion->celular}}</td>
                                    <td>{{$postulacion->convocatoria}}</td>
                                    <td>{{$postulacion->cargo}}</td>
                                    <td>
                                        @if ($postulacion->curriculum)
                                            <a href="{{asset('curriculum/'.$postulacion->curriculum)}}" target="_blank"> Ver Curriculum</a>    
                                        @endif
                                    </td>
                                    <td>
                                        @if ($postulacion->activo) 
                                            <span class="label label-primary">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($postulacion->created_at) }}</td>
                                    <td data-texto="{{$postulacion->id}}">
                                        
                                        <a data-ruta="{{route('postulaciones.eliminar',$postulacion->id)}}" class="btn-eliminar" title="Eliminar"><img width="17px" src="{{asset('img/iconos/eliminar.png')}}" alt="Eliminar"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                                         
                    </table>
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
                </div>
            </div>
        </div>
    </div>
</div>
@stop
