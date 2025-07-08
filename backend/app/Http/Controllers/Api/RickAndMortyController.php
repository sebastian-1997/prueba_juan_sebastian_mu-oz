<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personaje;
use App\Models\Episodio;
use App\Models\Locacion;

class RickAndMortyController extends Controller
{
    public function personajes()
    {
        return Personaje::with(['locacion', 'episodios'])->get();
    }

    public function episodios()
    {
        return Episodio::with('personajes')->get();
    }

    public function locaciones()
    {
        return Locacion::with('personajes')->get();
    }
}
