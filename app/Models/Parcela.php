<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'superficie_hectareas',
        'ubicacion',
        'estado',
    ];

    protected $casts = [
        'superficie_hectareas' => 'decimal:2',
    ];

    public $timestamps = false;

    // Relaciones
    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }

    // Scope para filtrar por estado
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }

        return $query;
    }
}
