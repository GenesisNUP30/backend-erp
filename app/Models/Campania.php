<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Campania extends Model
{
    use HasFactory;

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

    public function scopeOrdernarPorFechaInicio($query)
    {
        return $query->orderBy('fecha_inicio', 'asc');
    }

    // Relaciones
    // public function cultivos()
    // {
    //     return $this->hasMany(Cultivo::class);
    // }
}
