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
        $request->validate([
            'equipo_local' => 'required',
            'equipo_visitante' => 'required',
            'fecha_hora_juego' => 'required|date',
        ]);

        $partido = Partido::create($request->all());

        return redirect()->route('partidos.index')->with('success', 'Partido creado exitosamente');
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
        $partido->update($request->all());

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

    public function paneljuego($id)
    {
        $partido = Partido::findOrFail($id);
        return view('partidos.paneljuego', compact('partido'));
    }

    public function actualizarMarcador(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $equipo = $request->input('equipo');

        if ($equipo == 'local') {
            $partido->goles_local++;
        } elseif ($equipo == 'visitante') {
            $partido->goles_visitante++;
        }

        $partido->save();

        return response()->json([
            'goles_local' => $partido->goles_local,
            'goles_visitante' => $partido->goles_visitante
        ]);
    }

    public function actualizarTiempo(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $partido->tiempo_transcurrido = $request->input('tiempo');
        $partido->save();

        return response()->json(['tiempo' => $partido->tiempo_transcurrido]);
    }

    /*public function cambiarEstado(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $partido->estado = $request->input('estado');
        $partido->save();

        return response()->json(['estado' => $partido->estado]);
    }*/
    public function actualizarEstado(Request $request, Partido $partido)
    {
        $partido->estado = $request->estado;
        $partido->save();

        return response()->json(['estado' => $partido->estado]);
    }

    public function actualizarTarjetas(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $equipo = $request->input('equipo');
        $tipo = $request->input('tipo');

        $campo = "tarjetas_{$tipo}s_{$equipo}";
        $partido->$campo++;
        $partido->save();

        return response()->json([$campo => $partido->$campo]);
    }

    public function asignarPenal(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $equipo = $request->input('equipo');

        $campo = "penales_{$equipo}";
        $partido->$campo++;
        $partido->save();

        return response()->json([$campo => $partido->$campo]);
    }

    public function lista()
    {
        $partidos = Partido::all();
        return response()->json(['partidos' => $partidos]);
    }
}
