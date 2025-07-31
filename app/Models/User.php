<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'rol' => 'string',
    ];

    // Relación: Un usuario puede crear múltiples actas
    public function actasCreadas()
    {
        return $this->hasMany(Acta::class, 'usuario_id');
    }

    // Verificar si el usuario es administrador
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    // Verificar si el usuario es consultor
    public function isConsultor()
    {
        return $this->rol === 'consultor';
    }
}
