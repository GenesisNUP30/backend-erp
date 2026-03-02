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
}
