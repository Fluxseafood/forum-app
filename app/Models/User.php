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
        // นำ 'role' ออกจาก $fillable เพื่อป้องกันผู้ใช้กำหนด Role เอง
        // 'role', 
        'gender',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'birthday' => 'datetime',
    ];

    /**
     * ตั้งค่าเริ่มต้น (Default Role) สำหรับผู้ใช้ใหม่ทุกคน
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // บังคับตั้งค่า Role เป็น 'member' เสมอ
            // ไม่ต้องมีเงื่อนไข if (!isset($user->role))
            $user->role = 'member';
        });
    }

    public function posts()
    {
    	return $this->hasMany(Post::class);
    }

    public function comments()
    {	
    	return $this->hasMany(Comment::class);
    }

    public function getNameAttribute()
    {
    // คืนชื่อเต็ม (first_name + last_name)
    return "{$this->first_name} {$this->last_name}";
    }

}
