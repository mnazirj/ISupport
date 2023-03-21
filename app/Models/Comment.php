<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticketId',
        'userId',
        'comment',
    ];

    public function Ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function User()
    {
        return $this->hasOne(User::class,'id','userId');
    }
}
