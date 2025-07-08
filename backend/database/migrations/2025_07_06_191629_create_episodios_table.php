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
    Schema::create('episodios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo'); // Ej: S01E01
        $table->date('fecha_emision')->nullable();
        $table->string('url');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodios');
    }
};
