{{-- resources/views/report/inventario.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reporte de Inventario')

@section('content')
    <div class="container">
        <div class="card shadow-lg border-0" style="border-radius: 15px;">
            <div class="card-header linear-gradient-nuevo text-white"
                style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h3 class="card-title"><i class="fas fa-user-tag"></i> Reportes de Inventario</h3>
            </div>
            <div class="card-body" style="background: #f8f9fa;">
                <!-- Formulario de Filtro de Fecha -->
                <form action="{{ route('report.inventario') }}" method="GET" class="form-inline mb-4">
                    <div class="form-group mr-3">
                        <label for="start_date" class="mr-2 font-weight-bold">Fecha Inicio:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group mr-3">
                        <label for="end_date" class="mr-2 font-weight-bold">Fecha Fin:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <button type="submit" class="btn btn-primary font-weight-bold mr-2">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('report.inventario.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                        class="btn btn-success font-weight-bold" target="_blank">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </a>
                </form>

                <!-- Tabla de Inventario -->
                <div class="table-responsive">
                    <table id="inventario-table" class="table table-bordered table-striped">
                        <thead class="linear-gradient">
                            <tr>
                                <th>ID</th>
                                <th>Fecha modificada</th>
                                <th>Nombre del Producto</th>
                                <th>Sucursal</th>
                                <th>Cantidad</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventarios as $inventario)
                                <tr>
                                    <td>{{ $inventario->id }}</td>
                                    <td>{{ $inventario->updated_at }}</td>
                                    <td>{{ $inventario->producto ? $inventario->producto->nombre : 'No disponible' }}</td>
                                    <td>{{ $inventario->sucursale ? $inventario->sucursale->nombre : 'No disponible' }}</td>
                                    <td>{{ $inventario->cantidad }}</td>
                                    <td>{{ $inventario->user ? $inventario->user->name : 'No disponible' }}</td>
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
            $('#inventario-table').DataTable({
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
