<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'action',
        'description', 
        'status_id', 
        'priority_id',
        'user_id',
    ];


    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

}
