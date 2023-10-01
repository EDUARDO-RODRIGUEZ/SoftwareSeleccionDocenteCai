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
                    <a class="btn btn-primary" href="{{route('entrevistas_programadas.procesar')}}">Procesar Entrevistas</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("entrevistas_programadas.index")}}" method="get">
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
                                <th>Entrevistador</th>
                                <th>Curriculum</th>
                                <th>Activo</th>
                                <th>Creado</th>
                                <th>Entrevistado</th>
                                <th>F. Entrevista</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entrevistas_programadas as $entrevista_programada)
                                <tr>
                                    <td>{{$entrevista_programada->id}}</td>
                                    <td>{{$entrevista_programada->persona}}</td>
                                    <td>{{$entrevista_programada->ci}}</td>
                                    <td>{{$entrevista_programada->celular}}</td>
                                    <td>{{$entrevista_programada->convocatoria}}</td>
                                    <td>{{$entrevista_programada->cargo}}</td>
                                    <td>{{$entrevista_programada->entrevistador}}</td>
                                    <td>
                                        @if ($entrevista_programada->curriculum)
                                            <a href="{{asset('curriculum/'.$entrevista_programada->curriculum)}}" target="_blank"> Ver Curriculum</a>    
                                        @endif
                                    </td>
                                    <td>
                                        @if ($entrevista_programada->activo) 
                                            <span class="label label-primary">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($entrevista_programada->created_at) }}</td>
                                    
                                    <td>
                                        @if ($entrevista_programada->entrevista_realizada_id)
                                            <span class="label label-primary">SI</span> 
                                        @else
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($entrevista_programada->fechaEntrevista) }}</td>
                                    <td data-texto="{{$entrevista_programada->id}}">
                                        @if (!$entrevista_programada->entrevista_realizada_id)
                                            <a data-ruta="{{route('entrevistas_programadas.eliminar',$entrevista_programada->id)}}" class="btn-eliminar" title="Eliminar"><img width="17px" src="{{asset('img/iconos/eliminar.png')}}" alt="Eliminar"></a>
                                            <a href="{{route('entrevistas_programadas.entrevista',$entrevista_programada->id)}}" title="Entrevista"><img width="17px" src="{{asset('img/iconos/entrevista.png')}}" ></a>
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
