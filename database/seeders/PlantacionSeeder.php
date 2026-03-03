<?php

namespace Database\Seeders;

use App\Models\Parcela;
use App\Models\Plantacion;
use App\Models\Variedad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de parcelas existentes
        $parcela1 = Parcela::where('nombre', 'Parcela 1')->first()->id;
        $parcela2 = Parcela::where('nombre', 'Parcela 2')->first()->id;

        // Obtener IDs de variedades existentes
        $noelia = Variedad::where('nombre', 'Noelia (R15)')->first()->id;
        $adelita = Variedad::where('nombre', 'Adelita')->first()->id;
        $lyon = Variedad::where('nombre', 'Lyon (Glen Lyon)')->first()->id;
        $clarita = Variedad::where('nombre', 'Clarita')->first()->id;
        $alegria = Variedad::where('nombre', 'Alegría')->first()->id;
        $heritage = Variedad::where('nombre', 'Heritage')->first()->id;
        $maravilla = Variedad::where('nombre', 'Maravilla (Driscoll\'s Maravilla)')->first()->id;

        // Parcela 1 - Variedad Noelia (R15) - Plantación principal activa
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $noelia,
            'fecha_siembra' => '2023-02-10',
            'numero_plantas' => 3200,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);

        // Parcela 1 - Variedad Adelita - Plantación secundaria activa
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $adelita,
            'fecha_siembra' => '2023-03-15',
            'numero_plantas' => 1800,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);

        // Parcela 2 - Variedad Lyon (Glen Lyon) - Plantación no remontante
        Plantacion::create([
            'parcela_id' => $parcela2,
            'variedad_id' => $lyon,
            'fecha_siembra' => '2022-11-20',
            'numero_plantas' => 2400,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);

        // Parcela 2 - Variedad Clarita - Plantación en parcela pequeña
        Plantacion::create([
            'parcela_id' => $parcela2,
            'variedad_id' => $clarita,
            'fecha_siembra' => '2024-01-25',
            'numero_plantas' => 1200,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);

        // Parcela 1 - Variedad Alegría - Plantación nueva planificada para 2025
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $alegria,
            'fecha_siembra' => '2025-02-20',
            'numero_plantas' => 2000,
            'fecha_fin' => null,
            'estado' => 'planificada',
        ]);

        // Parcela 2 - Variedad Heritage - Plantación finalizada (replantación)
        Plantacion::create([
            'parcela_id' => $parcela2,
            'variedad_id' => $heritage,
            'fecha_siembra' => '2020-03-05',
            'numero_plantas' => 1500,
            'fecha_fin' => '2023-11-30',
            'estado' => 'finalizada',
        ]);

        // Parcela 1 - Variedad Maravilla - Plantación premium en expansión
        Plantacion::create([
            'parcela_id' => $parcela1,
            'variedad_id' => $maravilla,
            'fecha_siembra' => '2024-09-10',
            'numero_plantas' => 1000,
            'fecha_fin' => null,
            'estado' => 'activa',
        ]);
    }
}
