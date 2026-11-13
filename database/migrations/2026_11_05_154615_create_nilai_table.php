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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('control_id')->constrained('control', 'id_control')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->double('skor')->default(0);
            $table->double('skor_up')->default(0);
            $table->string('status')->default('belum_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
