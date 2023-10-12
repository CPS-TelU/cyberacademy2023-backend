<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assistant extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $table = 'assistants';
     protected $fillable = [
       'name',
       'assistant_code',
       'email',
       'password',
   ];
   protected $hidden = [
       'password',
       'remember_token',
       'created_at',
       'updated_at',
   ];
   protected $casts = [
       'email_verified_at' => 'datetime',
       'password' => 'hashed',
   ];
}

