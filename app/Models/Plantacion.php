<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parcela_id',
        'variedad_id',
        'fecha_siembra',
        'numero_plantas',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_siembra' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
        'numero_plantas' => 'integer',
    ];

    // public $timestamps = false;

    // Relaciones
    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }

    public function variedad()
    {
        return $this->belongsTo(Variedad::class);
    }

    public function cosechas()
    {
        return $this->hasMany(Cosecha::class);
    }

    // Scopes para filtros
    public function scopeEstado($query, ?string $estado)
    {
        return $estado ? $query->where('estado', $estado) : $query;
    }

    public function scopeParcela($query, ?int $parcela_id)
    {
        return $parcela_id ? $query->where('parcela_id', $parcela_id) : $query;
    }

    public function scopeVariedad($query, ?int $variedad_id)
    {
        return $variedad_id ? $query->where('variedad_id', $variedad_id) : $query;
    }

    public function scopeFechaSiembra($query, ?string $desde, ?string $hasta)
    {
        if ($desde) {
            $query->whereDate('fecha_siembra', '>=', $desde);
        }
        if ($hasta) {
            $query->whereDate('fecha_siembra', '<=', $hasta);
        }
        return $query;
    }

    /**
     * Accessor para superficie estimada (asumiendo 1.5m² por planta).
     */
    public function getSuperficieEstimadaAttribute(): float
    {
        return round($this->numero_plantas * 1.5 / 10000, 2); // Hectáreas
    }
}
