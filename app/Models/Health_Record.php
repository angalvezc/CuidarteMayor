<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Health_Record extends Model
{
    use HasFactory;
    public function administrations()
    {
        return $this->hasMany(Medication::class);
    }
    public function medications()
    {
        return $this->hasMany(\App\Models\Medication::class);
    }

}

