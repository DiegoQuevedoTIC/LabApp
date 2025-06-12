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
        Schema::create('petrografias', function (Blueprint $table) {
            $table->id();

            // === SECCIÓN 1: INFORMACIÓN GENERAL ===
            $table->string('id_muestra')->unique();
            $table->decimal('longitud', 11, 8);
            $table->decimal('latitud', 10, 8);
            $table->decimal('altura', 8, 2);
            $table->string('sistema_coordenadas');
            $table->string('plancha')->nullable();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('vereda')->nullable();
            $table->string('cuenca')->nullable();
            $table->string('cuenca_principal')->nullable();
            $table->string('proyecto')->nullable();
            $table->string('colector')->nullable();
            $table->date('fecha_muestreo');
            $table->string('analizador')->nullable();
            $table->string('laboratorio_preparacion')->nullable();
            $table->string('tipo_preparacion')->nullable();
            $table->date('fecha_analisis')->nullable();

            // === SECCIÓN 2: DESCRIPCIÓN DE CAMPO ===
            $table->text('rodados')->nullable();
            $table->text('afloramientos')->nullable();
            $table->string('fotografia_general_seccion')->nullable();

            // === SECCIÓN 3: DESCRIPCIÓN PETROGRÁFICA (Solo campo general) ===
            $table->text('descripcion_petrografica_general')->nullable();

            // === SECCIÓN 4: CONTEO DE PUNTOS ===
            // Grupo Cuarzo (Q)
            $table->integer('conteo_qmon')->default(0);
            $table->integer('conteo_qpol')->default(0);
            $table->integer('conteo_qpf')->default(0);
            $table->integer('conteo_qmons')->default(0);
            // Grupo Feldespatos (F)
            $table->integer('conteo_f_plag')->default(0);
            $table->integer('conteo_f_kfelds')->default(0);
            // Grupo Líticos (L)
            $table->integer('conteo_lm')->default(0);
            $table->integer('conteo_lp')->default(0);
            $table->integer('conteo_lvf')->default(0);
            $table->integer('conteo_lvm')->default(0);
            $table->integer('conteo_lvl')->default(0);
            $table->integer('conteo_lvv')->default(0);
            $table->integer('conteo_lss')->default(0);
            $table->integer('conteo_lscm')->default(0);
            $table->integer('conteo_lssm')->default(0);
            $table->integer('conteo_lsch')->default(0);
            $table->integer('conteo_lsl')->default(0);
            // Grupo Minerales Accesorios
            $table->integer('conteo_ms')->default(0);
            $table->integer('conteo_bt')->default(0);
            $table->integer('conteo_px')->default(0);
            $table->integer('conteo_am')->default(0);
            $table->integer('conteo_chl')->default(0);
            $table->integer('conteo_ep')->default(0);
            $table->integer('conteo_zeo')->default(0);
            $table->integer('conteo_ol')->default(0);
            $table->integer('conteo_ttn')->default(0);
            $table->integer('conteo_zr')->default(0);
            $table->integer('conteo_tur')->default(0);
            $table->integer('conteo_glc')->default(0);
            // Grupo Componentes Intersticiales
            $table->integer('conteo_cmx')->default(0);
            $table->integer('conteo_ccm')->default(0);
            $table->integer('conteo_armx')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petrografias');
    }
};
