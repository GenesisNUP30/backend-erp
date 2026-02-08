<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGasto extends Model
{
    use HasFactory;

    protected $table = 'categorias_gastos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    //Relaciones
    public function gastos()
    {
        return $this->hasMany(Gasto::class, 'categoria_id');
    }
}
