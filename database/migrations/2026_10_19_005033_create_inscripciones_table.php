<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->foreignId('participante_id')->constrained('participantes')->cascadeOnDelete();
            $table->foreignId('paralelo_id')->constrained('paralelos')->cascadeOnDelete();
            $table->dateTime('fecha_inscripcion');
            $table->decimal('monto_pagado', 10, 2)->default(0.00);
            $table->enum('estado', ['pendiente', 'pagada', 'anulada'])->default('pendiente')->index();
            $table->string('metodo_pago', 50)->nullable();
            $table->string('comprobante', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Restricción de unicidad: un participante no puede duplicar inscripción en el mismo paralelo
            $table->unique(['participante_id', 'paralelo_id']);
            $table->index(['paralelo_id', 'estado']);
            $table->index(['participante_id', 'estado']);
            $table->index('fecha_inscripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
