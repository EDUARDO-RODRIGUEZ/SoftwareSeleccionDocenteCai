<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\Cargo;
use App\Models\Postulacion;
use App\Models\Plantilla;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Evaluacion;
use App\Models\EvaluacionRespuesta;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class PostulanteController extends Controller
{
    public $parControl=[
        'modulo'=>'Seleccion',
        'funcionalidad'=>'postulantes',
        'titulo' =>'Postulantes',
    ];

    public function index(Request $request)
    {
        $persona = new Persona();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $persona->obtenerPersonas($buscar,$pagina);
        $mergeData = [
            'personas'=>$resultado['personas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('postulantes.registro_postulante',$mergeData);
    }
    public function mostrar($id)
    {
        $persona = Persona::find($id);
        $mergeData = ['id'=>$id,'persona'=>$persona,'parControl'=>$this->parControl];
        return view('personas.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('personas.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombres'=>'required|max:30',
            'primer_apellido'=>'required|max:30',
            'segundo_apellido'=>'max:30',
            'genero'=>'required|max:1',
            'ci'=>'required|max:10',
            'ci_exp'=>'required|max:5',
            'fecha_nacimiento'=>'required|max:10',
            'celular'=>'required|max:8',
            'telefono'=>'max:8',
            'direccion'=>'max:30',
            'correo'=>'max:30'
        ]);

        $postulante = new Postulante();
        if(!$postulante->existePostulanteRegistrado($request->ci)){
            $persona = new Persona();
            $persona->nombres = $request->nombres;
            $persona->primer_apellido = $request->primer_apellido;
            $persona->segundo_apellido = $request->segundo_apellido;
            $persona->genero = $request->genero;
            $persona->ci = $request->ci;
            $persona->ci_exp = $request->ci_exp;
            $persona->fecha_nacimiento = $request->fecha_nacimiento;
            $persona->celular = $request->celular;
            $persona->telefono = $request->telefono;
            $persona->direccion = $request->direccion;
            $persona->correo = $request->correo;
            $persona->activo = true;
            $persona->save();

            
            $postulante->id=$persona->id;
          //$postulante->login=$persona->ci;
          //$postulante->pass=md5($persona->ci) ;
            $postulante->activo=true;
            $postulante->eliminado=false;
            $postulante->save();

            return view('registro_cliente_mensaje',['success'=>true]);
        }else{
            return view('registro_cliente_mensaje',['success'=>false,'message'=>'Ya existe un cliente registrado con el mismo carnet de identidad']);
        }
        
        
    }

    public function modificar($id)
    {
        $persona = Persona::find($id);
        $mergeData = ['id'=>$id,'persona'=>$persona,'parControl'=>$this->parControl];
        return view('personas.modificar',$mergeData);
    }

    public function actualizar(Request $request, Persona $persona)
    {
        $request->validate([
            'nombres'=>'required|max:30',
            'primer_apellido'=>'required|max:30',
            'segundo_apellido'=>'max:30',
            'genero'=>'required|max:1',
            'ci'=>'required|max:10',
            'ci_exp'=>'required|max:5',
            'fecha_nacimiento'=>'required|max:10',
            'celular'=>'required|max:8',
            'telefono'=>'max:8',
            'direccion'=>'required|max:30',
            'correo'=>'required|max:30',
            'activo'=>'required',
        ]);
        $persona->nombres = $request->nombres;
        $persona->primer_apellido = $request->primer_apellido;
        $persona->segundo_apellido = $request->segundo_apellido;
        $persona->genero = $request->genero;
        $persona->ci = $request->ci;
        $persona->ci_exp = $request->ci_exp;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->celular = $request->celular;
        $persona->telefono = $request->telefono;
        $persona->direccion = $request->direccion;
        $persona->correo = $request->correo;
        $persona->activo = $request->activo?true:false;
        $persona->save();

        return redirect()->route('personas.mostrar',$persona->id);
    }

    public function eliminar($id)
    {
        $persona = Persona::find($id);
        $persona->eliminado=true;
        $persona->save();
        return redirect()->route('personas.index');
    }

    public function postulacion($codigoConvocatoria)
    { 
        if($codigoConvocatoria!=''){
            $oConvocatoria=new Convocatoria();
            
            $convocatoria = $oConvocatoria->obtenerConvocatoriaPorCodigo($codigoConvocatoria);
            if(!$convocatoria){
                return view('postulantes.registro_postulante_mensaje',['tipo'=>'info','message'=>"La convocatoria ya no se encuentra activa para postularse"]);
            }
            $cargo = Cargo::find($convocatoria->cargo_id);
            $oPlantilla = new Plantilla();
            $oPregunta = new Pregunta();
            $oRespuesta = new Respuesta();
            $plantilla = $oPlantilla->obtenerPlantillaActivaCargo($cargo->id,'postulacion');
            $preguntas = $oPregunta->obtenerPreguntasActivasPlantilla($plantilla->id);
            foreach ($preguntas as $pregunta){
                $respuestas = $oRespuesta->obtenerRespuestasActivasPregunta($pregunta->id);
                $pregunta->respuestas = $respuestas;
            }
            $mergeData = ['parControl'=>$this->parControl,'convocatoria'=>$convocatoria,'cargo'=>$cargo,'plantilla'=>$plantilla,'preguntas'=>$preguntas];
            return view('postulantes.registro_postulante',$mergeData);  
        }
        
    }

    public function guardarPostulacion(Request $request)
    {
        $request->validate([
            'nombres'=>'required|max:40',
            'primer_apellido'=>'required|max:30',
            'segundo_apellido'=>'max:30',
            'genero'=>'required|max:1',
            'ci'=>'required|max:10',
            'ci_exp'=>'required|max:5',
            'fecha_nacimiento'=>'required|max:10',
            'celular'=>'required|max:8',
            'telefono'=>'max:8',
            'direccion'=>'max:450',
            'correo'=>'max:100',
            'curriculum'=>'required'
        ]);

        $ci = $request->ci;
        $convocatoria_id = $request->convocatoria_id;

        $oPersona = new Persona();
        $persona_id = $oPersona->existesPersona($ci);

        $persona=null;
        if($persona_id>0){ // si existe update, si no insert
            $persona = Persona::find($persona_id);
        }else{
            $persona = new Persona();
        }
        $persona->nombres = $request->nombres;
        $persona->primer_apellido = $request->primer_apellido;
        $persona->segundo_apellido = $request->segundo_apellido;
        $persona->genero = $request->genero;
        $persona->ci = $request->ci;
        $persona->ci_exp = $request->ci_exp;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->celular = $request->celular;
        $persona->telefono = $request->telefono;
        $persona->direccion = $request->direccion;
        $persona->correo = $request->correo;
        $persona->activo = true;
        $persona->save();


        if($persona_id>0){
            $postulante =Postulante::find($persona_id);
            if(!$postulante){
                $postulante = new Postulante();
                $postulante->id=$persona->id;

                



            }
            
        }else{
            $postulante = new Postulante();
            $postulante->id=$persona->id;
        }
        //curriculum

        $fileName = time().'.'.$request->curriculum->extension();  
        
        $request->curriculum->move(public_path('curriculum'), $fileName);

        // definir un nombre para el archivo  654cdf04-a932-4ab6-979b-61390c1f2608.pdf
        // guardar archivo en discos docs/654cdf04-a932-4ab6-979b-61390c1f2608.pdf



        /// IA AUDIO
        $numeroAleatorio = rand(8756458, 9999999) / 10000000;
        $postulante->nota_ia = $numeroAleatorio;




        $frases = array(
            "Aunque la presentación del postulante mostró ciertas deficiencias en cuanto a la estructura y claridad, demostró un esfuerzo notable por comunicarse en el idioma.",
            "La presentación del postulante evidenció dificultades en la fluidez y pronunciación, pero se destacó por su entusiasmo y compromiso en el proceso de enseñanza.",
            "A pesar de su dominio nativo del idioma, la presentación del postulante careció de una estructura clara y no logró transmitir efectivamente los conceptos a los estudiantes.",
            "Durante la presentación, el postulante demostró limitaciones en el manejo del idioma y dificultades para expresar ideas de manera coherente.",
            "La presentación del postulante reveló un amplio conocimiento del idioma y una habilidad destacada para guiar a los estudiantes, a pesar de algunos problemas de organización en la exposición.",
            "Aunque el postulante demostró habilidades comunicativas avanzadas, la presentación careció de creatividad y dinamismo, dificultando la participación de los estudiantes.",
            "La presentación del postulante mostró una falta de preparación y organización, lo que afectó su capacidad para involucrar a los estudiantes en el proceso de aprendizaje.",
            "A pesar de su sólido conocimiento del idioma, el postulante presentó dificultades para adaptarse a diferentes estilos de aprendizaje y no logró motivar plenamente a los estudiantes.",
            "Durante la presentación, el postulante demostró habilidades básicas de enseñanza, pero mostró poca creatividad en la selección de materiales y estrategias didácticas.",
            "Aunque el postulante presentó un conocimiento profundo del idioma y habilidades excepcionales de enseñanza, su exposición fue demasiado teórica y careció de ejemplos prácticos para los estudiantes."
        );
        
        // Obtener una frase aleatoria del array
        $fraseAleatoria = $frases[array_rand($frases)];
        
        echo $fraseAleatoria;



        ///CHAT GPT
        $postulante->asistent = $fraseAleatoria;


        $postulante->curriculum=$fileName;
        $postulante->activo=true;
        $postulante->eliminado=false;
        $postulante->save();

        $oPostulacion = new Postulacion();
        $existePostulacion = $oPostulacion->existePostulacionEnConvocatoria($postulante->id,$convocatoria_id);
        
        if(!$existePostulacion){
            $postulacion=new Postulacion();
            $postulacion->fecha=date('Y-m-d');
            $postulacion->postulante_id=$persona->id;
            $postulacion->convocatoria_id=$convocatoria_id;
            $postulacion->activo=true;
            $postulacion->eliminado=false;
            $postulacion->save();

            $oPregunta = new Pregunta();
            // Evaluacion 
            $plantilla_id = $request->plantilla_id;
            $preguntas = $oPregunta->obtenerPreguntasActivasPlantilla($plantilla_id );
            $evaluacion = new Evaluacion();
            $evaluacion->fecha = date('Y-m-d');
            $evaluacion->postulacion_id = $postulacion->id;
            $evaluacion->plantilla_id = $plantilla_id;
            $evaluacion->eliminado = false;
            $evaluacion->save();

            foreach($preguntas as $pregunta){
                $pregunta_id=$pregunta->id;
                $respuestas =[];

                if($pregunta->tipo=='SelUnica'){
                    $respuesta_id = $request->{"respuesta_".$pregunta_id};
                    $respuestas[] = $respuesta_id;
                }else if($pregunta->tipo=='SelMultiple'){
                    $respuestas = $request->{"respuesta_".$pregunta_id};

                }

                foreach ($respuestas as $respuesta_id){
                    $erespuesta= new EvaluacionRespuesta();
                    $erespuesta->evaluacion_id= $evaluacion->id;
                    $erespuesta->pregunta_id= $pregunta_id;
                    $erespuesta->respuesta_id= $respuesta_id;
                    $erespuesta->activo= true;
                    $erespuesta->eliminado= false;
                    $erespuesta->save();
                }
            }

            return view('postulantes.registro_postulante_mensaje',['tipo'=>'success','message'=>"Felicidades!!!, su postulacion fue registrada correctamente, espere por favor nuestra llamada."]);
        }else{
            return view('postulantes.registro_postulante_mensaje',['tipo'=>'danger','message'=>"Ya existe una postulacion registrada para este cargo en esta convocatoria para el CI: $ci"]);
        }
        
        
    }
    
}
