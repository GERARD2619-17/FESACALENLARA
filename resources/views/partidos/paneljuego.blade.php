@extends('layouts.app')

@section('title', 'Panel de Juego')

@section('styles')
<style>
    /* Puedes añadir estilos específicos aquí si es necesario */
    .confirmation-modal {
        /* Estilos para el modal de confirmación */
        display: none;
        /* Añade más estilos según sea necesario */
    }
</style>
@endsection

@section('ajax-setup')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection

@section('content')
<div class="container">
    <h1>Panel de Juego</h1>
    <div id="estado-partido">Estado: {{ $partido->estado }}</div>
    <div id="scoreboard" class="game-panel">
        <div class="match">
            <div id="team1" class="team-container">
                <img src="{{ asset('ruta/al/logo-equipo1.png') }}" alt="Logo {{ $partido->equipo_local }}">
                <h3 id="equipo-1" style="color: #ecf0f1;">{{ $partido->equipo_local }}</h3>
                <div class="score" id="goles-local">{{ $partido->goles_local }} goles</div>
                <div id="tarjetas-amarillas-local">{{ $partido->tarjetas_amarillas_local }} tarjetas amarillas</div>
                <div id="tarjetas-rojas-local">{{ $partido->tarjetas_rojas_local }} tarjetas rojas</div>
                <div id="tarjetas-verdes-local">{{ $partido->tarjetas_verdes_local }} tarjetas verdes</div>
                <div id="penales-local">{{ $partido->penales_local }} penales</div>
                <button class="btn btn-success" onclick="agregarGol('local')">Agregar Gol</button>
                <button class="btn btn-warning" onclick="agregarTarjeta('local', 'amarilla')">Amarilla</button>
                <button class="btn btn-danger" onclick="agregarTarjeta('local', 'roja')">Roja</button>
                <button class="btn btn-success" onclick="agregarTarjeta('local', 'verde')">Verde</button>
                <button class="btn btn-info" onclick="asignarPenal('local')">Penal</button>
            </div>

            <div id="result-container">
                <div id="result" style="color: #2c3e50;">
                    <span id="goles-local-result">{{ $partido->goles_local }}</span> - 
                    <span id="goles-visitante-result">{{ $partido->goles_visitante }}</span>
                </div>
                <div id="minutes-container">
                    <label for="tiempo-seleccionado">Selecciona tiempo (minutos):</label>
                    <input type="number" id="tiempo-seleccionado" min="1" value="45">
                    <button class="btn btn-primary" id="btn-timer">Iniciar</button>
                    <button class="btn btn-warning" id="btn-pause" disabled>Pausar</button>
                    <button class="btn btn-danger" id="btn-reset">Reiniciar</button>
                    <div id="timer-container">
                        <span id="tiempo">{{ sprintf('%02d:%02d', floor($partido->tiempo_transcurrido / 60), $partido->tiempo_transcurrido % 60) }}</span>
                    </div>
                </div>
            </div>

            <div id="team2" class="team-container">
                <img src="{{ asset('ruta/al/logo-equipo2.png') }}" alt="Logo {{ $partido->equipo_visitante }}">
                <h3 id="equipo-2" style="color: #ecf0f1;">{{ $partido->equipo_visitante }}</h3>
                <div class="score" id="goles-visitante">{{ $partido->goles_visitante }} goles</div>
                <div id="tarjetas-amarillas-visitante">{{ $partido->tarjetas_amarillas_visitante }} tarjetas amarillas</div>
                <div id="tarjetas-rojas-visitante">{{ $partido->tarjetas_rojas_visitante }} tarjetas rojas</div>
                <div id="tarjetas-verdes-visitante">{{ $partido->tarjetas_verdes_visitante }} tarjetas verdes</div>
                <div id="penales-visitante">{{ $partido->penales_visitante }} penales</div>
                <button class="btn btn-success" onclick="agregarGol('visitante')">Agregar Gol</button>
                <button class="btn btn-warning" onclick="agregarTarjeta('visitante', 'amarilla')">Amarilla</button>
                <button class="btn btn-danger" onclick="agregarTarjeta('visitante', 'roja')">Roja</button>
                <button class="btn btn-success" onclick="agregarTarjeta('visitante', 'verde')">Verde</button>
                <button class="btn btn-info" onclick="asignarPenal('visitante')">Penal</button>
            </div>
        </div>
    </div>
</div>

<div id="confirmation-modal" class="confirmation-modal" style="display: none;">
    <p>¿Estás seguro de asignar un penal a <span id="equipo-penal"></span>?</p>
    <button onclick="confirmarPenal()">Sí</button>
    <button onclick="cancelarPenal()">No</button>
</div>
@endsection

@section('scripts')
<script>
let timer;
let seconds = {{ $partido->tiempo_transcurrido }};
let running = false;
let equipoPenal = '';

function updateTime() {
    seconds++;
    let minutes = Math.floor(seconds / 60);
    let remainingSeconds = seconds % 60;
    $('#tiempo').text(`${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`);
    
    $.post('{{ route('partidos.actualizarTiempo', $partido->id) }}', {tiempo: seconds})
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al actualizar tiempo:", textStatus, errorThrown);
        });
}

$('#btn-timer').on('click', function () {
    if (!running) {
        timer = setInterval(updateTime, 1000);
        $(this).prop('disabled', true);
        $('#btn-pause').prop('disabled', false);
        running = true;
        
        $.post('{{ route('partidos.actualizarEstado', $partido->id) }}', {estado: 'primer_tiempo'})
            .done(function(data) {
                $('#estado-partido').text('Estado: ' + data.estado);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error al actualizar estado:", textStatus, errorThrown);
            });
    }
});

$('#btn-pause').on('click', function () {
    if (running) {
        clearInterval(timer);
        $(this).prop('disabled', true);
        $('#btn-timer').prop('disabled', false);
        running = false;
    }
});

$('#btn-reset').on('click', function () {
    clearInterval(timer);
    seconds = 0;
    $('#tiempo').text('00:00');
    $('#btn-timer').prop('disabled', false);
    $('#btn-pause').prop('disabled', true);
    running = false;
    $.post('{{ route('partidos.actualizarTiempo', $partido->id) }}', {tiempo: seconds})
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al reiniciar tiempo:", textStatus, errorThrown);
        });
});

function agregarGol(equipo) {
    $.post('{{ route('partidos.actualizarMarcador', $partido->id) }}', {equipo: equipo})
        .done(function(data) {
            $(`#goles-${equipo}`).text(data[`goles_${equipo}`] + ' goles');
            $(`#goles-${equipo}-result`).text(data[`goles_${equipo}`]);
            
            if (equipo === 'local') {
                $('#goles-local-result').text(data.goles_local);
            } else {
                $('#goles-visitante-result').text(data.goles_visitante);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al agregar gol:", textStatus, errorThrown);
            alert("Hubo un error al agregar el gol. Por favor, intenta de nuevo.");
        });
}

function agregarTarjeta(equipo, tipo) {
    $.post('{{ route('partidos.actualizarTarjetas', $partido->id) }}', {equipo: equipo, tipo: tipo})
        .done(function(data) {
            $(`#tarjetas-${tipo}s-${equipo}`).text(data[`tarjetas_${tipo}s_${equipo}`] + ` tarjetas ${tipo}s`);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al agregar tarjeta:", textStatus, errorThrown);
            alert("Hubo un error al agregar la tarjeta. Por favor, intenta de nuevo.");
        });
}

function asignarPenal(equipo) {
    equipoPenal = equipo;
    let nombreEquipo = equipo === 'local' ? '{{ $partido->equipo_local }}' : '{{ $partido->equipo_visitante }}';
    $('#equipo-penal').text(nombreEquipo);
    $('#confirmation-modal').show();
}

function confirmarPenal() {
    $.post('{{ route('partidos.asignarPenal', $partido->id) }}', {equipo: equipoPenal})
        .done(function(data) {
            $(`#penales-${equipoPenal}`).text(data[`penales_${equipoPenal}`] + ' penales');
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al asignar penal:", textStatus, errorThrown);
            alert("Hubo un error al asignar el penal. Por favor, intenta de nuevo.");
        });
    $('#confirmation-modal').hide();
}

function cancelarPenal() {
    $('#confirmation-modal').hide();
}
</script>
@endsection