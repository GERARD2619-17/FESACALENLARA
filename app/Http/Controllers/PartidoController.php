<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verifica si la solicitud es AJAX
        if ($request->ajax()) {
            $partidos = Partido::all();
            $events = [];

            foreach ($partidos as $partido) {
                $events[] = [
                    'id' => $partido->id,
                    'title' => "{$partido->equipo_local} vs {$partido->equipo_visitante}",
                    'start' => $partido->fecha_hora_juego,
                    'end' => (new \DateTime($partido->fecha_hora_juego))->modify('+2 hours')->format('Y-m-d H:i:s'),
                ];
            }

            return response()->json($events);
        }

        // Si no es una solicitud AJAX, devuelve la vista normal
        $partidos = Partido::all();
        return view('partidos.index', compact('partidos'));
    }

    public function cardview()
    {
        $partidos = Partido::all();
        return view('partidos.cardview', compact('partidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('partidos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $partido = new Partido();
        $partido->equipo_local = $request->input('equipo_local');
        $partido->equipo_visitante = $request->input('equipo_visitante');
        $partido->fecha_hora_juego = $request->input('fecha_hora_juego');
        $partido->save();

        return response()->json(['id' => $partido->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $partido = Partido::findOrFail($id);
        return view('partidos.show', compact('partido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $partido = Partido::find($id);
        return view('partidos.edit', compact('partido'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $partido = Partido::find($id);
        $partido->equipo_local = $request->input('equipo_local');
        $partido->equipo_visitante = $request->input('equipo_visitante');
        $partido->fecha_hora_juego = $request->input('fecha_hora_juego');
        $partido->save();

        return response()->json('Event updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $partido = Partido::find($id);
        $partido->delete();

        return response()->json('Event deleted');
    }

    public function calendar()
    {
        $partidos = Partido::all();
        return view('partidos.calendar', compact('partidos'));
    }

    
}
