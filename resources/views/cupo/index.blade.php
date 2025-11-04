@extends('adminlte::page')

@section('template_title')
    Cupos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Cupos') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('cupos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    
                    <div class="card shadow-lg border-0" style="border-radius: 15px;">
                        <div class="card-header linear-gradient-nuevo text-white"
                            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <h3 class="card-title"><i class="fas fa-user-tag"></i> Cupones</h3>
                        </div>
                        <div class="card-body" style="background: #f8f9fa;">

                            <div class="table-responsive">
                                <table id="cupos-table" class="table table-bordered table-striped">
                                    <thead class="linear-gradient">
                                        <tr>
                                            <th>No</th>
                                            <th>Codigo</th>
                                            <th>Estado</th>
                                            <th>FEHCA Y HORA DE ACTIVACION</th>
                                            <th>FEHCA Y HORA DE DESACTIVACION</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cupos as $cupo)
                                            <tr>
                                                <td>{{ $cupo->id }}</td>
                                                <td>{{ $cupo->codigo }}</td>
                                                <td>
                                                    @php
                                                        $estadoClass =
                                                            $cupo->estado == 'Inactivo'
                                                                ? 'text-danger'
                                                                : 'text-success';
                                                        $estadoLabel =
                                                            $cupo->estado == 'Inactivo' ? 'Inactivo' : 'Activo';
                                                    @endphp
                                                    <span class="{{ $estadoClass }}">
                                                        {{ $estadoLabel }}
                                                    </span>
                                                </td>
                                                <td>{{ $cupo->fecha_inicio ? $cupo->fecha_inicio->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>{{ $cupo->fecha_fin ? $cupo->fecha_fin->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('cupos.destroy', $cupo->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ route('cupos.show', $cupo->id) }}">
                                                            <i class="fa fa-fw fa-eye"></i> {{ __('Show') }}
                                                        </a>
                                                        <a class="btn btn-sm btn-success"
                                                            href="{{ route('cupos.edit', $cupo->id) }}">
                                                            <i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">
                                                            <i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
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
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#cupos-table').DataTable({
                processing: true,
                serverSide: false, // No es necesario hacer AJAX porque los datos se cargan al inicio
                paging: true, // Habilitar paginación
                searching: true, // Habilitar búsqueda
                lengthChange: true, // Habilitar cambiar número de filas por página
                ordering: true, // Habilitar ordenamiento de columnas
                pageLength: 10, // Número de registros por página
            });
        });
    </script>
@endsection
