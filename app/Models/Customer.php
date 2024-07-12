<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email', 
        'password', 
        'first_name', 
        'last_name',
        'middle_name', 
        'company', 
        'position', 
        'profile_picture'
    ];

    protected $guard = 'customer';
}
