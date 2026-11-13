<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Menambahkan kolom guru_id sebagai foreign key yang merujuk ke tabel guru (id_guru)
            // Diletakkan setelah id_kelas agar sesuai dengan ERD
            $table->unsignedBigInteger('guru_id')->nullable()->after('id_kelas');
            
            $table->foreign('guru_id')
                  ->references('id_guru')
                  ->on('guru')
                  ->onDelete('set null'); // Jika guru dihapus, wali kelas diset null
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};