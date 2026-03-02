<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recoleccion;
use Illuminate\Http\Request;

class RecoleccionController extends Controller
{
    /**
     * Lista recolecciones con filtros opcionales y paginación
     */
    public function index(Request $request)
    {
        $recolecciones = Recoleccion::with(['cosecha', 'cosecha.plantacion', 'cosecha.plantacion.variedad', 'recolector'])
            ->cosecha($request->query('cosecha_id'))
            ->recolector($request->query('user_id'))
            ->fechaDesde($request->query('fecha_desde'))
            ->fechaHasta($request->query('fecha_hasta'))
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $recolecciones->items(),
            'meta' => [
                'current_page' => $recolecciones->currentPage(),
                'last_page' => $recolecciones->lastPage(),
                'per_page' => $recolecciones->perPage(),
                'total' => $recolecciones->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva recolección
     */
    public function store(Request $request)
    {
        $request->validate([
            'cosecha_id' => 'required|exists:cosechas,id',
            'user_id' => 'required|exists:users,id',
            'fecha' => 'required|date|before_or_equal:today',
            'kilos_primera' => 'required|numeric|min:0',
            'kilos_industria' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $recoleccion = Recoleccion::create($request->only([
            'cosecha_id',
            'user_id',
            'fecha',
            'kilos_primera',
            'kilos_industria',
            'observaciones'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Recolección creada correctamente',
            'data' => $recoleccion
        ], 201);
    }

    /**
     * Muestra una recolección específica
     */
    public function show(string $id)
    {
        $recoleccion = Recoleccion::with(['cosecha', 'cosecha.plantacion', 'cosecha.plantacion.variedad', 'recolector'])->find($id);

        if (!$recoleccion) {
            return response()->json([
                'success' => false,
                'message' => 'Recolección no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recoleccion
        ]);
    }

    /**
     * Actualiza una recolección existente
     */
    public function update(Request $request, string $id)
    {
        $recoleccion = Recoleccion::find($id);

        if (!$recoleccion) {
            return response()->json([
                'success' => false,
                'message' => 'Recolección no encontrada'
            ], 404);
        }

        $request->validate([
            'cosecha_id' => 'sometimes|required|exists:cosechas,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'fecha' => 'sometimes|required|date|before_or_equal:today',
            'kilos_primera' => 'sometimes|required|numeric|min:0',
            'kilos_industria' => 'sometimes|required|numeric|min:0',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $recoleccion->update($request->only([
            'cosecha_id',
            'user_id',
            'fecha',
            'kilos_primera',
            'kilos_industria',
            'observaciones'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Recolección actualizada correctamente',
            'data' => $recoleccion
        ]);
    }

    /**
     * Elimina una recolección
     */
    public function destroy(string $id)
    {
        $recoleccion = Recoleccion::find($id);

        if (!$recoleccion) {
            return response()->json([
                'success' => false,
                'message' => 'Recolección no encontrada'
            ], 404);
        }

        $recoleccion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recolección eliminada correctamente'
        ]);
    }
}
