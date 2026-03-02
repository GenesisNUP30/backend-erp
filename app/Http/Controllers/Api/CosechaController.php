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
        $cosechas = Cosecha::with(['plantacion', 'plantacion.variedad', 'campania', 'recolecciones'])
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
        $request->validate([
            'plantacion_id' => 'required|exists:plantaciones,id',
            'campania_id' => 'required|exists:campanias,id',
            'numero_cosecha' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:activa,finalizada',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $cosecha = Cosecha::create($request->only([
            'plantacion_id',
            'campania_id',
            'numero_cosecha',
            'fecha_inicio',
            'estado',
            'fecha_fin'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Cosecha creada correctamente',
            'data' => $cosecha
        ], 201);
    }

    /**
     * Muestra una cosecha específica
     */
    public function show(string $id)
    {
        $cosecha = Cosecha::with(['plantacion', 'plantacion.variedad', 'campania', 'recolecciones'])->find($id);

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

        $request->validate([
            'plantacion_id' => 'sometimes|required|exists:plantaciones,id',
            'campania_id' => 'sometimes|required|exists:campanias,id',
            'numero_cosecha' => 'sometimes|required|integer|min:1',
            'fecha_inicio' => 'sometimes|required|date|before_or_equal:today',
            'estado' => 'sometimes|required|in:activa,finalizada',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $cosecha->update($request->only([
            'plantacion_id',
            'campania_id',
            'numero_cosecha',
            'fecha_inicio',
            'estado',
            'fecha_fin'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Cosecha actualizada correctamente',
            'data' => $cosecha
        ]);
    }

    /**
     * Elimina una cosecha (si no tiene recolecciones asociadas)
     */
    public function destroy(string $id)
    {
        $cosecha = Cosecha::withCount('recolecciones')->find($id);

        if (!$cosecha) {
            return response()->json([
                'success' => false,
                'message' => 'Cosecha no encontrada'
            ], 404);
        }

        if ($cosecha->recolecciones_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una cosecha con recolecciones asociadas'
            ], 400);
        }

        $cosecha->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cosecha eliminada correctamente'
        ]);
    }
}
