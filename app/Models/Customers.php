<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 
        'password', 
        'first_name', 
        'last_name', 
        'company', 
        'position', 
        'profile_picture'
    ];
}
