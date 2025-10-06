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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('password');
                $table->date('birthday');
                $table->string('phone')->nullable();
                $table->string('avatar')->nullable();
                $table->enum('role', ['admin', 'member'])->default('member');
                $table->enum('gender', ['male', 'female','unspecified','other'])->default('unspecified');
                $table->timestamps();
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
