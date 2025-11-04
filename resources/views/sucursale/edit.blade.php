@extends('adminlte::page')

@section('title', __('Editar Sucursal'))

@section('content_header')
    <h1>{{ __('Editar Sucursal') }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-store me-2"></i>{{ __('Actualizar Sucursal') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('sucursales.update', $sucursale->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text"
                                           name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $sucursale->nombre) }}"
                                           id="nombre"
                                           placeholder="{{ __('Nombre de la sucursal') }}"
                                           required>
                                </div>
                                @error('nombre')
                                    <div class="text-danger mt-1"><small><strong>{{ $message }}</strong></small></div>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="mb-3">
                                <label for="direccion" class="form-label">{{ __('Dirección') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text"
                                           name="direccion"
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           value="{{ old('direccion', $sucursale->direccion) }}"
                                           id="direccion"
                                           placeholder="{{ __('Dirección completa') }}"
                                           required>
                                </div>
                                @error('direccion')
                                    <div class="text-danger mt-1"><small><strong>{{ $message }}</strong></small></div>
                                @enderror
                            </div>

                            <!-- Celular -->
                            <div class="mb-3">
                                <label for="celular" class="form-label">{{ __('Celular') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text"
                                           name="celular"
                                           class="form-control @error('celular') is-invalid @enderror"
                                           value="{{ old('celular', $sucursale->celular) }}"
                                           id="celular"
                                           placeholder="{{ __('Número de contacto') }}"
                                           required>
                                </div>
                                @error('celular')
                                    <div class="text-danger mt-1"><small><strong>{{ $message }}</strong></small></div>
                                @enderror
                            </div>

                            <!-- Estado -->
                            <div class="mb-3">
                                <label for="estado" class="form-label">{{ __('Estado') }}</label>
                                <select name="estado"
                                        class="form-control @error('estado') is-invalid @enderror"
                                        id="estado"
                                        required>
                                    <option value="">{{ __('Seleccione un estado') }}</option>
                                    <option value="activo" {{ old('estado', $sucursale->estado) == 'activo' ? 'selected' : '' }}>
                                        {{ __('Activo') }}
                                    </option>
                                    <option value="inactivo" {{ old('estado', $sucursale->estado) == 'inactivo' ? 'selected' : '' }}>
                                        {{ __('Inactivo') }}
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="text-danger mt-1"><small><strong>{{ $message }}</strong></small></div>
                                @enderror
                            </div>

                            <!-- Logo -->
                            <div class="mb-3">
                                <label for="logo" class="form-label">{{ __('Logo') }}</label>
                                <input type="file"
                                       name="logo"
                                       class="form-control @error('logo') is-invalid @enderror"
                                       id="logo"
                                       accept="image/*">
                                @error('logo')
                                    <div class="text-danger mt-1"><small><strong>{{ $message }}</strong></small></div>
                                @enderror
                                <small class="form-text text-muted">{{ __('Dejar en blanco para conservar el actual. Formatos: JPG, PNG. Máx. 2MB.') }}</small>
                            </div>

                            <!-- Vista previa del logo actual -->
                            @if($sucursale->logo)
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Logo actual') }}</label>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $sucursale->logo) }}"
                                             alt="Logo actual"
                                             class="img-thumbnail me-2"
                                             style="max-height: 80px; max-width: 80px;">
                                        <span class="text-muted">{{ __('(Se mantendrá si no subes uno nuevo)') }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Botón Enviar -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>{{ __('Actualizar Sucursal') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
