@extends('adminlte::page')

@section('title', 'Cajas')

@section('content_header')
    <h1>Caja - {{ $sucursal->nombre }}</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header text-white">
                @if ($cajaAbierta)
                    <button class="btn btn-success" disabled>
                        <i class="fas fa-plus"></i> Abrir Caja (Ya hay una caja abierta)
                    </button>
                @else
                    <a href="{{ route('cajas.create', ['id' => $id]) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Abrir Caja
                    </a>
                @endif
                <a href="{{ route('cajas.sucursales') }}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Volver atrás
                </a>
            </div>


            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header linear-gradient-nuevo text-white"
                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h3 class="card-title"><i class="fas fa-user-tag"></i> Registro de cajas</h3>
                </div>
                <div class="card-body" style="background: #f8f9fa;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="cajasTable">
                            <thead class="linear-gradient">
                                <tr>
                                    <th>Fecha Apertura</th>
                                    <th>Fecha Cierre</th>
                                    <th>Usuario Apertura</th>
                                    <th>Usuario Cierre</th>
                                    <th>Monto Inicial</th>
                                    <th>Monto Vendido</th>
                                    <th>Monto Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#cajasTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cajas.index', ['id' => $id]) }}",
                    data: function(d) {
                        d.usuario_apertura = $('#search_usuario_apertura').val();
                        d.fecha_apertura = $('#search_fecha_apertura').val();
                        d.fecha_cierre = $('#search_fecha_cierre').val();
                    }
                },
                columns: [{
                        data: 'fecha_apertura'
                    },
                    {
                        data: 'fecha_cierre'
                    },
                    {
                        data: 'usuario_apertura',
                        name: 'user.name'
                    },
                    {
                        data: 'usuario_cierre',
                        name: 'userCierre.name',
                        defaultContent: 'Sin Cierre'
                    },
                    {
                        data: 'monto_inicial'
                    },

                    {
                        data: 'monto_total'
                    },
                    {
                        data: 'monto_total',
                        render: function(data, type, row) {
                            return (parseFloat(row.monto_total) + parseFloat(row.monto_inicial))
                                .toFixed(2);
                        }
                    },
                    {
                        data: 'acciones',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json"
                }
            });

            // Filtrar cuando el usuario haga clic en el botón
            $('#filterBtn').on('click', function() {
                table.draw(); // Redibuja la tabla con los filtros aplicados
            });
        });
    </script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('
                                                        error ') }}',
            });
        </script>
    @endif
@stop
@push('css')
    <style>
        .container {
            max-width: 1200px;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0;
        }

        .btn {
            border-radius: 8px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card-body {
            padding: 1.5rem;
        }
    </style>
@endpush
