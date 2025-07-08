<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
     protected $fillable = [
        'nombre',
        'estado',
        'especie',
        'genero',
        'imagen',
        'locacion_id'
    ];
    public function locacion()
{
    return $this->belongsTo(Locacion::class);
}

public function episodios()
{
    return $this->belongsToMany(Episodio::class);
}

}
