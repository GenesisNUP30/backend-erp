<?php

namespace Database\Seeders;

use App\Models\Campania;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Campaña finalizada (temporada 2023-2024)
        Campania::create([
            'nombre' => 'Prueba 1 Campaña Otoño 2023-2024',
            'fecha_inicio' => '2023-11-15',
            'fecha_fin' => '2024-01-06',
            'descripcion' => 'Prueba 1 campaña otoño 2023-2024',
            'estado' => 'finalizada',
        ]);

        // Campaña finalizada (temporada 2024-2025)
        Campania::create([
            'nombre' => 'Prueba 2 Campaña Primavera 2024-2025',
            'fecha_inicio' => '2024-02-05',
            'fecha_fin' => '2025-06-30',
            'descripcion' => 'Prueba 2 campaña primavera 2024-2025',
            'estado' => 'finalizada',
        ]);

        // Campaña finalizada invierno (temporada 2025-2026)
        Campania::create([
            'nombre' => 'Prueba 3 Campaña Otoño 2025-2026',
            'fecha_inicio' => '2025-09-10',
            'fecha_fin' => '2026-07-05',
            'descripcion' => 'Prueba 3 campaña otoño 2025-2026',
            'estado' => 'finalizada',
        ]);

        // Campaña activa primavera (temporada 2025-2026)
        Campania::create([
            'nombre' => 'Prueba 4 Campaña Primavera 2025-2026',
            'fecha_inicio' => '2026-02-15',
            'descripcion' => 'Prueba 4 campaña primavera 2026-2027',
            'estado' => 'activa',
        ]);

        // Campaña planificada (temporada 2026-2027)
        Campania::create([
            'nombre' => 'Prueba 5 Campaña Otoño 2026-2027',
            'fecha_inicio' => '2026-10-21',
            'fecha_fin' => '2027-01-15',
            'descripcion' => 'Prueba 5 campaña otoño 2026-2027',
            'estado' => 'planificada',
        ]);
    }
}
