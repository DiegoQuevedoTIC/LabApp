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
        Schema::create('mineral_descriptivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petrografia_id')->constrained()->cascadeOnDelete();
            $table->enum('tipo', ['opaco', 'translucido']);
            $table->string('mineral');
            $table->decimal('porcentaje', 5, 2);
            $table->decimal('tamano_promedio', 8, 4);
            $table->string('forma');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mineral_descriptivos');
    }
};
