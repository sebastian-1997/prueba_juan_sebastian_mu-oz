<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'fecha_emision',
        'url'
    ];
    public function personajes()
{
    return $this->belongsToMany(Personaje::class);
}

}
