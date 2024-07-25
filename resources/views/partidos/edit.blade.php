@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Partido</h2>
    <form action="{{ route('partidos.update', $partido->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="equipo_local" class="form-label">Equipo Local</label>
            <input type="text" class="form-control" id="equipo_local" name="equipo_local" value="{{ $partido->equipo_local }}">
        </div>
        <div class="mb-3">
            <label for="equipo_visitante" class="form-label">Equipo Visitante</label>
            <input type="text" class="form-control" id="equipo_visitante" name="equipo_visitante" value="{{ $partido->equipo_visitante }}">
        </div>
        <div class="mb-3">
            <label for="fecha_hora_juego" class="form-label">Fecha y Hora del Juego</label>
            <input type="datetime-local" class="form-control" id="fecha_hora_juego" name="fecha_hora_juego" value="{{ $partido->fecha_hora_juego->format('Y-m-d\TH:i') }}">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
