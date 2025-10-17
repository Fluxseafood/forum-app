<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // กำหนดฟิลด์ที่อนุญาตให้ Mass Assignment ได้
    protected $fillable = [
        'user_id', 
        'category_id', 
        'title', 
        'body', 
        'image_path'
    ];

    // ความสัมพันธ์: หลายกระทู้มีหนึ่งหมวดหมู่ (แก้ไขให้ถูก)
    public function category()
    {
        // กำหนดความสัมพันธ์โดยใช้ Foreign Key มาตรฐาน (category_id)
        return $this->belongsTo(Category::class);
    }
    
    // ความสัมพันธ์อื่นๆ (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ความสัมพันธ์อื่นๆ (Comments)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
