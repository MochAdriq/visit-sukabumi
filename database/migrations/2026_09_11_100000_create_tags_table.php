<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            // 'activity' = menu "Apa yang Bisa Dilakukan"
            // 'wisata'   = menu "Wisata"
            $table->enum('type', ['activity', 'wisata'])->default('activity');
            $table->text('description')->nullable();
            // SVG path string untuk ikon (opsional)
            $table->text('icon_svg')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
