<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'nombre',
        'apellidos',
        'equipo',
        'posicion',
        'fecha_nacimiento',
        'ciudad',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function partidos()
    {
        return $this->belongsToMany(Partido::class, 'jugador_partido', 'jugador_id', 'partido_id');
    }
}
