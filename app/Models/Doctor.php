<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'practice_license',
        'name',
        'phone_number',
        'address',
        'specialty_id'
    ];

    // Relasi ke table specialties
    public function specialty(): HasOne{
        return $this->hasOne(Specialty::class, 'id','specialty_id');
    }

    
}
