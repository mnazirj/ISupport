<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file',
        'priority',
        'status',
        'assigned_user_id',
        'userId'
    ];
    public function User()
    {
        return $this->belongsTo(User::class,'userId');
    }
    public function Assigned()
    {
        return $this->belongsTo(User::class,'assigned_user_id');
    }
    public function Category()
    {
        return $this->belongsToMany(Category::class,'category_tickets','ticketId','categoryId');
    }
    public function Label()
    {
        return $this->belongsToMany(Label::class,'label_tickets','ticketId','labelId');
    }
    public function Comments()
    {
        return $this->hasMany(Comment::class,'ticketId')->orderBy('id','desc');
    }
    public function Logs()
    {
        return $this->hasMany(UserLog::class,'ticketId');
    }

}
