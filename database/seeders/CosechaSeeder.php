<?php

namespace Database\Seeders;

use App\Models\Campania;
use App\Models\Cosecha;
use App\Models\Plantacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CosechaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de campañas existentes
        $campania1 = Campania::where('nombre', 'Prueba 1 Campaña Otoño 2023-2024')->first()->id;
        $campania2 = Campania::where('nombre', 'Prueba 2 Campaña Primavera 2024-2025')->first()->id;
        $campania3 = Campania::where('nombre', 'Prueba 3 Campaña Otoño 2025-2026')->first()->id;
        $campania4 = Campania::where('nombre', 'Prueba 4 Campaña Primavera 2025-2026')->first()->id;
        $campania5 = Campania::where('nombre', 'Prueba 5 Campaña Otoño 2026-2027')->first()->id;

        // Obtener IDs de plantaciones según variedades y parcelas
        $noelia_p1 = Plantacion::whereHas('parcela', fn($q) => $q->where('nombre', 'Parcela 1'))
            ->whereHas('variedad', fn($q) => $q->where('nombre', 'Noelia (R15)'))
            ->where('estado', 'activa')
            ->first()->id;

        $adelita_p1 = Plantacion::whereHas('parcela', fn($q) => $q->where('nombre', 'Parcela 1'))
            ->whereHas('variedad', fn($q) => $q->where('nombre', 'Adelita'))
            ->where('estado', 'activa')
            ->first()->id;

        $lyon_p2 = Plantacion::whereHas('parcela', fn($q) => $q->where('nombre', 'Parcela 2'))
            ->whereHas('variedad', fn($q) => $q->where('nombre', 'Lyon (Glen Lyon)'))
            ->where('estado', 'activa')
            ->first()->id;

        $clarita_p2 = Plantacion::whereHas('parcela', fn($q) => $q->where('nombre', 'Parcela 2'))
            ->whereHas('variedad', fn($q) => $q->where('nombre', 'Clarita'))
            ->where('estado', 'activa')
            ->first()->id;

        $maravilla_p1 = Plantacion::whereHas('parcela', fn($q) => $q->where('nombre', 'Parcela 1'))
            ->whereHas('variedad', fn($q) => $q->where('nombre', 'Maravilla (Driscoll\'s Maravilla)'))
            ->where('estado', 'activa')
            ->first()->id;

        // Cosecha 1: Noelia Parcela 1 - Campaña Otoño 2023-2024 (finalizada)
        Cosecha::create([
            'plantacion_id' => $noelia_p1,
            'campania_id' => $campania1,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2023-09-25',
            'fecha_fin' => '2024-01-05',
            'estado' => 'finalizada',
        ]);

        // Cosecha 2: Adelita Parcela 1 - Campaña Otoño 2023-2024 (finalizada)
        Cosecha::create([
            'plantacion_id' => $adelita_p1,
            'campania_id' => $campania1,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2023-10-10',
            'fecha_fin' => '2024-01-06',
            'estado' => 'finalizada',
        ]);

        // Cosecha 3: Lyon Parcela 2 - Campaña Primavera 2024-2025 (finalizada)
        Cosecha::create([
            'plantacion_id' => $lyon_p2,
            'campania_id' => $campania2,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2024-02-15',
            'fecha_fin' => '2024-06-25',
            'estado' => 'finalizada',
        ]);

        // Cosecha 4: Clarita Parcela 2 - Campaña Primavera 2024-2025 (finalizada)
        Cosecha::create([
            'plantacion_id' => $clarita_p2,
            'campania_id' => $campania2,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2024-03-01',
            'fecha_fin' => '2024-06-20',
            'estado' => 'finalizada',
        ]);

        // Cosecha 5: Noelia Parcela 1 - Campaña Otoño 2025-2026 (en recolección)
        Cosecha::create([
            'plantacion_id' => $noelia_p1,
            'campania_id' => $campania3,
            'numero_cosecha' => 2,
            'fecha_inicio' => '2025-09-15',
            'fecha_fin' => null,
            'estado' => 'en_recoleccion',
        ]);

        // Cosecha 6: Adelita Parcela 1 - Campaña Otoño 2025-2026 (en recolección)
        Cosecha::create([
            'plantacion_id' => $adelita_p1,
            'campania_id' => $campania3,
            'numero_cosecha' => 2,
            'fecha_inicio' => '2025-09-20',
            'fecha_fin' => null,
            'estado' => 'en_recoleccion',
        ]);

        // Cosecha 7: Lyon Parcela 2 - Campaña Otoño 2025-2026 (en crecimiento)
        Cosecha::create([
            'plantacion_id' => $lyon_p2,
            'campania_id' => $campania3,
            'numero_cosecha' => 2,
            'fecha_inicio' => '2025-08-01',
            'fecha_fin' => null,
            'estado' => 'en_crecimiento',
        ]);

        // Cosecha 8: Maravilla Parcela 1 - Campaña Otoño 2025-2026 (en poda)
        Cosecha::create([
            'plantacion_id' => $maravilla_p1,
            'campania_id' => $campania3,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2025-09-12',
            'fecha_fin' => '2025-10-30',
            'estado' => 'en_poda',
        ]);

        // Cosecha 9: Clarita Parcela 2 - Campaña Primavera 2025-2026 (planificada)
        Cosecha::create([
            'plantacion_id' => $clarita_p2,
            'campania_id' => $campania4,
            'numero_cosecha' => 2,
            'fecha_inicio' => '2026-02-20',
            'fecha_fin' => null,
            'estado' => 'en_crecimiento',
        ]);

        // Cosecha 10: Alegría Parcela 1 - Campaña Otoño 2026-2027 (planificada)
        Cosecha::create([
            'plantacion_id' => Plantacion::whereHas('variedad', fn($q) => $q->where('nombre', 'Alegría'))->first()->id,
            'campania_id' => $campania5,
            'numero_cosecha' => 1,
            'fecha_inicio' => '2026-10-25',
            'fecha_fin' => null,
            'estado' => 'en_crecimiento',
        ]);
    }
}
