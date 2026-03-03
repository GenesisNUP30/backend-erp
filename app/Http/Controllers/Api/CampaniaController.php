<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use Illuminate\Http\Request;

class CampaniaController extends Controller
{
    // Lista campañas con paginación y filtros.
    public function index(Request $request)
    {
        $campanias = Campania::withCount('cosechas')
            ->estado($request->query('estado'))
            ->fechas($request->query('fecha_inicio'), $request->query('fecha_fin'))
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $campanias->items(),
            'meta' => [
                'current_page' => $campanias->currentPage(),
                'last_page' => $campanias->lastPage(),
                'per_page' => $campanias->perPage(),
                'total' => $campanias->total(),
            ]
        ]);
    }

    // Crea una nueva campaña con validación robusta.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:campanias,nombre',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activa,finalizada,planificada',
        ]);

        $campania = Campania::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Campaña creada correctamente',
            'data' => $campania
        ], 201);
    }

    // Muestra una campaña específica con relaciones esenciales.
    public function show(string $id)
    {
        $campania = Campania::withCount('cosechas')->find($id);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $campania
        ]);
    }

    // Actualiza una campaña existente con validación condicional.
    public function update(Request $request, string $id)
    {
        $campania = Campania::find($id);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:campanias,nombre,' . $id,
            'fecha_inicio' => 'sometimes|required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'estado' => 'sometimes|required|in:activa,finalizada,planificada',
        ]);

        $campania->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Campaña actualizada correctamente',
            'data' => $campania
        ]);
    }

    // Elimina una campaña (soft delete) con protección de integridad.
    public function destroy(string $id)
    {
        $campania = Campania::withCount('cosechas')->find($id);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        if ($campania->cosechas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una campaña con cosechas asociadas',
            ], 409);
        }

        $campania->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campaña eliminada correctamente'
        ]);
    }
}
