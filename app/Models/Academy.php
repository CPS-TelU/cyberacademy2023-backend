<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;
    protected $table = 'academies';
    protected $fillable = [
        'name', 
        'nim', 
        'email', 
        'phone_number', 
        'document', 'gender', 
        'year_of_enrollment', 
        'faculty', 
        'major', 
        'class'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
