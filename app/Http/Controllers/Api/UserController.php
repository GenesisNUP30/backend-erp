<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'dni' => 'required|string|unique:users,dni|regex:/^[0-9]{8}[A-Z]$/',
            'telefono' => 'required|string|regex:/^[67][0-9]{8}$/',
            'rol' => 'required|in:encargado,recolector,administrador',
            'fecha_alta' => 'required|date|before_or_equal:today',
        ]);

        $trabajador = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'fecha_alta' => $request->fecha_alta,
            'fecha_baja' => $request->fecha_baja ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'El trabajador ha sido creado correctamente',
            'data' => $trabajador
        ], 201);
    }
}
