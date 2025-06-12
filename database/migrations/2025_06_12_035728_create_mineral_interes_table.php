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
        Schema::create('mineral_interes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petrografia_id')->constrained()->cascadeOnDelete();
            $table->string('mineral');
            $table->integer('numero_cristal');
            $table->decimal('largo', 8, 4);
            $table->decimal('ancho', 8, 4);
            $table->string('geometria');
            $table->text('observaciones')->nullable();
            $table->string('foto1')->nullable();
            $table->string('foto2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mineral_interes');
    }
};
