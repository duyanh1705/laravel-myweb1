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
            // id: INT, AUTO_INCREMENT, PRIMARY KEY
            // (Sử dụng id() để tạo khóa chính tự tăng đồng bộ với bigint của khóa ngoại Laravel)
            $table->id(); 

            // title: VARCHAR(200) - Tiêu đề bài viết
            $table->string('title', 200);

            // slug: VARCHAR(255), UNIQUE
            $table->string('slug', 255)->unique();

            // content: text - Nội dung bài viết
            $table->text('content');

            // image: VARCHAR(200) - Hình ảnh đại diện (thêm nullable đề phòng bài viết không có ảnh)
            $table->string('image', 200)->nullable();

            // status: tinyInteger, default(1) - 1: hiển thị; 0: ẩn
            $table->tinyInteger('status')->default(1)->comment('1: hiển thị; 0: ẩn');

            // user_id: bigint - Khóa ngoại tham chiếu bảng users
            // Ràng buộc "Không cho phép xóa User khi vẫn còn bài viết" -> restrictOnDelete()
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // created_at, updated_at: TIMESTAMP
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