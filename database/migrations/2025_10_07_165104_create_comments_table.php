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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // 1. กระทู้ที่ตอบ (Foreign Key เชื่อมกับตาราง posts)
            // หากกระทู้หลักถูกลบ คอมเมนต์ทั้งหมดที่เกี่ยวข้องจะถูกลบตามไปด้วย
            $table->foreignId('post_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 2. ผู้ตอบ (Foreign Key เชื่อมกับตาราง users)
            // หาก user ถูกลบ คอมเมนต์ที่ user นี้เคยโพสต์จะถูกลบตามไปด้วย
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 3. รายละเอียดคำตอบ
            $table->text('body');           // รายละเอียดคำตอบ (Answer Detail)

            // 4. รูปภาพ (สามารถอัพโหลดได้อย่างน้อย 1 รูป)
            // เก็บเป็น path ของไฟล์รูปภาพ
            $table->string('image_path')->nullable(); // ใช้ nullable() เพื่อให้สามารถคอมเมนต์โดยไม่มีรูปก็ได้

            // 5. วันเวลาโพสต์และอัปเดต
            // Laravel จะจัดการ created_at (วันเวลา) และ updated_at ให้เอง
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};