@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ingresar nueva pelicula') }}</div>

                @include('include.message')

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('pelicula.guardarRegistro') }}">
                        @csrf

                        <div class="row mb-4">
                            <label for="nombre" class="col-md-3 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-7">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="row mb-4">
                            <label for="año" class="col-md-3 col-form-label text-md-end">{{ __('Año') }}</label>

                            <div class="col-md-7">
                                <input id="año" type="number" class="form-control @error('año') is-invalid @enderror" name="año" value="{{ old('año') }}" required autocomplete="año" autofocus>

                                @error('año')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

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
                            <label for="categoria" class="col-md-3 col-form-label text-md-end">{{ __('Categoria') }}</label>

                            <div class="col-md-7">
                                <select id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" value="{{ old('categoria') }}" required autocomplete="categoria" autofocus>

                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria['id'] }}">{{ $categoria->descripcion }}</option>
                                    @endforeach

                                </select>

                                @error('categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  


                        <div class="row mb-4">
                            <label for="nacionalidad" class="col-md-3 col-form-label text-md-end">{{ __('Nacionalidad') }}</label>

                            <div class="col-md-7">
                                <select id="nacionalidad" type="text" class="form-control @error('nacionalidad') is-invalid @enderror" name="nacionalidad" value="{{ old('nacionalidad') }}" required autocomplete="nacionalidad" autofocus>

                                    @foreach($nacionalidades as $nacionalidad)
                                        <option value="{{ $nacionalidad['id'] }}">[{{ $nacionalidad->sigla }}] {{ $nacionalidad->descripcion }}</option>
                                    @endforeach

                                </select>

                                @error('nacionalidad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  


                        <div class="row mb-4">
                            <label for="idioma" class="col-md-3 col-form-label text-md-end">{{ __('Idioma') }}</label>

                            <div class="col-md-7">
                                <select id="idioma" type="text" class="form-control @error('idioma') is-invalid @enderror" name="idioma" value="{{ old('idioma') }}" required autocomplete="idioma" autofocus>

                                    @foreach($idiomas as $idioma)
                                        <option value="{{ $idioma['id'] }}">{{ $idioma->descripcion }}</option>
                                    @endforeach

                                </select>

                                @error('idioma')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  

                        <div class="row mb-4">
                            <label for="tipo" class="col-md-3 col-form-label text-md-end">{{ __('Tipo') }}</label>

                            <div class="col-md-7">
                                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required autocomplete="tipo" autofocus>

                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo['id'] }}">{{ $tipo->descripcion }}</option>
                                    @endforeach

                                </select>

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  

                        <div class="row mb-4">
                            <label for="restriccion" class="col-md-3 col-form-label text-md-end">{{ __('Restriccion') }}</label>

                            <div class="col-md-7">
                                <select id="restriccion" type="text" class="form-control @error('restriccion') is-invalid @enderror" name="restriccion" value="{{ old('restriccion') }}" required autocomplete="restriccion" autofocus>

                                    @foreach($restricciones as $restriccion)
                                        <option value="{{ $restriccion['id'] }}">{{ $restriccion->descripcion }}</option>
                                    @endforeach

                                </select>

                                @error('restriccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  

                        <div class="row mb-4">
                            <label for="duracion" class="col-md-3 col-form-label text-md-end">{{ __('Duracion (Min)') }}</label>

                            <div class="col-md-7">
                                <input id="duracion" type="number" class="form-control @error('duracion') is-invalid @enderror" name="duracion" value="{{ old('duracion') }}" required autocomplete="duracion" autofocus>

                                @error('duracion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="row mb-4">
                            <label for="precio" class="col-md-3 col-form-label text-md-end">{{ __('Precio ($)') }}</label>

                            <div class="col-md-7">
                                <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" required autocomplete="precio" autofocus>

                                @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    
                        
                        <div class="row mb-4">
                            <label for="url" class="col-md-3 col-form-label text-md-end">{{ __('Url') }}</label>

                            <div class="col-md-7">
                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required autocomplete="url" autofocus>

                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="row mb-4">
                            <label for="imagen" class="col-md-3 col-form-label text-md-end">{{ __('Imagen') }}</label>

                            <div class="col-md-7">
                                <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen" value="{{ old('imagen') }}"  autocomplete="imagen" autofocus>

                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>     

                        <button type="submit" class="bottonIngresar">
                            {{ __('Ingresar pelicula') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
