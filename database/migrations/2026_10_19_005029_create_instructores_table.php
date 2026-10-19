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
        Schema::create('instructores', function (Blueprint $table) {
            $table->id();
            $table->string('documento_identidad', 20)->unique();
            $table->string('nombres', 80);
            $table->string('apellidos', 80);
            $table->string('email', 120)->unique();
            $table->string('telefono', 30);
            $table->string('especialidad', 100);
            $table->text('biografia')->nullable();
            $table->unsignedTinyInteger('experiencia_anos')->default(1);
            $table->boolean('activo')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructores');
    }
};
