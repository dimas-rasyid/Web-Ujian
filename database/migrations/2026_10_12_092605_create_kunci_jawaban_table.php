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
        Schema::create('kunci_jawaban', function (Blueprint $table) {
            $table->id('id_kunci');
            $table->foreignId('soal_id')->constrained('soal', 'id_soal')->onDelete('cascade');
            $table->string('option_code'); // A, B, C, D, E
            $table->text('option_text');
            $table->boolean('correct')->default(false); // true jika kunci jawaban
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunci_jawaban');
    }
};
