@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1 class="text-center"><i class="fas fa-store"></i> Apertura de Caja por Sucursales</h1>
@stop

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
    @endif

    <div class="container">
        <h2 class="text-center my-4"><i class="fas fa-map-marker-alt"></i> Sucursales</h2>

        {{-- Botones de acción centralizados --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-5">
                <form action="{{ route('cajas.abrir_todas') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow">
                        <i class="fas fa-unlock"></i> Abrir Todas las Cajas
                    </button>
                </form>
            </div>
            <div class="col-md-5">
                <form action="{{ route('cajas.cerrar_todas') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg w-100 shadow">
                        <i class="fas fa-lock"></i> Cerrar Todas las Cajas
                    </button>
                </form>
            </div>
        </div>

        {{-- Sucursales en tarjetas modernas --}}
        <div class="row">
            @foreach ($sucursales as $sucursal)
                <div class="col-md-4">
                    <div class="card text-center shadow-lg border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-store-alt"></i> {{ $sucursal->nombre }}</h5>
                        </div>
                        <div class="card-body">
                            <img src="https://picsum.photos/id/{{ $loop->index + 1 }}/100" class="rounded-circle mb-3" alt="Sucursal">
                            <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $sucursal->direccion ?? 'Ubicación no disponible' }}</p>

                            @php
                                $cajaAbierta = \App\Models\Caja::whereNull('fecha_cierre')
                                    ->where('sucursal_id', $sucursal->id)
                                    ->first();
                            @endphp

                            @if ($cajaAbierta)
                                <a href="{{ route('cajas.index', $sucursal->id) }}" class="btn btn-success btn-block shadow">
                                    <i class="fas fa-eye"></i> Ver Caja
                                </a>
                            @else
                                <a href="{{ route('cajas.index', $sucursal->id) }}" class="btn btn-info btn-block shadow">
                                    <i class="fas fa-box"></i> Abrir Caja
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn {
            transition: all 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-lg {
            font-size: 1.2rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stop
