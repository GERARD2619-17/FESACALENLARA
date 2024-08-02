@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Juego</h1>
    <div id="scoreboard" class="game-panel">
        <div class="match">
            <div id="team1" class="team-container">
                <img src="{{ asset('ruta/al/logo-equipo1.png') }}" alt="Logo {{ $partido->equipo_local }}">
                <h3 id="equipo-1" style="color: #ecf0f1;">{{ $partido->equipo_local }}</h3>
                <div class="score" id="goles-local">{{ $partido->goles_local }} goles</div>
                <div id="tarjetas-amarillas-local">0 tarjetas amarillas</div>
                <div id="tarjetas-rojas-local">0 tarjetas rojas</div>
                <div id="tarjetas-verdes-local">0 tarjetas verdes</div>
                <div id="penales-local">0 penales</div>
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
                <div id="tarjetas-amarillas-visitante">0 tarjetas amarillas</div>
                <div id="tarjetas-rojas-visitante">0 tarjetas rojas</div>
                <div id="tarjetas-verdes-visitante">0 tarjetas verdes</div>
                <div id="penales-visitante">0 penales</div>
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
    <p>¿Estás seguro de asignar un penal?</p>
    <button onclick="confirmarPenal()">Sí</button>
    <button onclick="cancelarPenal()">No</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
    $.post('{{ route('partidos.actualizarTiempo', $partido->id) }}', {tiempo: seconds});
}

$('#btn-timer').on('click', function () {
    if (!running) {
        timer = setInterval(updateTime, 1000);
        $(this).prop('disabled', true);
        $('#btn-pause').prop('disabled', false);
        running = true;
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
    $.post('{{ route('partidos.actualizarTiempo', $partido->id) }}', {tiempo: seconds});
});

function agregarGol(equipo) {
    $.post('{{ route('partidos.actualizarMarcador', $partido->id) }}', {equipo: equipo}, function(data) {
        $(`#goles-${equipo}`).text(data[`goles_${equipo}`] + ' goles');
        $(`#goles-${equipo}-result`).text(data[`goles_${equipo}`]);
    });
}

function agregarTarjeta(equipo, tipo) {
    $.post('{{ route('partidos.actualizarTarjetas', $partido->id) }}', {equipo: equipo, tipo: tipo}, function(data) {
        $(`#tarjetas-${tipo}s-${equipo}`).text(data[`tarjetas_${tipo}s_${equipo}`] + ` tarjetas ${tipo}s`);
    });
}

function asignarPenal(equipo) {
    equipoPenal = equipo;
    $('#confirmation-modal').show();
}

function confirmarPenal() {
    $.post('{{ route('partidos.asignarPenal', $partido->id) }}', {equipo: equipoPenal}, function(data) {
        $(`#penales-${equipoPenal}`).text(data[`penales_${equipoPenal}`] + ' penales');
    });
    $('#confirmation-modal').hide();
}

function cancelarPenal() {
    $('#confirmation-modal').hide();
}
</script>
@endsection