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
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
                    $table->foreignId('solicitud_id')->constrained('solicituds')->cascadeOnDelete();

        // Campos de identificación
        $table->unsignedInteger('consecutivo');
        $table->string('codigo_consecutivo')->unique();
        $table->string('referencia_campo')->nullable();

        // Campos descriptivos
        $table->foreignId('tipo_muestra_id')->constrained('tipo_muestras');
        $table->text('localizacion_geografica')->nullable();
        $table->text('descripcion_preliminar')->nullable();
        $table->text('origen')->nullable();
        $table->text('observaciones')->nullable();

        // Datos del ensayo
        $table->decimal('ph', 8, 2)->nullable();
        $table->decimal('temperatura', 8, 2)->nullable();
        $table->decimal('conductividad', 10, 2)->nullable();
        $table->decimal('alcalinidad', 10, 2)->nullable();
        $table->decimal('norte', 18, 6)->nullable(); // Coordenadas
        $table->decimal('este', 18, 6)->nullable();   // Coordenadas

        // Criterios de Aceptación
        $table->boolean('criterio_1')->default(false);
        $table->boolean('criterio_2')->default(false);
        $table->boolean('criterio_3')->default(false);
        $table->boolean('criterio_4')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muestras');
    }
};
