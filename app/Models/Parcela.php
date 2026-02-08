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
        'superficie_hectareas' => 'decimal:8',
    ];

    // Relaciones
    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }
}
