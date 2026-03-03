<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaDiaria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ventas_diarias';

    protected $fillable = [
        'fecha',
        'cultivo_id',
        'kilos_primera',
        'precio_primera',
        'kilos_industria',
        'precio_industria',
        'importe_total',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'importe_total' => 'decimal:2',
    ];

    public $timestamps = false;

    //Relaciones
    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }

    // Scopes para filtros
    public function scopeFecha($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha', $fecha);
        }
        return $query;
    }

    public function scopeFechaDesde($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha', '>=', $fecha);
        }
        return $query;
    }

    public function scopeFechaHasta($query, $fecha)
    {
        if ($fecha) {
            return $query->whereDate('fecha', '<=', $fecha);
        }
        return $query;
    }

    public function scopeCosecha($query, $cosecha_id)
    {
        if ($cosecha_id) {
            return $query->where('cosecha_id', $cosecha_id);
        }
        return $query;
    }
}
