<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'customer_id', 
        'user_id', 
        'ticket_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments () {
        return $this->hasMany(Attachment::class, 'comment_id', 'id');
    }
}
