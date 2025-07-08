<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('personajes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('estado');
        $table->string('especie');
        $table->string('genero');
        $table->string('imagen');
        $table->foreignId('locacion_id')->constrained('locacions')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personajes');
    }
};
