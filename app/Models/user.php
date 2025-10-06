<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'birthday',
        'phone',
        'avatar',
        'role',
        'gender',
    ];

    protected $hidden = ['password', 'remember_token'];

    // ตั้ง role เป็น member อัตโนมัติเวลาสร้าง
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!isset($user->role)) {
                $user->role = 'member';
            }
        });
    }
}
