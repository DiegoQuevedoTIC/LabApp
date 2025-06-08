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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_solicitud');
            $table->date('fecha_solicitud');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('direccion_tecnica_id')->nullable()->constrained('direccion_tecnicas');
            $table->foreignId('grupo_trabajo_id')->nullable()->constrained('grupo_trabajos');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos');
            $table->string('entidad');
            $table->string('direccion_ciudad');
            $table->string('referencia', 16)->unique();
            $table->string('contacto_1_nombre');
            $table->string('contacto_1_email');
            $table->string('contacto_1_extension')->nullable();
            $table->string('contacto_2_nombre');
            $table->string('contacto_2_email');
            $table->string('contacto_2_extension')->nullable();
            $table->longText('requisitos_especiales')->nullable();
            $table->string('soporte')->nullable();
            $table->unsignedInteger('cantidad_muestras_proyectadas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
