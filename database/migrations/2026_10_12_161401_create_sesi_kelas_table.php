<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_kelas', function (Blueprint $table) {
            $table->foreignId('sesi_id')->constrained('sesi', 'id_sesi')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas', 'id_kelas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_kelas');
    }
};