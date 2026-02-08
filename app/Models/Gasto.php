<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'cultivo_id',
        'user_id',
        'fecha',
        'concepto',
        'importe',
        'tipo_tiempo',
        'horas_estimadas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'importe' => 'decimal:2',
        'horas_estimadas' => 'decimal:2',
    ];

    //Relaciones
    public function categoria()
    {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_id');
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
