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
        Schema::create('cultivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcela_id')
                ->constrained('parcelas')
                ->cascadeOnDelete();

            $table->foreignId('variedad_id')
                ->constrained('variedades');

            $table->foreignId('campania_id')
                ->constrained('campanias')
                ->cascadeOnDelete();

            $table->date('fecha_siembra');
            $table->integer('numero_plantas');

            $table->date('fecha_fin')->nullable();

            $table->enum('estado', [
                'sin_sembrar',
                'en_crecimiento',
                'en_recoleccion',
                'finalizado'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivos');
    }
};
