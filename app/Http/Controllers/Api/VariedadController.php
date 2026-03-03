<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Variedad;
use Illuminate\Http\Request;

class VariedadController extends Controller
{
    /**
     * Lista variedades con filtros.
     */
    public function index(Request $request)
    {
        $variedades = Variedad::withCount('plantaciones')
            ->tipo($request->query('tipo'))
            ->orderBy('nombre')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $variedades->items(),
            'meta' => [
                'current_page' => $variedades->currentPage(),
                'last_page' => $variedades->lastPage(),
                'per_page' => $variedades->perPage(),
                'total' => $variedades->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva variedad.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:variedades,nombre',
            'tipo' => [
                'required|in:remontante,no_remontante',
            ],
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $variedad = Variedad::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Variedad creada correctamente',
            'data' => $variedad
        ], 201);
    }

    /**
     * Muestra una variedad específica.
     */
    public function show(string $id)
    {
        $variedad = Variedad::with([
            'plantaciones' => function ($query) {
                $query->with('parcela:id,nombre')
                    ->orderBy('fecha_siembra', 'desc');
            },
            'preciosSemanales' => function ($query) {
                $query->orderBy('semana_inicio', 'desc')->limit(5);
            }
        ])->find($id);

        if (!$variedad) {
            return response()->json([
                'success' => false,
                'message' => 'Variedad no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $variedad
        ]);
    }

    /**
     * Actualiza una variedad existente.
     */
    public function update(Request $request, string $id)
    {
        $variedad = Variedad::find($id);

        if (!$variedad) {
            return response()->json([
                'success' => false,
                'message' => 'Variedad no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:variedades,nombre,' . $id,
            'tipo' => [
                'sometimes|required|in:remontante,no_remontante',
            ],
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $variedad->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Variedad actualizada correctamente',
            'data' => $variedad
        ]);
    }

    /**
     * Elimina una variedad (soft delete con protección).
     */
    public function destroy(string $id)
    {
        $variedad = Variedad::withCount(['plantaciones', 'preciosSemanales'])->find($id);

        if (!$variedad) {
            return response()->json([
                'success' => false,
                'message' => 'Variedad no encontrada'
            ], 404);
        }

        if ($variedad->plantaciones_count > 0 || $variedad->preciosSemanales_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una variedad con registros asociados (plantaciones, precios semanales)',
            ], 409);
        }

        $variedad->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variedad eliminada correctamente'
        ]);
    }
}
