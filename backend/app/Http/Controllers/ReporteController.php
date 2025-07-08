<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use App\Models\Personaje;
use App\Models\Episodio;
use App\Models\Locacion;

class ReporteController extends Controller
{
    public function buscar(Request $request)
    {
        $nombre = $request->query('nombre');

        $query = Personaje::query();

        if ($nombre) {
            $query->where('nombre', 'like', "%{$nombre}%");
        }

        return response()->json($query->get());
    }
    public function detalle($id)
    {
        $personaje = Personaje::with(['locacion', 'episodios'])->findOrFail($id);

        return response()->json([
            'nombre' => $personaje->nombre,
            'estado' => $personaje->estado,
            'especie' => $personaje->especie,
            'genero' => $personaje->genero,
            'imagen' => $personaje->imagen,
            'locacion' => $personaje->locacion->nombre ?? 'Desconocida',
            'episodios' => $personaje->episodios->map(function ($e) {
                return [
                    'nombre' => $e->nombre,
                    'fecha_emision' => $e->fecha_emision,
                    'codigo' => $e->codigo,
                    'url' => $e->url
                ];
            }),
        ]);
    }


    public function personajesOrdenados()
    {
        $hoy = Carbon::now();

        $personajes = Personaje::with(['episodios' => function ($query) {
            $query->orderBy('fecha_emision', 'asc');
        }])->get()->map(function ($personaje) use ($hoy) {
            $primerEpisodio = $personaje->episodios->first();

            return [
                'personaje' => $personaje->nombre,
                'primer_episodio' => $primerEpisodio ? $primerEpisodio->nombre : 'No disponible',
                'fecha_emision' => $primerEpisodio ? $primerEpisodio->fecha_emision : null,
                'antiguedad_dias' => $primerEpisodio ? Carbon::parse($primerEpisodio->fecha_emision)->diffInDays($hoy) : null,
            ];
        })->sortBy('fecha_emision')->values();

        return response()->json($personajes);
    }

    public function personajesPorEpisodio()
    {
        $episodios = Episodio::withCount('personajes')
            ->orderBy('nombre')
            ->get()
            ->map(function ($episodio) {
                return [
                    'episodio' => $episodio->nombre,
                    'cantidad_personajes' => $episodio->personajes_count
                ];
            });

        return response()->json($episodios);
    }

    public function personajesPorLocacion()
    {
        $locaciones = Locacion::with('personajes')->get();

        $resultado = $locaciones->map(function ($locacion) {
            return [
                'locacion' => $locacion->nombre,
                'personajes' => $locacion->personajes->pluck('nombre')
            ];
        });

        return response()->json($resultado);
    }

    public function personajesEnEpisodio(Request $request)
{
    $codigo = $request->query('codigo');

    if (!$codigo) {
        return response()->json(['error' => 'Debe proporcionar el código del episodio'], 400);
    }

    $episodio = Episodio::where('codigo', $codigo)->first();

    if (!$episodio) {
        return response()->json([]);
    }

    $personajes = $episodio->personajes()->pluck('nombre');

    return response()->json([
        'episodio' => $episodio->nombre,
        'codigo' => $episodio->codigo,
        'personajes' => $personajes
    ]);
}

    public function listarLocaciones()
{
    $locaciones = Locacion::pluck('nombre')->unique()->values();
    return response()->json($locaciones);
}


public function filtrarPorLocacion(Request $request)
{
    $nombre = $request->query('nombre');

    $locacion = Locacion::where('nombre', $nombre)->first();

    if (!$locacion) {
        return response()->json(['personajes' => []]);
    }

    $personajes = $locacion->personajes()->select('nombre', 'estado', 'especie', 'genero', 'imagen')->get();

    return response()->json(['personajes' => $personajes]);
}


}
