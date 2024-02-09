@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Listado de Actores') }}</div>

                <div class="container-avatar">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
        
                    @endif
                </div>

                <div class="card-body">

                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align:center;">
                                <thead>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Nacionalidad</th>
                                    <th>Accion</th>
                                </thead>

                                <tbody>
                                    @foreach($actores as $actor)
                                        <tr>
                                            <td>{{$actor->id}}</td>
                                            <td>{{$actor->apellido}} {{$actor->nombre}}</td>
                                            <td>[{{$actor->nacionalidad->sigla}}] {{$actor->nacionalidad->descripcion}}</td>
                                            <td>
                                                <div class="list">
                                                    <a href="{{ route('actor.editar',['id'=>$actor->id]) }}" ="sucess" class="btn btn-warning btn-sm"> Editar</a>
                                                    <a href="{{ route('actor.eliminar',['id'=>$actor->id]) }}"="sucess" class="btn  btn-danger btn-sm">Eliminar</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
