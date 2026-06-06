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

            $table->increments('id');

            $table->string('title', 200);

            $table->string('slug', 255)->unique();

            $table->text('content');

            $table->string('image', 200)->nullable();

            $table->tinyInteger('status')->default(1);

            $table->unsignedInteger('user_id');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete(); // Không cho phép xóa User khi còn bài viết
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