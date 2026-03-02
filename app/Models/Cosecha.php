<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    use HasFactory;

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
    ];

    public $timestamps = false;

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
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopePlantacion($query, $plantacion_id)
    {
        if ($plantacion_id) {
            return $query->where('plantacion_id', $plantacion_id);
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
}
