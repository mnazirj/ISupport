<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function Role()
    {
        return $this->hasOne(Role::class,'id','role');
    }
    public function Tickets()
    {
        return $this->hasMany(Ticket::class,'userId','id');
    }
    public function Logs()
    {
        return $this->hasMany(UserLog::class,'userId');
    }

}
