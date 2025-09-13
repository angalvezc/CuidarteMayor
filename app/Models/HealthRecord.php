<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'doctor_id',
        'diagnosis',
        'treatment',
        'record_date'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
