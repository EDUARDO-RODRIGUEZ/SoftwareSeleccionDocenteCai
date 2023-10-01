@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>{{$parControl['titulo']}}</h2>
    </div>
</div>
<br>
<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("rep_bajas_medicas.index")}}" >
                        <input type="hidden" name="is_buscar" id="is_buscar" value="">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Gestión:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="gestion_id"  id="gestion_id" required="">
                                    <option value="" >-- Seleccione --</option>
                                    @foreach ($gestiones as $gestion)
                                        <option value="{{$gestion->id}}" @if($gestion_id==$gestion->id) selected="" @endif >{{$gestion->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-success " type="button" id="btn-cargar" >Cargar</button>
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
        $('#btn-cargar').click(function(){
            $('#is_buscar').val('ok');
            document.formBuscar.submit();
        });

    });
</script>

<div class="">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Resultados</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Id</th>
                <th>Empleado</th>
                <th>CI</th>
                <th>Cargo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Observaci&oacute;n</th>
            </tr>
            </thead>
            <tbody>
                @if($resultados)
                    @foreach ($resultados as $fila)
                    <tr class="">
                        <td>{{$fila->id}}</td>
                        <td>{{$fila->primer_apellido}} {{$fila->segundo_apellido}} {{$fila->nombres}}</td>
                        <td>{{$fila->ci}}-{{$fila->ci_exp}}</td>
                        <td>{{$fila->cargo}}</td>
                        <td>{{$fila->fecha_ini}}</td>
                        <td>{{$fila->fecha_fin}}</td>
                        <td>{{$fila->observacion}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>

            </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            order: [[ 5, "desc" ]],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv', title: 'ReporteDePlanilla'},
                {extend: 'excel', title: 'ReporteDePlanilla'},
                {extend: 'pdf', title: 'ReporteDePlanilla'},

                {extend: 'print',
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                }
            ]

        });

    });

</script>
@stop
