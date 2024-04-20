<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;

use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
use App\Models\Reserva;


class ReservaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registrar(Request $request)
    {

        $idPelicula=$request->input('idPelicula');
        $idSala=$request->input('idSala');
        $fecha=$request->input('fecha');

        //Trae la lista de funciones con la fecha seleccionada de la pelicula seleccionada desde la Base de Datos
        $funciones=Funcion::where('id_Pelicula',$idPelicula)
        ->where('id_Sala',$idSala)
        ->where('fecha',$fecha)
        ->orderby('id_Pelicula','asc')->get();

                                                         
        //Array de los dias la busqueda de horario
        $nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

        $fechaDia = (new DateTime($fecha))->format("w");

        //Traemos el nombre del dia
        $dia=$nombresDias[$fechaDia];


        $horarios=array();

        foreach($funciones as $funcion){

            //Verificacion de dia, para ver que horario estan disponibles
            if($dia=="Lunes" || $dia=="Martes" || $dia=="Miercoles" || $dia=="Jueves" || $dia=="Viernes"){
                if(!empty($funcion->lvhorario1)){
                    $lvhorario1=(new DateTime($funcion->lvhorario1))->format('H:i');
                    array_push($horarios, $lvhorario1 );
                }
                if(!empty($funcion->lvhorario2)){
                    $lvhorario2=(new DateTime($funcion->lvhorario2))->format('H:i');
                    array_push($horarios, $lvhorario2 );
                }
                if(!empty($funcion->lvhorario3)){
                    $lvhorario3=(new DateTime($funcion->lvhorario3))->format('H:i');
                    array_push($horarios, $lvhorario3 );
                }
                if(!empty($funcion->lvhorario4)){
                    $lvhorario4=(new DateTime($funcion->lvhorario4))->format('H:i');
                    array_push($horarios, $lvhorario4 );
                }

            }else{

                if(!empty($funcion->sdhorario1)){
                    $sdhorario1=(new DateTime($funcion->sdhorario1))->format('H:i');
                    array_push($horarios, $sdhorario1 );
                }
                if(!empty($funcion->sdhorario2)){
                    $sdhorario2=(new DateTime($funcion->sdhorario2))->format('H:i');
                    array_push($horarios, $sdhorario2 );
                }
                if(!empty($funcion->sdhorario3)){
                    $sdhorario3=(new DateTime($funcion->sdhorario3))->format('H:i');
                    array_push($horarios, $sdhorario3 );
                }
                if(!empty($funcion->sdhorario4)){
                    $sdhorario4=(new DateTime($funcion->sdhorario4))->format('H:i');
                    array_push($horarios, $sdhorario4 );
                }
            }

            //Guardo el id de la funcion para luego utilizarlo en la busqueda de reserva
            $idFuncion=$funcion->id;
        }

        if(empty($horarios)){
            array_push($horarios, "Sin Horario" );
        }

        //Trae la pelicula seleccionada
        $pelicula=Pelicula::select('nombre')->where('id',$idPelicula)->first();

        //Formateo de fecha para visualizacion mas amigable
        $fecha=date('d-m-Y',strtotime($fecha));

        //Trae la lista de reservas para la pelicula, sala y fecha seleccionada
        $datosReserva=Reserva::select('*')
                                ->where('id_Funcion',$idFuncion)
                                ->where('estado',"Habilitada")
                                ->orderBy('hora_funcion','asc')
                                ->get();
        
        //Retorna a la vista, las funciones habilitadas para esa fecha en particular
        return view('reserva.registrar',['funciones'=>$funciones,'pelicula'=>$pelicula,'fecha'=>$fecha,'horarios'=>$horarios,'datosReserva'=>$datosReserva]);
    }


    public function guardarRegistro(Request $request)
    {

        //Validacion de datos antes de cargar
       $validate = $this->validate($request, [
        'idFuncion' => ['required'],
        'horario' => ['required'],
        'cantBoleto' => ['required'],
        'errorPelicula' => ['required'],
        'errorFecha' => ['required'],
        ] );

        //Se obtienen los datos
        $idFuncion = $request->input('idFuncion');  
        $horario = $request->input('horario');   
        $cantidadBoleto = $request->input('cantBoleto');   

        //Se buscan los datos de la funcion
        $datosFuncion=Funcion::where('id',$idFuncion)->first();

        //Total de boletos reservados para la fecha y hora en particular
        $totalBoletoReservados=Reserva::where("fecha_funcion",$datosFuncion->fecha)
                                      ->where("hora_funcion",$horario)
                                      ->where('estado',"Habilitada")
                                      ->sum("cantidad_boleto");

        //Boletos disponibles para la sala
        $cantBoletoSala=$datosFuncion->sala->cantidad_asiento;

        //Boletos a reservar
        $cantBoletoReservado=$cantidadBoleto;

        $cantBoletoDisponible=$cantBoletoSala-$totalBoletoReservados-$cantBoletoReservado;

        //Si se pueden reservar la cantidad de boletos ingresados, procede a generar la compra
        if($cantBoletoDisponible>=0){

            //Cargar valores
            $reserva = new Reserva();

            $reserva->id_Funcion=$idFuncion;
            $reserva->fecha_funcion=$datosFuncion->fecha;
            $reserva->hora_funcion=$horario;
            $reserva->cantidad_boleto=$cantidadBoleto;
            $reserva->estado="Habilitada";
    
            $reserva->save();

            //Redireccion a la finalizacion de la reserva
            return redirect()->route('reserva.reservaCompleta',['idReserva'=>$reserva->id]);

        }else{

            //En caso de error al registrar los boletos, se utilizan las variables para recargar la pagina
            $errorPelicula = $request->input('errorPelicula');   
            $errorFecha = $request->input('errorFecha');  

            //Formateo de fecha para la busqueda de la funcion
            $errorFecha=date('Y-m-d',strtotime($errorFecha));

            //Trae la pelicula seleccionada
            $pelicula=Pelicula::select('*')->where('nombre',$errorPelicula)->first();

            //Trae la lista de funciones con la fecha seleccionada de la pelicula seleccionada desde la Base de Datos
            $funciones=Funcion::where('id_Pelicula',$pelicula->id)
            ->where('fecha',$errorFecha)
            ->orderby('id_Pelicula','asc')->get();


            $horarios=array();

    
            foreach($funciones as $aa){

                if(!empty($aa->lvhorario1)){
                    $lvhorario1=(new DateTime($aa->lvhorario1))->format('H:i');
                    array_push($horarios, $lvhorario1 );
                }
                if(!empty($aa->lvhorario2)){
                    $lvhorario2=(new DateTime($aa->lvhorario2))->format('H:i');
                    array_push($horarios, $lvhorario2 );
                }
                if(!empty($aa->lvhorario3)){
                    $lvhorario3=(new DateTime($aa->lvhorario3))->format('H:i');
                    array_push($horarios, $lvhorario3 );
                }
                if(!empty($aa->lvhorario4)){
                    $lvhorario4=(new DateTime($aa->lvhorario4))->format('H:i');
                    array_push($horarios, $lvhorario4 );
                }

                if(!empty($aa->sdhorario1)){
                    $sdhorario1=(new DateTime($aa->sdhorario1))->format('H:i');
                    array_push($horarios, $sdhorario1 );
                }
                if(!empty($aa->sdhorario2)){
                    $sdhorario2=(new DateTime($aa->sdhorario2))->format('H:i');
                    array_push($horarios, $sdhorario2 );
                }
                if(!empty($aa->sdhorario3)){
                    $sdhorario3=(new DateTime($aa->sdhorario3))->format('H:i');
                    array_push($horarios, $sdhorario3 );
                }
                if(!empty($aa->sdhorario4)){
                    $sdhorario4=(new DateTime($aa->sdhorario4))->format('H:i');
                    array_push($horarios, $sdhorario4 );
                }

                //Guardo el id de la funcion para luego utilizarlo en la busqueda de reserva
                $idFuncion=$aa->id;
            }

            if(empty($horarios)){
                array_push($horarios, "Sin Horario" );
            }

            //Formateo de fecha para visualizacion mas amigable
            $errorFecha=date('d-m-Y',strtotime($errorFecha));

            //Trae la lista de reservas para la pelicula, sala y fecha seleccionada
            $datosReserva=Reserva::select('*')
                                    ->where('id_Funcion',$idFuncion)
                                    ->where('estado',"Habilitada")
                                    ->orderBy('hora_funcion','asc')
                                    ->get();

            $message="Boletos insuficientes, disminuya la cantidad de boletos o seleccione otra fecha/horario";

            //Recarga la vista mostrando el mensaje de error (message)
            return view('reserva.registrar',['funciones'=>$funciones,'pelicula'=>$pelicula,'fecha'=>$errorFecha,'horarios'=>$horarios,'datosReserva'=>$datosReserva,'message'=>$message]);

        }
    }

    public function reservaCompleta($idReserva)
    {

        //Trae los datos de la reserva confirmada
        $reserva=Reserva::find($idReserva);

        //Retorna a la vista, los datos de la reserva confirmada
        return view('reserva.reservaCompleta',['reserva'=>$reserva]);
    }


    public function estado($id,$estado){

        //Se buscan los datos de la pelicula a editar el estado
        $reserva=Reserva::find($id);

        //Se comprueba si el estado es "Habilitar" se actualiza el estado a "Habilitada"
        if($estado=="Habilitar"){
            $reserva->estado="Habilitada";
        }

        //Se comprueba si el estado es "Inhabilitar" se actualiza el estado a "Inhabilitada"
        if($estado=="Inhabilitar"){
            $reserva->estado="Inhabilitada";
        }

        $reserva->update();

        //Redireccion al listado de peliculas
        return redirect()->route('reserva.lista')->with(['message' => 'La reserva '.$reserva->id.' fue '.$reserva->estado.' correctamente']);


    }

    public function lista(Request $request)
    {

        //Trae la lista de peliculas y salas habilitada
        $peliculas=Pelicula::all();
        $salas=Sala::where("estado","Habilitada")->get();

        //Se obtienen los valores
        $peliculaBuscar=$request->input('id_Pelicula');
        $salaBuscar=$request->input('id_Sala');
        $fechaFuncionBuscar=$request->input('fechaFuncion');
        $fechaReservaBuscar=$request->input('fechaReserva');

        //Trae la lista de funciones filtrando por la pelicula y/o sala a buscar
        $funciones=Funcion::where('id_Pelicula','LIKE',$peliculaBuscar)
                    ->where('id_Sala','LIKE',$salaBuscar)
                    ->orderby('id','asc')->get();

        //Inicializo array para guardar las reservas con las filtraciones indicadas, para ser moestradas en la tabla
        $arrayReserva=array();

        //Recorre las funciones recuperadas anteriormente
        foreach($funciones as $funcion){

            //Si busca por fecha de reserva, la consulta del Where debe ser WhereDate por el formato del created_at
            if(empty($fechaReservaBuscar)){
                //Trae la lista de reservas filtrando por las funciones buscadas anteriormente, agregandole el filtrado por fecha de funcion y/o fecha de reserva
                $reservas=Reserva::where('id_Funcion','LIKE',$funcion->id)
                ->where('fecha_funcion','LIKE',$fechaFuncionBuscar)
                ->get();
            }else{
                //Trae la lista de reservas filtrando por las funciones buscadas anteriormente, agregandole el filtrado por fecha de funcion y/o fecha de reserva
                $reservas=Reserva::where('id_Funcion','LIKE',$funcion->id)
                ->where('fecha_funcion','LIKE',$fechaFuncionBuscar)
                ->whereDate('created_at','LIKE',$fechaReservaBuscar)
                ->get();
            }
            
            //Comprobacion de que el objeto recuperado tiene contenido
            if(count($reservas)>0){

                //Recorre los objetos recuperados, añandiendo cada uno al array de reserva
                foreach($reservas as $reserva){
                    array_push($arrayReserva, $reserva);
                }
            }
        }     

        //Retorna a la vista las reservas registradas
        return view('reserva.lista',['arrayReserva'=>$arrayReserva,'peliculas'=>$peliculas,'salas'=>$salas]);

    }

}
