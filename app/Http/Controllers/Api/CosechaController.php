<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cosecha;
use Illuminate\Http\Request;

class CosechaController extends Controller
{
    /**
     * Lista todas las cosechas con filtros y paginación
     */
    public function index(Request $request)
    {
        $cosechas = Cosecha::with([
            'plantacion.parcela:id,nombre',
            'plantacion.variedad:id,nombre',
            'campania:id,nombre,estado'
        ])
            ->withCount('recolecciones')
            ->estado($request->query('estado'))
            ->plantacion($request->query('plantacion_id'))
            ->campania($request->query('campania_id'))
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $cosechas->items(),
            'meta' => [
                'current_page' => $cosechas->currentPage(),
                'last_page' => $cosechas->lastPage(),
                'per_page' => $cosechas->perPage(),
                'total' => $cosechas->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva cosecha
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plantacion_id' => 'required|exists:plantaciones,id',
            'campania_id' => 'required|exists:campanias,id',
            'numero_cosecha' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => [
                'required|in:en_crecimiento,en_recoleccion,en_poda,finalizada',
            ],
        ]);

        // Validación de unicidad compuesta (plantacion + campaña + número)
        $exists = Cosecha::where('plantacion_id', $validated['plantacion_id'])
            ->where('campania_id', $validated['campania_id'])
            ->where('numero_cosecha', $validated['numero_cosecha'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una cosecha con este número para la plantación y campaña seleccionadas',
            ], 422);
        }

        $cosecha = Cosecha::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cosecha creada correctamente',
            'data' => $cosecha->load([
                'plantacion.parcela:id,nombre',
                'plantacion.variedad:id,nombre',
                'campania:id,nombre'
            ])
        ], 201);
    }

    /**
     * Muestra una cosecha específica
     */
    public function show(string $id)
    {
        $cosecha = Cosecha::with([
            'plantacion.parcela',
            'plantacion.variedad',
            'campania',
            'recolecciones.user:id,name,username,rol'
        ])->find($id);

        if (!$cosecha) {
            return response()->json([
                'success' => false,
                'message' => 'Cosecha no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $cosecha
        ]);
    }

    /**
     * Actualiza una cosecha existente
     */
    public function update(Request $request, string $id)
    {
        $cosecha = Cosecha::find($id);

        if (!$cosecha) {
            return response()->json([
                'success' => false,
                'message' => 'Cosecha no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'plantacion_id' => 'sometimes|required|exists:plantaciones,id',
            'campania_id' => 'sometimes|required|exists:campanias,id',
            'numero_cosecha' => 'sometimes|required|integer|min:1',
            'fecha_inicio' => 'sometimes|required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => [
                'sometimes',
                'required|in:en_crecimiento,en_recoleccion,en_poda,finalizada'
            ],
        ]);

        // Validación de unicidad compuesta (excluyendo registro actual)
        if (isset($validated['plantacion_id'], $validated['campania_id'], $validated['numero_cosecha'])) {
            $exists = Cosecha::where('plantacion_id', $validated['plantacion_id'])
                ->where('campania_id', $validated['campania_id'])
                ->where('numero_cosecha', $validated['numero_cosecha'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe otra cosecha con este número para la plantación y campaña seleccionadas',
                ], 422);
            }
        }

        $cosecha->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cosecha actualizada correctamente',
            'data' => $cosecha->fresh()
        ]);
    }

    /**
     * Elimina una cosecha (si no tiene recolecciones asociadas)
     */
    public function destroy(string $id)
    {
        $cosecha = Cosecha::withCount(['recolecciones', 'ventasDiarias', 'consumoAgua'])->find($id);

        if (!$cosecha) {
            return response()->json([
                'success' => false,
                'message' => 'Cosecha no encontrada'
            ], 404);
        }

        // Protección contra eliminación si tiene registros asociados
        if (
            $cosecha->recolecciones_count > 0 ||
            $cosecha->ventas_diarias_count > 0 ||
            $cosecha->consumo_agua_count > 0
        ) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una cosecha con registros asociados (recolecciones, ventas o consumo de agua)',
            ], 409);
        }

        $cosecha->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cosecha eliminada correctamente'
        ]);
    }
}
