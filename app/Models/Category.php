<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // อนุญาตให้แก้ไขฟิลด์ 'name' ได้
    protected $fillable = ['name'];

    // ความสัมพันธ์: หนึ่งหมวดหมู่มีได้หลายกระทู้
    public function posts()
    {
        // กำหนดความสัมพันธ์โดยใช้ Foreign Key มาตรฐาน (category_id)
        return $this->hasMany(Post::class);
    }
}
