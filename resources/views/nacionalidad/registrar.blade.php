@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ingresar nueva nacionalidad') }}</div>

                @include('include.message')

                <div class="card-body">
                    <form method="POST" action="{{ route('nacionalidad.guardarRegistro') }}">
                        @csrf

                        <div class="row mb-4">
                            <label for="descripcion" class="col-md-3 col-form-label text-md-end">{{ __('Descripcion') }}</label>

                            <div class="col-md-7">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="sigla" class="col-md-3 col-form-label text-md-end">{{ __('Sigla') }}</label>

                            <div class="col-md-7">
                                <input id="sigla" type="text" class="form-control @error('sigla') is-invalid @enderror" name="sigla" value="{{ old('sigla') }}" required autocomplete="sigla" autofocus>

                                @error('sigla')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
          
                        <button type="submit" class="bottonIngresar">
                            {{ __('Ingresar nacionalidad') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
