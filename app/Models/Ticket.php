<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'department_id',
        'employee_id',
        'priority_id',
        'title',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function employee () 
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function customer () 
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user () 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function priority () 
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'ticket_id', 'id');
    }
    
    public function attachments () {
        return $this->hasMany(Attachment::class, 'ticket_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id')->orderBy('updated_at', 'desc');
    }

    

}
