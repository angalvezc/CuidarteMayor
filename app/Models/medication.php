<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'name',
        'dosage',
        'frequency',
        'responsible_id'
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }
}
