<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'medical_history',
        'allergies',
        'mood',
        'contact_user_id'
    ];

    // Relación: residente tiene un usuario como contacto principal
    public function contactUser()
    {
        return $this->belongsTo(User::class, 'contact_user_id');
    }

    // Relación: residente tiene muchos registros médicos
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    // Relación: residente tiene muchos medicamentos
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    // Relación: residente tiene muchas actividades
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    // Relación: residente tiene muchas visitas
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
