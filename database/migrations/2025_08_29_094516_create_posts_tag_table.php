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
        Schema::create('posts_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posts_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('tags_id')->constrained('tags')->onDelete('cascade');
            $table->unique(['posts_id', 'tags_id']); // tránh trùng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_tag');
    }
};
