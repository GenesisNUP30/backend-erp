<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use Illuminate\Http\Request;

class CampaniaController extends Controller
{
    /*Display a listing of the resource.*/
    public function index()
    {
        $campanias = Campania::ordernarPorFechaInicio()->get();

        return response()->json([
            'success' => true,
            'data' => $campanias,
            'count' => $campanias->count()
        ]);
    }

    /*Store a newly created resource in storage.*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:campanias,nombre',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
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

    /*Display the specified resource.*/
    public function show(string $id)
    {
        $campania = Campania::find($id);

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

    /*Update the specified resource in storage.*/
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

    /*Remove the specified resource from storage.*/
    public function destroy(string $id)
    {
        $campania = Campania::find($id);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        $campania->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campaña eliminada correctamente'
        ]);
    }
}
