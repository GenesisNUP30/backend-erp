<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recoleccion extends Model
{
    use HasFactory, SoftDeletes;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'cosecha_id',
        'user_id',
        'fecha',
        'kilos_primera',
        'kilos_industria',
        'observaciones',
    ];

    // Conversión automática de tipos de datos 
    protected $casts = [
        'fecha' => 'date',  // Convierte automáticamente a objeto Carbon/Date
    ];

    public $timestamps = false;

    /**
     * Relación: Una recolección pertenece a un cultivo
     * Permite acceder al cultivo asociado: $recoleccion->cultivo
     */
    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }

    /**
     * Relación: Una recolección pertenece a un usuario (recolector)
     * El segundo parámetro especifica la clave foránea personalizada
     */
    public function recolector()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function scopeRecolector($query, $user_id)
    {
        if ($user_id) {
            return $query->where('user_id', $user_id);
        }
        return $query;
    }
}
