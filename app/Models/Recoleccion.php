<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recoleccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'cultivo_id',
        'user_id',
        'fecha',
        'kilos_primera',
        'kilos_industria',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    //Relaciones
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function recolector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
