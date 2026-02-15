<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recoleccion extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'cultivo_id',
        'user_id',
        'fecha',
        'kilos_primera',
        'kilos_industria',
        'observaciones',
    ];

    // Conversión automática de tipos de datos 
    protected $casts = [
        'fecha' => 'date',  // Convierte automáticamente a objeto Carbon/Date
    ];

    /**
     * Relación: Una recolección pertenece a un cultivo
     * Permite acceder al cultivo asociado: $recoleccion->cultivo
     */
    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class);
    }

     /**
     * Relación: Una recolección pertenece a un usuario (recolector)
     * El segundo parámetro especifica la clave foránea personalizada
     */
    public function recolector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
