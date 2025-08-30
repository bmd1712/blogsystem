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
       Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('posts_id')->constrained('posts')->onDelete('cascade');
            $table->boolean('isRead')->default(false);
            $table->timestamp('created')->useCurrent();
            $table->unique(['user_id', 'posts_id']); // mỗi user chỉ tính 1 view duy nhất
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
