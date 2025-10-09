<?php

namespace App\Models; // 1. Namespace อยู่ด้านบนสุด

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 2. โครงสร้างคลาสเริ่มต้นที่นี่
class Comment extends Model
{
    use HasFactory;

    // 3. Property ที่เป็น public ต้องอยู่ภายในคลาสเท่านั้น
    protected $fillable = [
        'post_id', 
        'user_id', 
        'body', 
        'image_path',
    ];
    
    // 4. เมธอดที่เป็น public ต้องอยู่ภายในคลาสเท่านั้น
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
} // 5. ปีกกาปิดของคลาส