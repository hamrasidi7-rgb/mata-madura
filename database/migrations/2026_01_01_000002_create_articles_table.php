<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('deck')->nullable();          // ringkasan / lead 2 baris
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_caption')->nullable();
            $table->string('author')->nullable();
            $table->unsignedSmallInteger('read_minutes')->default(3);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_featured')->default(false); // sorotan utama
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
