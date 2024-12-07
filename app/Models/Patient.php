<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_id',
        'name',
        'gender',
        'date_of_birth',
        'phone_number',
        'address'
    ];
}
