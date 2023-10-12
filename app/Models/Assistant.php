<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;
    protected $table = 'assistants';
    protected $fillable = [
        'name', 
        'assistant_code', 
        'email', 
        'password',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
        'password',
        'remember_token'
    ];
}
