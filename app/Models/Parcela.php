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

    public $timestamps = false;

    // Relaciones
    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }
}
