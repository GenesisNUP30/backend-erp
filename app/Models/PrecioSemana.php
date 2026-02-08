<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioSemana extends Model
{
    use HasFactory;

    protected $table = 'precios_semanales';

    protected $fillable = [
        'variedad_id',
        'semana_inicio',
        'semana_fin',
        'precio_primera',
        'precio_industria',
    ];

    protected $casts = [
        'semana_inicio' => 'date',
        'semana_fin' => 'date',
    ];

    //Relaciones
    public function variedad()
    {
        return $this->belongsTo(Variedad::class);
    }
}
