<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $fillable =[
        'userId',
        'Action',
        'ticketId',
    ];
    public function Ticket()
    {
        return $this->belongsTo(Ticket::class,'ticketId');
    }
    public function User()
    {
        return $this->hasOne(User::class,'id','userId');
    }
}
