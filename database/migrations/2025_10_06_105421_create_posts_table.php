<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // 1. ผู้โพสต์ (Foreign Key เชื่อมกับตาราง users)
            // กำหนดให้ลบโพสต์ทั้งหมดที่ user นี้เคยโพสต์ หาก user ถูกลบออกจากระบบ
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 2. หมวดหมู่ (Foreign Key เชื่อมกับตาราง categories)
            // หากหมวดหมู่ถูกลบ โพสต์ที่อยู่ในหมวดหมู่นั้นจะถูกลบตามไปด้วย
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 3. หัวข้อและรายละเอียด
            $table->string('title');        // หัวข้อ (Header)
            $table->text('body');           // รายละเอียดคำถาม (Question Detail)

            // 4. รูปภาพ (สามารถอัพโหลดได้อย่างน้อย 1 รูป)
            // เก็บเป็น path ของไฟล์รูปภาพ
            $table->string('image_path')->nullable(); // ใช้ nullable() เพื่อให้สามารถโพสต์โดยไม่มีรูปก็ได้

            // 5. วันเวลาโพสต์และอัปเดต (Created_at, Updated_at)
            // Laravel จะจัดการ created_at (วันเวลาโพสต์) และ updated_at ให้เอง
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};