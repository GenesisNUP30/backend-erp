<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations.*/
    public function up(): void
    {
        Schema::create('recolecciones', function (Blueprint $table) {
            // Campo clave primaria (PK) autoincremental
            $table->id();
            // Campo de clave foránea (FK) al cultivo (se elimina en cascada si se borra el cultivo)
            $table->foreignId('cultivo_id')
                ->constrained('cultivos')
                ->cascadeOnDelete();

            // FK al usuario que registra
            $table->foreignId('user_id')
                ->constrained('users');

            // Fecha de la recolección
            $table->date('fecha');
            // Kilos de primera calidad (tipo decimal máximo 999999.99)
            $table->decimal('kilos_primera', 8, 2)->default(0);
            // Kilos de industria (máx 999999.99)
            $table->decimal('kilos_industria', 8, 2)->default(0);
            // Observaciones opcionales
            $table->text('observaciones')->nullable();
            // Creación de campos created_at y updated_at (marcas temporales)
            $table->timestamps();
        });
    }

    /*Reverse the migrations.*/
    public function down(): void
    {
        // Elimina la tabla si existe
        Schema::dropIfExists('recolecciones');
    }
};


