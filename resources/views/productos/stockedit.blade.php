@extends('adminlte::page')

@section('title', 'Stock de Sucursales')

@section('content_header')
    <h1 class="text-center">Administrar Stock en Sucursales</h1>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg border-0" style="border-radius: 15px;">
            <div class="card-header linear-gradient-nuevo text-white"
                style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h3 class="card-title"><i class="fas fa-user-tag"></i> Reporte de stock</h3>
            </div>
            <div class="card-body" style="background: #f8f9fa;">
                <!-- Filtro por categoría -->
                <form method="GET" action="{{ route('report.stock') }}">
                    <div class="form-row">
                        <div class="col-md-3">
                            <label for="categoria">Categoría</label>
                            <select name="id_categoria" id="categoria" class="form-control">
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ request('id_categoria') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->categoria }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mt-4">Filtrar</button>
                        </div>
                    </div>
                </form>

                <!-- Tabla de Productos -->
                <div class="table-responsive">
                    <table id="products-report-table" class="table table-bordered table-striped">
                        <thead class="linear-gradient">
                            <tr>

                                <th>Nombre del Producto</th>
                                <th>Id de producto</th>
                                <th>Stock Incial</th>
                                <th>Stock en Almacén</th>
                                @foreach ($sucurnombre as $sucursal)
                                    <th>{{ $sucursal->nombre }}</th> <!-- Mostrar el nombre de la sucursal -->
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán automáticamente desde DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                var table = $('#products-report-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('report.stock') }}',
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            d.categoria_id = $('#categoria').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            className: 'text-center'
                        },
                        {
                            data: 'nombre',
                            className: 'text-center'
                        },
                        {
                            data: 'precio_descuento'
                        },
                        {
                            data: 'stock',
                            render: function(data, type, row) {
                                return `<input type="number" class="form-control form-control-sm stock-almacen-input" 
                                        data-product-id="${row.id}" 
                                        value="${data || 0}" />`;
                            },
                            className: 'text-center'
                        },
                        @foreach ($sucursales as $sucursalId)
                            {
                                data: 'stocks.{{ $sucursalId }}',
                                render: function(data, type, row) {
                                    return `<input type="number" class="form-control form-control-sm stock-input" 
                                            data-product-id="${row.id}" 
                                            data-sucursal-id="{{ $sucursalId }}" 
                                            value="${data || 0}" />`;
                                },
                                className: 'text-center'
                            },
                        @endforeach
                    ],
                    language: {
                        decimal: ",",
                        thousands: ".",
                        processing: "Procesando...",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "No hay registros disponibles",
                        infoFiltered: "(filtrado de _MAX_ registros)",
                        search: "Buscar:",
                        zeroRecords: "No se encontraron registros",
                        emptyTable: "No hay datos disponibles en la tabla",
                        paginate: {
                            first: "Primero",
                            previous: "Anterior",
                            next: "Siguiente",
                            last: "Último"
                        }
                    },
                    columnDefs: [{
                            targets: 0,
                            searchable: true
                        }, {
                            targets: 1,
                            searchable: true
                        },
                        {
                            targets: '_all',
                            searchable: false
                        }
                    ]
                });

                // Detectar cambios en los inputs de stock y actualizar el valor
                $('#products-report-table').on('change', '.stock-input', function() {
                    var input = $(this);
                    var productId = input.data('product-id');
                    var sucursalId = input.data('sucursal-id');
                    var newValue = input.val();

                    // Realizar la solicitud AJAX para actualizar el stock
                    $.ajax({
                        url: '{{ route('report.updateStock') }}',
                        method: 'POST',
                        data: {
                            product_id: productId,
                            sucursal_id: sucursalId,
                            new_value: newValue,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Stock actualizado con éxito',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No existe el producto en esta sucursal',
                                    text: '¡Agrega el producto!',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Hubo un error al actualizar el stock o el campo esta vacio');
                            location.reload();
                        }
                    });
                });

                // Detectar cambios en los inputs de stock del almacén
                $('#products-report-table').on('change', '.stock-almacen-input', function() {
                    var input = $(this);
                    var productId = input.data('product-id');
                    var newValue = input.val();

                    $.ajax({
                        url: '{{ route('report.updateAlmacenStock') }}',
                        method: 'POST',
                        data: {
                            product_id: productId,
                            new_value: newValue,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Stock de almacén actualizado con éxito',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al actualizar el stock de almacén',
                                    text: '¡Inténtalo de nuevo!',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Hubo un error al actualizar el stock de almacén');
                            location.reload();
                        }
                    });
                });
            });
        </script>
    @endsection
