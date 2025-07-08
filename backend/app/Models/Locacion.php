<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locacion extends Model
{
    protected $fillable = ['nombre'];
    public function personajes()
{
    return $this->hasMany(Personaje::class);
}

}
