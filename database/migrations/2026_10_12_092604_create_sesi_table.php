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
        Schema::create('sesi', function (Blueprint $table) {
            $table->id('id_sesi');
            $table->foreignId('guru_id')->constrained('guru', 'id_guru')->onDelete('cascade');
            $table->string('judul');
            $table->string('kategori');
            $table->string('token');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->integer('durasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi');
    }
};
