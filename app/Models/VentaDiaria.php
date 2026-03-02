<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDiaria extends Model
{
    use HasFactory;

    protected $table = 'ventas_diarias';

    protected $fillable = [
        'fecha',
        'cultivo_id',
        'kilos_primera',
        'precio_primera',
        'kilos_industria',
        'precio_industria',
        'importe_total',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'importe_total' => 'decimal:2',
    ];

    public $timestamps = false;

    //Relaciones
    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class);
    }
}
