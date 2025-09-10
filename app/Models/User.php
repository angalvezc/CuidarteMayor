<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación: un usuario pertenece a un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación: un familiar puede ser contacto de muchos residentes
    public function residentsAsContact()
    {
        return $this->hasMany(Resident::class, 'contact_user_id');
    }

    // Relación: un usuario (doctor) tiene muchos registros médicos
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class, 'doctor_id');
    }

    // Relación: un usuario puede ser responsable de medicamentos
    public function medications()
    {
        return $this->hasMany(Medication::class, 'responsiblemed_id');
    }

    // Relación: un usuario puede ser responsable de actividades
    public function activities()
    {
        return $this->hasMany(Activity::class, 'responsible_id');
    }

    // Relación: un usuario puede registrar visitas
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Asignar rol por defecto al crear un usuario (Familiar = 2).
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role_id)) {
                $user->role_id = 2; // Por defecto, Familiar
            }
        });
    }
}
