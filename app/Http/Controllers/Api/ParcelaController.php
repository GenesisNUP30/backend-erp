<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    /**
     * Lista las parcelas con filtros y paginación
     */
    public function index(Request $request)
    {
        $parcelas = Parcela::query()
            ->estado($request->query('estado'))
            ->orderBy('nombre')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $parcelas->items(),
            'meta' => [
                'current_page' => $parcelas->currentPage(),
                'last_page' => $parcelas->lastPage(),
                'per_page' => $parcelas->perPage(),
                'total' => $parcelas->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva parcela
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:parcelas,nombre',
            'superficie_hectareas' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva,mantenimiento'
        ]);

        $parcela = Parcela::create($request->only(['nombre', 'superficie_hectareas', 'ubicacion', 'estado']));

        return response()->json([
            'success' => true,
            'message' => 'Parcela creada correctamente',
            'data' => $parcela
        ], 201);
    }

    /**
     * Muestra una parcela especificada por su id
     */
    public function show(string $id)
    {
        $parcela = Parcela::with('plantaciones')->find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $parcela
        ]);
    }

    /**
     * Actualiza una parcela existente
     */
    public function update(Request $request, string $id)
    {
        $parcela = Parcela::find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:parcelas,nombre,' . $id,
            'superficie_hectareas' => 'sometimes|required|numeric|min:0',
            'ubicacion' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|in:activa,inactiva,mantenimiento'
        ]);

        $parcela->update($request->only(['nombre', 'superficie_hectareas', 'ubicacion', 'estado']));

        return response()->json([
            'success' => true,
            'message' => 'Parcela actualizada correctamente',
            'data' => $parcela
        ]);
    }

    /**
     * Elimina una parcela (si no tiene plantaciones asociadas)
     */
    public function destroy(string $id)
    {
        $parcela = Parcela::withCount('plantaciones')->find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        if ($parcela->plantaciones_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una parcela con plantaciones asociadas'
            ], 400);
        }

        $parcela->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parcela eliminada correctamente'
        ]);
    }
}
