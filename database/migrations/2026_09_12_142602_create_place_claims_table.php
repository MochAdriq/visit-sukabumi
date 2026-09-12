<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->string('ktp_path');                  // path file KTP (Storage)
            $table->string('surat_path');                // path surat pengelola (Storage)
            $table->string('applicant_phone', 20);       // WA aktif pemohon
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();      // catatan penolakan dari admin
            $table->timestamp('reviewed_at')->nullable(); // kapan admin merespons
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_claims');
    }
};
