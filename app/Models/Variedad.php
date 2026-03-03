<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variedad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
    ];

    // public $timestamps = false;

    protected $casts = [
        'tipo' => 'string',
    ];

    //Relaciones
    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }

    public function preciosSemanales()
    {
        return $this->hasMany(PrecioSemana::class);
    }

    // Scopes para filtros
    public function scopeTipo($query, ?string $tipo)
    {
        return $tipo ? $query->where('tipo', $tipo) : $query;
    }

    /**
     * Accessor para nombre completo (con tipo).
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} ({$this->tipo})";
    }
}
