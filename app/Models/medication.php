<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_record_id',
        'user_id',
        'name',
        'dosage',
        'instructions',
        'administration_date',
    ];

    // Relación con HealthRecord
    public function healthRecord()
    {
        return $this->belongsTo(HealthRecord::class);
    }

    // Relación con el usuario (doctor/enfermero que administra)
    public function administeredBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación indirecta con el residente
    public function resident()
    {
        return $this->hasOneThrough(Resident::class, HealthRecord::class, 'id', 'id', 'health_record_id', 'resident_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nurse()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    // App\Models\Medication.php

    protected $casts = [
        'administration_date' => 'datetime',
    ];



}

