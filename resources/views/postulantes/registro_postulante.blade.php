<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RRHH</title>

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{asset('js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{asset('js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('js/inspinia.js')}}"></script>
    <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{asset('js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- iCheck -->
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- Typehead -->
    <script src="{{asset('js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>

    <script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    
    <script src="{{asset('js/jquery.PrintArea.js')}}"></script>

        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>

</head>
{{-- class="gray-bg"--}} 
<body id="body">
    
<div class="" style="width:1200px; margin: 0px auto">
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            
            <div class="card card-default" style="padding:10px">

                <div class="ibox-content">
                    <div class="row breadcrumb-wrapper">
                        <div class="col-lg-12" style="text-align:center">
                            <h2>Registro de Postulante - {{$cargo->nombre}}</h2>
                        </div>
                    </div>
                    <form action="{{route('postulantes.guardarPostulacion')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="convocatoria_id" value="{{$convocatoria->id}}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombres:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nombres" value="{{old('nombres')}}" required="">
                            </div>
                        </div>
                        @error('nombres')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                        {{-- comienzo --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Primer Apellido:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="primer_apellido" value="{{old('primer_apellido')}}" required="">
                            </div>
                        </div>
                        @error('primer_apellido')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                        {{-- fin --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Segundo Apellido:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="segundo_apellido" value="{{old('segundo_apellido')}}" >
                            </div>
                        </div>
                        @error('segundo_apellido')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Genero:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="genero"  id="genero">
                                    <option value="" @if(old('')=='') selected="" @endif></option>
                                    <option value="M" @if(old('genero')=='M') selected="" @endif>Masculino</option>
                                    <option value="F" @if(old('genero')=='F') selected="" @endif>Femenino</option>
                                    <option value="O" @if(old('ci_exp')=='O') selected="" @endif>Otros</option>
                                    
                                </select>
                            </div>
                        </div>
                        @error('genero')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Carnet de identidad:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ci" value="{{old('ci')}}" required="">
                            </div>
                        </div>
                        @error('ci')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                    
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Expedido:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="ci_exp"  id="ci_exp">
                                    <option value="" @if(old('')=='') selected="" @endif></option>
                                    <option value="CH" @if(old('ci_exp')=='CH') selected="" @endif>Chuquisaca</option>
                                    <option value="LP" @if(old('ci_exp')=='LP') selected="" @endif>La Paz</option>
                                    <option value="CB" @if(old('ci_exp')=='CB') selected="" @endif>Cochabamba</option>
                                    <option value="OR" @if(old('ci_exp')=='OR') selected="" @endif>Oruro</option>
                                    <option value="PT" @if(old('ci_exp')=='PT') selected="" @endif>Potosi</option>
                                    <option value="TJ" @if(old('ci_exp')=='TJ') selected="" @endif>Tarija</option>
                                    <option value="SC" @if(old('ci_exp')=='SC') selected="" @endif>Santa Cruz</option>
                                    <option value="BE" @if(old('ci_exp')=='BE') selected="" @endif>Beni</option>
                                    <option value="PD" @if(old('ci_exp')=='PD') selected="" @endif>Pando</option>
                                    <option value="EXT" @if(old('ci_exp')=='EXT') selected="" @endif>Extranjero</option>
                                    
                                </select>
                            </div>
                        </div>
                        @error('ci_exp')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fecha de nacimiento:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" required="">
                            </div>
                        </div>
                        @error('fecha_nacimiento')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                    
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Celular:<i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="celular" value="{{old('celular')}}" required="">
                            </div>
                        </div>
                        @error('celular')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror
                    
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Telefono:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telefono" value="{{old('telefono')}}" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Direccion:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="direccion" value="{{old('direccion')}}" >
                            </div>
                        </div>
                        @error('direccion')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Correo:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="correo" value="{{old('correo')}}">
                            </div>
                        </div>
                        @error('correo')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                        @enderror

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Curriculum:</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="curriculum" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Audio :</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept="audio/mp3" name="audio" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NOTA:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="Este audio se utilizara para el proceso con inteligencia artificial, al enviar el audio esta usted de acuerdo a que se utilice su audio de voz para dicho proceso" disabled=""></div>
                        </div>

                        @error('curriculum')
                        <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                    @enderror

                    
                        <input type="hidden" name="plantilla_id" value="{{$plantilla->id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Aptitudes</h5>
                                    </div>
                                    <div class="ibox-content">
                                        @foreach ($preguntas as $pregunta)
                                            <div><strong>{{$pregunta->pregunta}}</strong> </div>    
                                            @foreach ($pregunta->respuestas as $respuesta)
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        @if($pregunta->tipo=='SelUnica')
                                                            <div class="i-checks">
                                                                <label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                     <input type="radio" value="{{$respuesta->id}}" name="respuesta_{{$pregunta->id}}"> <i></i>
                                                                     {{$respuesta->respuesta}} 
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="i-checks">
                                                                <label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" value="{{$respuesta->id}}" name="respuesta_{{$pregunta->id}}[]"> <i></i>  
                                                                    {{$respuesta->respuesta}} 
                                                                </label>
                                                            </div>
                                                        @endif
                                                        
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                              
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-success " type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>    
</body>

</html>
