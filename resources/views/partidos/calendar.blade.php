<!-- resources/views/calendar.blade.php -->
@extends('layouts.app')

@section('title', 'Partido Calendario')

@section('content')
    <br />
    <h2 align="center"><a href="#">Partido Calendario</a></h2>
    <br />
    <div class="container">
        <a href="{{ route('partidos.index') }}" class="btn btn-secondary mb-3">Vista de Lista</a>
        <div id="calendar"></div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: '{{ url('/partidos') }}', // Asegúrate de que la URL sea correcta
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var equipo_local = prompt("Enter Local Team");
                var equipo_visitante = prompt("Enter Visitor Team");
                if (equipo_local && equipo_visitante) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: "{{ url('/partidos') }}",
                        type: "POST",
                        data: {
                            equipo_local: equipo_local,
                            equipo_visitante: equipo_visitante,
                            fecha_hora_juego: start,
                        },
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert("Added Successfully");
                        }
                    });
                }
            },
            eventResize: function(event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                $.ajax({
                    url: "{{ url('/partidos') }}/" + event.id,
                    type: "PATCH",
                    data: {
                        equipo_local: event.title.split(" vs ")[0],
                        equipo_visitante: event.title.split(" vs ")[1],
                        fecha_hora_juego: start,
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert('Event Updated');
                    }
                });
            },
            eventDrop: function(event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                $.ajax({
                    url: "{{ url('/partidos') }}/" + event.id,
                    type: "PATCH",
                    data: {
                        equipo_local: event.title.split(" vs ")[0],
                        equipo_visitante: event.title.split(" vs ")[1],
                        fecha_hora_juego: start,
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated");
                    }
                });
            },
            eventClick: function(event) {
                if (confirm("Are you sure you want to remove it?")) {
                    $.ajax({
                        url: "{{ url('/partidos') }}/" + event.id,
                        type: "DELETE",
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Removed");
                        }
                    });
                }
            },
        });
    });
</script>
@endsection
