<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaGasto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_gastos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public $timestamps = false;

    //Relaciones
    public function gastos()
    {
        return $this->hasMany(Gasto::class, 'categoria_id');
    }
}
