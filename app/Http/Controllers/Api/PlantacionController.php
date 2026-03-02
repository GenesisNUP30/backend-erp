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
        $plantaciones = Plantacion::with(['parcela', 'variedad', 'cosechas'])
            ->when($request->query('estado'), function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->when($request->query('parcela_id'), function ($query, $parcela_id) {
                $query->where('parcela_id', $parcela_id);
            })
            ->when($request->query('variedad_id'), function ($query, $variedad_id) {
                $query->where('variedad_id', $variedad_id);
            })
            ->orderBy('fecha_siembra', 'desc')
            ->paginate(10);

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
        $request->validate([
            'parcela_id' => 'required|exists:parcelas,id',
            'variedad_id' => 'required|exists:variedades,id',
            'campania_id' => 'required|exists:campanias,id',
            'fecha_siembra' => 'required|date|before_or_equal:today',
            'numero_plantas' => 'required|integer|min:1',
            'estado' => 'required|in:plantado,en_crecimiento,en_recoleccion,poda,finalizado',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_siembra',
        ]);

        $plantacion = Plantacion::create($request->only([
            'parcela_id',
            'variedad_id',
            'campania_id',
            'fecha_siembra',
            'numero_plantas',
            'estado',
            'fecha_fin'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Plantación creada correctamente',
            'data' => $plantacion
        ], 201);
    }

    /**
     * Muestra una plantación específica
     */
    public function show(string $id)
    {
        $plantacion = Plantacion::with(['parcela', 'variedad', 'cosechas'])->find($id);

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

        $request->validate([
            'parcela_id' => 'sometimes|required|exists:parcelas,id',
            'variedad_id' => 'sometimes|required|exists:variedades,id',
            'campania_id' => 'sometimes|required|exists:campanias,id',
            'fecha_siembra' => 'sometimes|required|date|before_or_equal:today',
            'numero_plantas' => 'sometimes|required|integer|min:1',
            'estado' => 'sometimes|required|in:plantado,en_crecimiento,en_recoleccion,poda,finalizado',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_siembra',
        ]);

        $plantacion->update($request->only([
            'parcela_id',
            'variedad_id',
            'campania_id',
            'fecha_siembra',
            'numero_plantas',
            'estado',
            'fecha_fin'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Plantación actualizada correctamente',
            'data' => $plantacion
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
