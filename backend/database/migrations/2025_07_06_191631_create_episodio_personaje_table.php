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
    Schema::create('episodio_personaje', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('episodio_id');
        $table->unsignedBigInteger('personaje_id');
        $table->timestamps();

        $table->foreign('episodio_id')->references('id')->on('episodios')->onDelete('cascade');
        $table->foreign('personaje_id')->references('id')->on('personajes')->onDelete('cascade');
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodio_personaje');
    }
};
