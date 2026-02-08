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

    //Relaciones
    public function cultivos()
    {
        return $this->hasMany(Cultivo::class);
    }

    public function preciosSemanales()
    {
        return $this->hasMany(PrecioSemana::class);
    }
}
