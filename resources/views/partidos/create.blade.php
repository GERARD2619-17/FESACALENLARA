@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Partido</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('partidos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="equipo_local">Equipo Local</label>
            <input type="text" class="form-control" id="equipo_local" name="equipo_local" required>
        </div>
        <div class="form-group">
            <label for="equipo_visitante">Equipo Visitante</label>
            <input type="text" class="form-control" id="equipo_visitante" name="equipo_visitante" required>
        </div>
        <div class="form-group">
            <label for="fecha_hora_juego">Fecha/Hora del Partido</label>
            <input type="datetime-local" class="form-control" id="fecha_hora_juego" name="fecha_hora_juego" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
