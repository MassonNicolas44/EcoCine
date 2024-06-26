<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Reservas registradas de la sala '.$sala->nombre.' y pelicula '.$pelicula->nombre.'') }} </div>
                    <div class="card-body">   

                        {{-- Verificacion si hay datos para mostrar o no --}}
                        @if(count($datosReserva)>0)             
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align:center;">
                                <thead>
                                    <th>Sala</th>
                                    <th>Pelicula</th>
                                    <th>Fecha funcion</th>
                                    <th>Hora funcion</th>
                                    <th>Fecha de reserva</th>
                                    <th>Cantidad boletos</th>
                                    <th>Precio final</th>
                                </thead>
                                <tbody>
                                    @foreach($datosReserva as $reserva)
                                        <?php
                                            //Formateo de fecha para visualizacion mas amigable
                                            $fechaFuncion=date('d-m-Y',strtotime($reserva->fecha_funcion));
                                            $hora=(new DateTime($reserva->hora_funcion))->format('H:i');

                                            $fechaReserva=date('d-m-Y',strtotime($reserva->created_at));
                                            $horaReserva=(new DateTime($reserva->created_at))->format('H:i');
                                        ?>

                                        <tr>
                                            <td>{{$reserva->funcion->sala->nombre}}</td>
                                            <td>{{$reserva->funcion->pelicula->nombre}}</td>
                                            <td>{{$fechaFuncion}}</td>
                                            <td>{{$hora}} Hs</td>
                                            <td>{{$fechaReserva}}  [{{$horaReserva}} Hs]</td>
                                            <td>{{$reserva->cantidad_boleto}}</td>
                                            <td>{{$reserva->precio_final}} $</td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        @else
                            <div class="mensaje">
                                No hay reservas aun
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>