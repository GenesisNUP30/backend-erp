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
        Schema::create('precios_semanales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variedad_id')
                ->constrained('variedades')
                ->cascadeOnDelete();
            $table->date('semana_inicio');
            $table->date('semana_fin');
            $table->decimal('precio_primera', 8, 2);
            $table->decimal('precio_industria', 8, 2);
            $table->unique(['variedad_id', 'semana_inicio', 'semana_fin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios_semanales');
    }
};
