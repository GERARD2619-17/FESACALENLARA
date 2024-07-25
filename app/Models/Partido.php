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
    ];

    protected $casts = [
        'fecha_hora_juego' => 'datetime',
    ];
}
