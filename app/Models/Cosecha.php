<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cosecha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cosechas';

    protected $fillable = [
        'plantacion_id',
        'campania_id',
        'numero_cosecha',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
        'numero_cosecha' => 'integer',
    ];

    // public $timestamps = false;

    // Relaciones
    public function plantacion()
    {
        return $this->belongsTo(Plantacion::class);
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class);
    }

    public function recolecciones()
    {
        return $this->hasMany(Recoleccion::class);
    }

    public function ventas()
    {
        return $this->hasMany(VentaDiaria::class);
    }

    // Scopes para filtros
    public function scopeEstado($query, ?string $estado)
    {
        return $estado ? $query->where('estado', $estado) : $query;
    }

    public function scopePlantacion($query, ?int $plantacion_id)
    {
        return $plantacion_id ? $query->where('plantacion_id', $plantacion_id) : $query;
    }

    public function scopeCampania($query, ?int $campania_id)
    {
        return $campania_id ? $query->where('campania_id', $campania_id) : $query;
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
     * Accessor para producción total (kg).
     */
    public function getProduccionTotalAttribute(): float
    {
        return $this->recolecciones->sum(function ($r) {
            return $r->kilos_primera + $r->kilos_industria;
        });
    }
}
