<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Personaje;
use App\Models\Episodio;
use App\Models\Locacion;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ImportRickAndMortyData extends Command
{
    protected $signature = 'import:rickandmorty';
    protected $description = 'Importar personajes, episodios y locaciones desde la API de Rick and Morty';

    public function handle()
    {
        $this->importLocaciones();
        $this->importEpisodios();
        $this->importPersonajes();

        $this->info('Se importaron los datos correctamente.');
    }

    protected function importLocaciones()
{
    $url = 'https://rickandmortyapi.com/api/location';
    do {
        $response = Http::get($url);
        $data = $response->json();

        Model::unguarded(function () use ($data) {
            foreach ($data['results'] as $loc) {
                Locacion::updateOrCreate(
                    ['id' => $loc['id']],
                    [
                        'nombre' => $loc['name'],
                        'tipo' => $loc['type'],
                        'dimension' => $loc['dimension'],
                    ]
                );
            }
        });

        $url = $data['info']['next'];
    } while ($url);
}



    protected function importEpisodios()
{
    $url = 'https://rickandmortyapi.com/api/episode';
    do {
        $response = Http::get($url);
        $data = $response->json();

        Model::unguarded(function () use ($data) {
            foreach ($data['results'] as $ep) {
                Episodio::updateOrCreate(
                    ['id' => $ep['id']],
                    [
                        'nombre' => $ep['name'],
                        'codigo' => $ep['episode'],
                        'fecha_aire' => Carbon::parse($ep['air_date'])->format('Y-m-d'),
                    ]
                );
            }
        });

        $url = $data['info']['next'];
    } while ($url);
}


    protected function importPersonajes()
{
    $url = 'https://rickandmortyapi.com/api/character';
    do {
        $response = Http::get($url);
        $data = $response->json();

        Model::unguarded(function () use ($data) {
            foreach ($data['results'] as $char) {
                $locacion = Locacion::where('nombre', $char['location']['name'])->first();

                $personaje = Personaje::updateOrCreate(
                    ['id' => $char['id']],
                    [
                        'nombre' => $char['name'],
                        'estado' => $char['status'],
                        'especie' => $char['species'],
                        'genero' => $char['gender'],
                        'locacion_id' => $locacion?->id,
                    ]
                );

                // Relacionar episodios
                $episodioIds = collect($char['episode'])->map(function ($url) {
                    return (int) last(explode('/', $url));
                });

                $personaje->episodios()->sync($episodioIds);
            }
        });

        $url = $data['info']['next'];
    } while ($url);
}

}
