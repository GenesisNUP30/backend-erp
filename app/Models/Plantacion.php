<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcela_id',
        'variedad_id',
        'campania_id',
        'fecha_siembra',
        'numero_plantas',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_siembra' => 'date:Y-m-d',
        'fecha_fin' => 'date:Y-m-d',
    ];

    public $timestamps = false;

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
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopeParcela($query, $parcela_id)
    {
        if ($parcela_id) {
            return $query->where('parcela_id', $parcela_id);
        }
        return $query;
    }

    public function scopeVariedad($query, $variedad_id)
    {
        if ($variedad_id) {
            return $query->where('variedad_id', $variedad_id);
        }
        return $query;
    }

    public function scopeCampania($query, $campania_id)
    {
        if ($campania_id) {
            return $query->where('campania_id', $campania_id);
        }
        return $query;
    }

    public function scopeFechaSiembraDesde($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha_siembra', '>=', $fecha);
        }
        return $query;
    }

    public function scopeFechaSiembraHasta($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha_siembra', '<=', $fecha);
        }
        return $query;
    }
}
