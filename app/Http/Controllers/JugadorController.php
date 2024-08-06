<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Muestra los jugadores asociados a un partido específico.
     */
    public function jugadoresPorPartido($partido_id)
    {
        $partido = Partido::findOrFail($partido_id);
        $jugadoresLocales = Jugador::where('equipo', $partido->equipo_local)->get();
        $jugadoresVisitantes = Jugador::where('equipo', $partido->equipo_visitante)->get();

        return view('partido.jugadores', compact('partido', 'jugadoresLocales', 'jugadoresVisitantes'));
    }
}
