<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'telefono',
        'rol',
        'fecha_alta',
        'fecha_baja',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_alta' => 'date',
            'fecha_baja' => 'date',
        ];
    }

    //Relaciones
    public function recolecciones()
    {
        return $this->hasMany(Recoleccion::class);
    }

    public function gastosRegistrados()
    {
        return $this->hasMany(Gasto::class, 'user_id');
    }

    // Roles diferentes
    public function isAdmin()
    {
        return $this->rol === 'administrador';
    }

    public function isEncargado()
    {
        return $this->rol === 'encargado';
    }

    public function isRecolector()
    {
        return $this->rol === 'recolector';
    }    
}
