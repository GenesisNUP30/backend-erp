<?php

namespace App\Policies;

use App\Models\Recoleccion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecoleccionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEncargado();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Recoleccion $recoleccion): bool
    {
        if ($user->isAdmin() || $user->isEncargado()) {
            return true;
        }

        // Los recolectores solo pueden ver sus propias recolecciones
        return $user->isRecolector() && $user->id === $recoleccion->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEncargado();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recoleccion $recoleccion): bool
    {
        return $user->isAdmin() || $user->isEncargado();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recoleccion $recoleccion): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Recoleccion $recoleccion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Recoleccion $recoleccion): bool
    {
        return false;
    }
}
