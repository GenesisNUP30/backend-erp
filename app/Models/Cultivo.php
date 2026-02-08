<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use  HasFactory;

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
        'fecha_siembra' => 'date',
        'fecha_fin' => 'date',
    ];

    //Relaciones
    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }

    public function variedad()
    {
        return $this->belongsTo(Variedad::class);
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class);
    }

    public function recolecciones()
    {
        return $this->hasMany(Recoleccion::class);
    }

    public function ventasDiarias()
    {
        return $this->hasMany(VentaDiaria::class);
    }
    
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    public function consumoAgua()
    {
        return $this->hasMany(ConsumoAgua::class);
    }

    
}
