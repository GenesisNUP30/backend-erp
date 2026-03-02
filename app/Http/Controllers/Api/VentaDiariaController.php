<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VentaDiaria;
use Illuminate\Http\Request;

class VentaDiariaController extends Controller
{
    /**
     * Lista ventas diarias con filtros opcionales y paginación
     */
    public function index(Request $request)
    {
        $ventas = VentaDiaria::with(['cosecha', 'cosecha.plantacion', 'cosecha.plantacion.variedad'])
            ->cosecha($request->query('cosecha_id'))
            ->fechaDesde($request->query('fecha_desde'))
            ->fechaHasta($request->query('fecha_hasta'))
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $ventas->items(),
            'meta' => [
                'current_page' => $ventas->currentPage(),
                'last_page' => $ventas->lastPage(),
                'per_page' => $ventas->perPage(),
                'total' => $ventas->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva venta diaria
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date|before_or_equal:today',
            'cosecha_id' => 'required|exists:cosechas,id',
            'kilos_primera' => 'required|numeric|min:0',
            'precio_primera' => 'required|numeric|min:0',
            'kilos_industria' => 'required|numeric|min:0',
            'precio_industria' => 'required|numeric|min:0',
            'importe_total' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $venta = VentaDiaria::create($request->only([
            'fecha',
            'cosecha_id',
            'kilos_primera',
            'precio_primera',
            'kilos_industria',
            'precio_industria',
            'importe_total',
            'observaciones',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Venta diaria creada correctamente',
            'data' => $venta
        ], 201);
    }

    /**
     * Muestra una venta específica
     */
    public function show(string $id)
    {
        $venta = VentaDiaria::with(['cosecha', 'cosecha.plantacion', 'cosecha.plantacion.variedad'])->find($id);

        if (!$venta) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $venta
        ]);
    }

    /**
     * Actualiza una venta diaria existente
     */
    public function update(Request $request, string $id)
    {
        $venta = VentaDiaria::find($id);

        if (!$venta) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada'
            ], 404);
        }

        $request->validate([
            'fecha' => 'sometimes|required|date|before_or_equal:today',
            'cosecha_id' => 'sometimes|required|exists:cosechas,id',
            'kilos_primera' => 'sometimes|required|numeric|min:0',
            'precio_primera' => 'sometimes|required|numeric|min:0',
            'kilos_industria' => 'sometimes|required|numeric|min:0',
            'precio_industria' => 'sometimes|required|numeric|min:0',
            'importe_total' => 'sometimes|required|numeric|min:0',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $venta->update($request->only([
            'fecha',
            'cosecha_id',
            'kilos_primera',
            'precio_primera',
            'kilos_industria',
            'precio_industria',
            'importe_total',
            'observaciones',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Venta diaria actualizada correctamente',
            'data' => $venta
        ]);
    }

    /**
     * Elimina una venta diaria
     */
    public function destroy(string $id)
    {
        $venta = VentaDiaria::find($id);

        if (!$venta) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada'
            ], 404);
        }

        $venta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Venta diaria eliminada correctamente'
        ]);
    }
}
