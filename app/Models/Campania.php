<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campania extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
    ];

    public $timestamps = false;

    // Relaciones
    public function cosechas()
    {
        return $this->hasMany(Cosecha::class);
    }

    /**
     * Scopes para filtrado eficiente.
     */
    public function scopeEstado($query, ?string $estado)
    {
        return $estado ? $query->where('estado', $estado) : $query;
    }

    public function scopeFechas($query, ?string $inicio, ?string $fin)
    {
        if ($inicio) {
            $query->whereDate('fecha_inicio', '>=', $inicio);
        }
        if ($fin) {
            $query->whereDate('fecha_fin', '<=', $fin);
        }
        return $query;
    }

    /**
     * Accesor para duración de la campaña en días.
     */
    public function getDuracionAttribute(): int
    {
        return $this->fecha_inicio->diffInDays($this->fecha_fin);
    }
}
