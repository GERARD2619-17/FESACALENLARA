@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Partidos (Vista de Tarjetas)</h1>
    <a href="{{ route('partidos.create') }}" class="btn btn-primary mb-3">Crear Partido</a>
    <a href="{{ route('partidos.index') }}" class="btn btn-secondary mb-3">Vista de Lista</a>
    <a href="{{ route('partidos.calendar') }}" class="btn btn-secondary mb-3">Vista de Calendario</a>
    <div class="row" id="partidos-container">
        @foreach ($partidos as $partido)
        <div class="col-md-4 mb-4 partido-card" data-id="{{ $partido->id }}">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}</h5>
                    <p class="card-text">
                        <strong>Fecha/Hora:</strong> {{ \Carbon\Carbon::parse($partido->fecha_hora_juego)->format('d/m/Y H:i') }}
                    </p>
                    <p class="card-text marcador">
                        <strong>Marcador:</strong> {{ $partido->goles_local }} - {{ $partido->goles_visitante }}
                    </p>
                    <form action="{{ route('partidos.destroy', $partido->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
$(document).ready(function() {
    function actualizarPartidos() {
        $.ajax({
            url: '{{ route('partidos.lista') }}', // Asegúrate de tener una ruta que devuelva la lista de partidos
            method: 'GET',
            success: function(response) {
                response.partidos.forEach(function(partido) {
                    let partidoCard = $('.partido-card[data-id="' + partido.id + '"]');
                    partidoCard.find('.marcador').text('Marcador: ' + partido.goles_local + ' - ' + partido.goles_visitante);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al actualizar partidos:", textStatus, errorThrown);
            }
        });
    }

    setInterval(actualizarPartidos, 5000); // Actualiza cada 5 segundos
});
</script>
@endsection
