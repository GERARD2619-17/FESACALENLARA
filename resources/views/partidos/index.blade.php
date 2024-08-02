@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Partidos</h1>
    <a href="{{ route('partidos.create') }}" class="btn btn-primary mb-3">Crear Partido</a>
    <a href="{{ route('partidos.cardview') }}" class="btn btn-secondary mb-3">Vista de Tarjetas</a>
    <a href="{{ route('partidos.calendar') }}" class="btn btn-secondary mb-3">Vista de Calendario</a>
    <table class="table">
        <thead>
            <tr>
                <th>Equipo Local</th>
                <th>Equipo Visitante</th>
                <th>Fecha/Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($partidos as $partido)
            <tr>
                <td>{{ $partido->equipo_local }}</td>
                <td>{{ $partido->equipo_visitante }}</td>
                <td>{{ $partido->fecha_hora_juego->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('partidos.paneljuego', $partido->id) }}" class="btn btn-primary">Panel de Juego</a>
                    <a href="{{ route('partidos.edit', $partido->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('partidos.destroy', $partido->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
