<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la lista de trabajadores (usuarios no administradores).
     *
     * @return void
     */
    public function index()
    {
        $trabajadores = User::where ('rol', '!=', 'administrador')
        ->select('id', 'name', 'username', 'dni', 'telefono', 'rol', 'fecha_alta', 'fecha_baja')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $trabajadores,
            'count' => $trabajadores->count()
        ]);
    }

    public function show ($id)
    {
        $trabajador = User::where('rol', '!=','administrador')
        ->where('id', $id)
        ->select('id', 'name', 'username', 'dni', 'telefono', 'rol', 'fecha_alta', 'fecha_baja')
        ->first();

        if (!$trabajador) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el trabajador solicitado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $trabajador
        ]);
    }

    
}
