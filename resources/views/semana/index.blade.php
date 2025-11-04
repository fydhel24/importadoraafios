@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1>Bienvenido al Panel de Administración</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <div class="float-right">
                                @can('semanas.create')
                                    {{-- Permiso para crear semanas --}}
                                    <a href="{{ route('semanas.create') }}" class="btn btn-action-extra"
                                        data-placement="left">
                                        {{ __('Crear Semana') }}
                                    </a>
                                @endcan
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
                            <h3 class="card-title"><i class="fas fa-user-tag"></i>Registro de Semanas</h3>
                        </div>
                        <div class="card-body" style="background: #f8f9fa;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="linear-gradient">
                                        <tr>
                                            <th>No</th>

                                            <th>Nombre</th>
                                            <th>Fecha</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semanas as $semana)
                                            <tr>
                                                <td>{{ ++$i }}</td>

                                                <td>{{ $semana->nombre }}</td>
                                                <td>{{ $semana->fecha }}</td>

                                                <td>
                                                    <form action="{{ route('semanas.destroy', $semana->id) }}"
                                                        method="POST">
                                                        <a class="btn btn-action-extra btn-sm " title="Ver"
                                                            href="{{ route('semanas.show', $semana->id) }}">
                                                            <i class="fa fa-fw fa-eye"></i>
                                                        </a>

                                                        @can('semanas.edit')
                                                            {{-- Permiso para editar semanas --}}
                                                            <a class="btn btn-action-edit btn-sm" title="Editar"
                                                                href="{{ route('semanas.edit', $semana->id) }}" >
                                                                <i class="fa fa-fw fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('semanas.destroy')
                                                            {{-- Permiso para eliminar semanas --}}
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-action-delete btn-sm" title="Eliminar"
                                                                onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">
                                                                <i class="fa fa-fw fa-trash"></i>
                                                            </button>
                                                        @endcan
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
                {!! $semanas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
