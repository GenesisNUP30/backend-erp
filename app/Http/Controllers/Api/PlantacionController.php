<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plantacion;
use Illuminate\Http\Request;

class PlantacionController extends Controller
{
    /**
     * Lista todas las plantaciones con filtros y paginación
     */
    public function index(Request $request)
    {
        $plantaciones = Plantacion::with([
            'parcela:id,nombre,ubicacion',
            'variedad:id,nombre,tipo'
        ])
            ->withCount('cosechas')
            ->estado($request->query('estado'))
            ->parcela($request->query('parcela_id'))
            ->variedad($request->query('variedad_id'))
            ->fechaSiembra(
                $request->query('fecha_desde'),
                $request->query('fecha_hasta')
            )
            ->orderBy('fecha_siembra', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $plantaciones->items(),
            'meta' => [
                'current_page' => $plantaciones->currentPage(),
                'last_page' => $plantaciones->lastPage(),
                'per_page' => $plantaciones->perPage(),
                'total' => $plantaciones->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva plantación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parcela_id' => 'required|exists:parcelas,id',
            'variedad_id' => 'required|exists:variedades,id',
            'fecha_siembra' => 'required|date|before_or_equal:today',
            'numero_plantas' => 'required|integer|min:1',
            'estado' => 'required|in:planificada,activa,finalizada',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_siembra',
        ]);

        $plantacion = Plantacion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Plantación creada correctamente',
            'data' => $plantacion->load(['parcela', 'variedad'])
        ], 201);
    }

    /**
     * Muestra una plantación específica
     */
    public function show(string $id)
    {
        $plantacion = Plantacion::with([
            'parcela',
            'variedad',
            'cosechas' => function ($query) {
                $query->with('campania:id,nombre,estado')
                    ->orderBy('fecha_inicio', 'desc');
            }
        ])->find($id);

        if (!$plantacion) {
            return response()->json([
                'success' => false,
                'message' => 'Plantación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $plantacion
        ]);
    }

    /**
     * Actualiza una plantación existente
     */
    public function update(Request $request, string $id)
    {
        $plantacion = Plantacion::find($id);

        if (!$plantacion) {
            return response()->json([
                'success' => false,
                'message' => 'Plantación no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'parcela_id' => 'sometimes|required|exists:parcelas,id',
            'variedad_id' => 'sometimes|required|exists:variedades,id',
            'fecha_siembra' => 'sometimes|required|date|before_or_equal:today',
            'numero_plantas' => 'sometimes|required|integer|min:1',
            'estado' => 'sometimes|required|in:planificada,activa,finalizada',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_siembra',
        ]);

        $plantacion->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Plantación actualizada correctamente',
            'data' => $plantacion->fresh()
        ]);
    }

    /**
     * Elimina una plantación (si no tiene cosechas asociadas)
     */
    public function destroy(string $id)
    {
        $plantacion = Plantacion::withCount('cosechas')->find($id);

        if (!$plantacion) {
            return response()->json([
                'success' => false,
                'message' => 'Plantación no encontrada'
            ], 404);
        }

        if ($plantacion->cosechas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una plantación con cosechas asociadas'
            ], 400);
        }

        $plantacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Plantación eliminada correctamente'
        ]);
    }
}
