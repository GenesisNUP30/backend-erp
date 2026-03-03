<?php

namespace Database\Seeders;

use App\Models\Cosecha;
use App\Models\Recoleccion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecoleccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de recolectores (usuarios con rol 'recolector')
        $juan = User::where('username', 'juanperez')->first()->id;        // ID 3
        $ana = User::where('username', 'anamartinez')->first()->id;       // ID 4 (fecha_baja: 2025-01-20)
        $luis = User::where('username', 'luisfernandez')->first()->id;    // ID 5
        $laura = User::where('username', 'lauragr')->first()->id;         // ID 6
        $dani = User::where('username', 'danisanchez')->first()->id;      // ID 7 (fecha_baja: 2025-02-15)

        // Obtener IDs de cosechas activas/finalizadas
        $cosecha_noelia_oto23 = Cosecha::whereHas('plantacion.variedad', fn($q) => $q->where('nombre', 'Noelia (R15)'))
            ->whereHas('campania', fn($q) => $q->where('nombre', 'Prueba 1 Campaña Otoño 2023-2024'))
            ->first()->id;

        $cosecha_adelita_oto23 = Cosecha::whereHas('plantacion.variedad', fn($q) => $q->where('nombre', 'Adelita'))
            ->whereHas('campania', fn($q) => $q->where('nombre', 'Prueba 1 Campaña Otoño 2023-2024'))
            ->first()->id;

        $cosecha_lyon_pri24 = Cosecha::whereHas('plantacion.variedad', fn($q) => $q->where('nombre', 'Lyon (Glen Lyon)'))
            ->whereHas('campania', fn($q) => $q->where('nombre', 'Prueba 2 Campaña Primavera 2024-2025'))
            ->first()->id;

        $cosecha_noelia_oto25 = Cosecha::whereHas('plantacion.variedad', fn($q) => $q->where('nombre', 'Noelia (R15)'))
            ->whereHas('campania', fn($q) => $q->where('nombre', 'Prueba 3 Campaña Otoño 2025-2026'))
            ->first()->id;

        // Recolectores campaña Otoño 2023-2024 (finalizada)
        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto23,
            'user_id' => $juan,
            'fecha' => '2023-10-15',
            'kilos_primera' => 42.50,
            'kilos_industria' => 8.75,
            'observaciones' => 'Buena calidad, fruta firme. Jornada completa de 6 horas.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto23,
            'user_id' => $luis,
            'fecha' => '2023-10-15',
            'kilos_primera' => 38.20,
            'kilos_industria' => 12.40,
            'observaciones' => 'Algunas zonas con exceso de humedad afectaron calidad.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_adelita_oto23,
            'user_id' => $laura,
            'fecha' => '2023-11-05',
            'kilos_primera' => 45.80,
            'kilos_industria' => 6.30,
            'observaciones' => 'Excelente día de recolección. Fruta de primera calidad.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_adelita_oto23,
            'user_id' => $juan,
            'fecha' => '2023-11-05',
            'kilos_primera' => 40.10,
            'kilos_industria' => 9.50,
            'observaciones' => 'Recolección en parcela 1 sector norte.',
        ]);

        // Recolectores campaña Primavera 2024-2025 (finalizada)
        Recoleccion::create([
            'cosecha_id' => $cosecha_lyon_pri24,
            'user_id' => $ana,
            'fecha' => '2024-04-12',
            'kilos_primera' => 35.60,
            'kilos_industria' => 15.20,
            'observaciones' => 'Día lluvioso, afectó rendimiento. Calidad media.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_lyon_pri24,
            'user_id' => $luis,
            'fecha' => '2024-04-12',
            'kilos_primera' => 39.40,
            'kilos_industria' => 10.80,
            'observaciones' => 'Buena producción en sector sur de parcela 2.',
        ]);

        // Recolectores campaña Otoño 2025-2026 (en curso - datos recientes)
        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto25,
            'user_id' => $juan,
            'fecha' => '2025-09-25',
            'kilos_primera' => 48.75,
            'kilos_industria' => 7.25,
            'observaciones' => 'Inicio de campaña. Fruta excelente, tamaño uniforme.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto25,
            'user_id' => $laura,
            'fecha' => '2025-09-25',
            'kilos_primera' => 52.30,
            'kilos_industria' => 5.80,
            'observaciones' => 'Récord de producción diaria. Calidad premium.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto25,
            'user_id' => $luis,
            'fecha' => '2025-09-25',
            'kilos_primera' => 44.90,
            'kilos_industria' => 9.10,
            'observaciones' => 'Jornada completa. Algunas plantas necesitan poda ligera.',
        ]);

        // Dato reciente (ayer) para mostrar actividad actual
        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto25,
            'user_id' => $juan,
            'fecha' => now()->subDay()->toDateString(),
            'kilos_primera' => 46.20,
            'kilos_industria' => 8.40,
            'observaciones' => 'Continúa buena producción. Clima favorable.',
        ]);

        Recoleccion::create([
            'cosecha_id' => $cosecha_noelia_oto25,
            'user_id' => $laura,
            'fecha' => now()->subDay()->toDateString(),
            'kilos_primera' => 49.80,
            'kilos_industria' => 6.70,
            'observaciones' => 'Segunda jornada consecutiva de alta producción.',
        ]);
    }
}
