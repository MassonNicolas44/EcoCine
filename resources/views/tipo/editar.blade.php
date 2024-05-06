@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificando el tipo de animacion: ') }} "{{ $tipo->descripcion }}" </div>

                @include('include.message')

                <div class="card-body">
                    <form method="POST" action="{{ route('tipo.guardarModificacion') }}">
                        @csrf


                        <input type="hidden" name="idTipo" value="{{$tipo->id}}"/>


                        <div class="row mb-4">
                            <label for="descripcion" class="col-md-3 col-form-label text-md-end">{{ __('Nuevo nombre') }}</label>

                            <div class="col-md-7">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ $tipo->descripcion }}" required autocomplete="descripcion" autofocus>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>         

                        <button type="submit" class="bottonModificar">
                            {{ __('Guardar modificacion') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<br>
<br>
<br>

@include('tipo.tabla')

@endsection
