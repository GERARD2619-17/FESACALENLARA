<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'equipo_local',
        'equipo_visitante',
        'fecha_hora_juego',
        'goles_local',
        'goles_visitante',
        'tiempo_transcurrido',
        'estado',
    ];

    protected $casts = [
        'fecha_hora_juego' => 'datetime',
        'goles_local' => 'integer',
        'goles_visitante' => 'integer',
        'tiempo_transcurrido' => 'integer',
    ];

    protected $attributes = [
        'goles_local' => 0,
        'goles_visitante' => 0,
        'tiempo_transcurrido' => 0,
        'estado' => 'no_iniciado',
    ];
}
