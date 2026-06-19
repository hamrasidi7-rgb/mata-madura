<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->enum('color', ['green', 'yellow', 'blue', 'red'])->default('green');
            $table->unsignedInteger('similar_count')->default(0);
            $table->timestamp('submitted_at')->useCurrent();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
