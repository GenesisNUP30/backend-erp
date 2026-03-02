<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variedad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public $timestamps = false;

    //Relaciones
    public function plantaciones()
    {
        return $this->hasMany(Plantacion::class);
    }

    public function preciosSemanales()
    {
        return $this->hasMany(PrecioSemana::class);
    }
}
