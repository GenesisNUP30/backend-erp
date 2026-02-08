<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoAgua extends Model
{
    use HasFactory;

    protected $table = 'consumo_agua';

    protected $fillable = [
        'cultivo_id',
        'fecha_inicio',
        'fecha_fin',
        'litros_consumidos',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'litros_consumidos' => 'decimal:2',
    ];

    //Relaciones
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }
}
