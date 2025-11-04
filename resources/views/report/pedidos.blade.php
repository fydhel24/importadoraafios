@extends('adminlte::page')

@section('title', 'Reporte de Pedidos')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0" style="border-radius: 15px;">
            <div class="card-header linear-gradient-nuevo text-white"
                style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h3 class="card-title"><i class="fas fa-user-tag"></i> Reportes de Pedidos</h3>
            </div>
            <div class="card-body" style="background: #f8f9fa;">
            <!-- Formulario de Filtro de Fecha -->
            <form action="{{ route('reporte.pedidos') }}" method="GET" class="form-inline mb-4">
                <div class="form-group mr-3">
                    <label for="start_date" class="mr-2 font-weight-bold">Fecha Inicio:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="form-group mr-3">
                    <label for="end_date" class="mr-2 font-weight-bold">Fecha Fin:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary font-weight-bold mr-2">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <a href="{{ route('reporte.pedidos.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                   class="btn btn-success font-weight-bold" target="_blank">
                    <i class="fas fa-file-pdf"></i> Generar PDF
                </a>
            </form>

            <!-- Resumen de Pedidos -->
            <div class="mb-4 p-3 bg-light rounded shadow-sm">
                <h3 class="text-secondary font-weight-bold">Resumen de Pedidos</h3>
                <ul class="list-unstyled">
                    <li><strong>Total de Pedidos:</strong> {{ $totalPedidos }}</li>
                    <li><strong>Total de Monto Depositado:</strong> {{ number_format($totalMontoDepositado, 2) }} Bs</li>
                    <li><strong>Total de Monto Enviado:</strong> {{ number_format($totalMontoEnviado, 2) }} Bs</li>
                </ul>
            </div>

            <!-- Tabla de Detalles de Pedidos -->
            <div class="table-responsive">
                <table id="pedidos-reporte-table" class="table table-bordered table-striped">
                    <thead class="linear-gradient">
                        <tr>
                            <th>Nombre</th>
                            <th>CI</th>
                            <th>Celular</th>
                            <th>Destino</th>
                            <th>Estado</th>
                            <th>Monto Depósito</th>
                            <th>Monto Enviado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->nombre }}</td>
                                <td>{{ $pedido->ci }}</td>
                                <td>{{ $pedido->celular }}</td>
                                <td>{{ $pedido->destino }}</td>
                                <td>{{ $pedido->estado }}</td>
                                <td>{{ number_format($pedido->monto_deposito, 2) }} Bs</td>
                                <td>{{ number_format($pedido->monto_enviado_pagado, 2) }} Bs</td>
                                <td>{{ $pedido->fecha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pedidos-reporte-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                }
            });
        });
    </script>
@endpush
