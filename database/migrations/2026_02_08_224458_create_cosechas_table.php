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
        Schema::create('cosechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plantacion_id')
                ->constrained('plantaciones')
                ->cascadeOnDelete();

            $table->foreignId('campania_id')
                ->constrained('campanias')
                ->cascadeOnDelete();

            $table->integer('numero_cosecha');

            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            $table->enum('estado', [
                'en_crecimiento',
                'en_recoleccion',
                'en_poda',
                'finalizada',
            ]);
            $table->timestamps();

            $table->unique(['plantacion_id', 'campania_id', 'numero_cosecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosechas');
    }
};
