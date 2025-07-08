<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personaje;
use App\Models\Locacion;
use App\Models\Episodio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportarController extends Controller
{
    public function importar(Request $request)
    {
        ini_set('max_execution_time', 120); // 2 minutos

        try {
            $pagina = $request->get('pagina', 1);
            $response = Http::get("https://rickandmortyapi.com/api/character?page={$pagina}");

            if (!$response->ok()) {
                return response()->json(['error' => 'Error al consumir la API'], 500);
            }

            $personajesApi = $response->json()['results'];

            foreach ($personajesApi as $data) {
                $locacion = Locacion::firstOrCreate([
                    'nombre' => $data['location']['name'] ?? 'Desconocido'
                ]);

                $personaje = Personaje::updateOrCreate(
                    ['nombre' => $data['name']],
                    [
                        'estado' => $data['status'],
                        'especie' => $data['species'],
                        'genero' => $data['gender'],
                        'imagen' => $data['image'],
                        'locacion_id' => $locacion->id
                    ]
                );

                foreach ($data['episode'] as $epUrl) {
                    $epResponse = Http::get($epUrl);
                    if ($epResponse->ok()) {
                        $epData = $epResponse->json();

                        $episodio = Episodio::firstOrCreate(
                            ['codigo' => $epData['episode']],
                            [
                                'nombre' => $epData['name'],
                                'fecha_emision' => date('Y-m-d', strtotime($epData['air_date'])),
                                'url' => $epData['url']
                            ]
                        );

                        $personaje->episodios()->syncWithoutDetaching([$episodio->id]);
                    }
                }
            }

            return response()->json(['mensaje' => 'Datos importados correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error inesperado',
                'mensaje' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function importarPorId(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id) {
                return response()->json(['error' => 'ID requerido'], 400);
            }

            // TEST: Confirmar que entra y qué ID llega
    Log::info("Importando personaje con ID: " . $id);

            $response = Http::get("https://rickandmortyapi.com/api/character/{$id}");

            if (!$response->ok()) {
                return response()->json(['error' => 'No se pudo obtener el personaje'], 500);
            }

            $data = $response->json();

            // Guardar locación
            $locacion = Locacion::firstOrCreate([
                'nombre' => $data['location']['name'] ?? 'Desconocido'
            ]);

            // Guardar personaje
            $personaje = Personaje::updateOrCreate(
                ['nombre' => $data['name']],
                [
                    'estado' => $data['status'],
                    'especie' => $data['species'],
                    'genero' => $data['gender'],
                    'imagen' => $data['image'],
                    'locacion_id' => $locacion->id
                ]
            );

            // Guardar episodios y relacionarlos
            foreach ($data['episode'] as $epUrl) {
                $epResponse = Http::get($epUrl);
                if ($epResponse->ok()) {
                    $epData = $epResponse->json();

                    $episodio = Episodio::firstOrCreate(
                        ['codigo' => $epData['episode']],
                        [
                            'nombre' => $epData['name'],
                            'fecha_emision' => date('Y-m-d', strtotime($epData['air_date'])),
                            'url' => $epData['url']
                        ]
                    );

                    $personaje->episodios()->syncWithoutDetaching([$episodio->id]);
                }
            }

            return response()->json(['mensaje' => 'Personaje importado correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error inesperado',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
}
