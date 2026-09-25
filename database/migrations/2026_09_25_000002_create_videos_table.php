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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('youtube_url');
            $table->string('youtube_id', 32)->nullable();
            $table->string('category', 64)->default('Wisata Alam');
            $table->text('description')->nullable();
            $table->string('duration', 32)->nullable();
            $table->boolean('is_featured')->default(false); // Muncul di section Beranda
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
