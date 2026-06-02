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
            $table->string('fullname', 100);
            $table->string('username', 30)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->string('phone', 20)->unique();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('gender')->comment('1: Nam, 2: Nữ, 0: Không cung cấp');
            $table->date('birthday')->nullable();
            $table->unsignedTinyInteger('role')->comment('1: quản lý; 2: nhân viên');
            $table->tinyInteger('status')->default(1)->comment('1: kích hoạt; 0: khóa tài khoản');
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
