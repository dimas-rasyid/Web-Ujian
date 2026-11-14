<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanKelasController;
use App\Http\Controllers\GuruManageController;
use App\Http\Controllers\SiswaManageController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MapelController;

// Halaman Utama langsung diarahkan ke Login Siswa
Route::get('/', function () {
    return redirect()->route('login.siswa');
});

// Login Guru
Route::get('/login-guru', [AuthController::class, 'showLoginGuru'])->name('login.guru');
Route::post('/login-guru', [AuthController::class, 'loginGuru']);

// Login Siswa
Route::get('/login', [AuthController::class, 'showLoginSiswa'])->name('login.siswa');
Route::post('/login', [AuthController::class, 'loginSiswa']);

// Logout Guru & Siswa
Route::post('/logout-guru', [AuthController::class, 'logoutGuru'])->name('logout.guru');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Siswa & Panel Siswa
Route::middleware(['auth.siswa'])->group(function () {
    //Dashboard Siswa
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    
    // Ujian Siswa
    Route::get('/siswa/sesi/{id_sesi}', [UjianController::class, 'kerjakan'])->name('siswa.sesi.kerjakan');
    Route::post('/siswa/sesi/{id_sesi}/token', [UjianController::class, 'validasiToken'])->name('siswa.sesi.token');

    // Auto Save
    Route::post('/siswa/sesi/{id_sesi}/autosave', [UjianController::class, 'autosave'])->name('siswa.sesi.autosave');

    Route::post('/siswa/sesi/{id_sesi}/selesai', [UjianController::class, 'selesai'])->name('siswa.sesi.selesai');

    Route::post('/siswa/sesi/{id_sesi}/pelanggaran', [UjianController::class, 'pelanggaran'])
    ->name('siswa.sesi.pelanggaran')
    ->middleware('throttle:60,1');
});

// Dashboard & Panel Guru
Route::middleware(['auth.guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');

    // Manage Kelas dan Guru
    Route::get('/guru/jurusan-kelas', [JurusanKelasController::class, 'index'])->name('guru.jurusan-kelas.index');
    Route::post('/guru/jurusan', [JurusanKelasController::class, 'storeJurusan'])->name('guru.jurusan.store');
    Route::delete('/guru/jurusan/{id}', [JurusanKelasController::class, 'destroyJurusan'])->name('guru.jurusan.destroy');
    //----------------------------
    Route::post('/guru/kelas', [JurusanKelasController::class, 'storeKelas'])->name('guru.kelas.store');
    Route::delete('/guru/kelas/{id}', [JurusanKelasController::class, 'destroyKelas'])->name('guru.kelas.destroy');
    // Route untuk Manajemen Mata Pelajaran
    Route::get('/guru/mapel', [MapelController::class, 'index'])->name('guru.mapel.index');
    Route::post('/guru/mapel', [MapelController::class, 'store'])->name('guru.mapel.store');
    Route::delete('/guru/mapel/{id}', [MapelController::class, 'destroy'])->name('guru.mapel.destroy');
    Route::post('/guru/mapel/import', [MapelController::class, 'import'])->name('guru.mapel.import');
    

    // Rute Rekap Nilai dan Koreksi
    Route::get('/guru/sesi/{id_sesi}/nilai', [NilaiController::class, 'daftarNilaiSesi'])->name('guru.sesi.nilai');
    Route::get('/guru/sesi/{id_sesi}/koreksi/{id_siswa}', [NilaiController::class, 'koreksi'])->name('guru.sesi.koreksi');
    Route::post('/guru/sesi/{id_sesi}/koreksi/{id_siswa}', [NilaiController::class, 'simpanKoreksi'])->name('guru.sesi.koreksi.simpan');
    // reset siswa
    Route::patch('/guru/sesi/{id_sesi}/nilai/{siswa_id}/reset', [NilaiController::class, 'reset'])->name('guru.sesi.reset-status');

    // Manage Guru
    Route::get('/guru/manage', [GuruManageController::class, 'index'])->name('guru.manageguru');
    Route::post('/guru/manage', [GuruManageController::class, 'store'])->name('guru.manage.store');
    Route::post('/guru/import', [GuruManageController::class, 'import'])->name('guru.manage.import');
    Route::delete('/guru/manage/{id}', [GuruManageController::class, 'destroy'])->name('guru.manage.destroy');

    //Manage Siswa
    Route::get('/guru/siswa', [SiswaManageController::class, 'index'])->name('guru.managesiswa');
    Route::post('/guru/siswa', [SiswaManageController::class, 'store'])->name('guru.siswa.store');
    Route::post('/guru/siswa/import', [SiswaManageController::class, 'import'])->name('guru.siswa.import');
    Route::delete('/guru/siswa/{id}', [SiswaManageController::class, 'destroy'])->name('guru.siswa.destroy');


    // Manage Sesi
    Route::get('/guru/sesi', [SesiController::class, 'index'])->name('sesi.managesesi');
    Route::post('/guru/sesi', [SesiController::class, 'store'])->name('guru.sesi.store');
    // Rute Edit Sesi Ujian
    Route::get('/guru/sesi/{id}/edit', [SesiController::class, 'edit'])->name('guru.sesi.edit');
    Route::put('/guru/sesi/{id}/update', [SesiController::class, 'update'])->name('guru.sesi.update');
    // delete
    Route::delete('/guru/sesi/{id}', [SesiController::class, 'destroy'])->name('sesi.destroy');
    // Salin soal dari sesi lain (Bank Soal)
    Route::post('/guru/soal/{id_sesi_tujuan}/salin/{id_sesi_sumber}', [SoalController::class, 'salinDariBank'])
        ->name('guru.soal.salin');

    // Mnaage SOAL
    Route::get('/guru/soal', [SoalController::class, 'index'])->name('guru.soal.index');
    Route::get('/guru/soal/{id_control}', [SoalController::class, 'detail'])->name('guru.soal.detail');
    Route::get('/guru/soal/{id_control}', [SoalController::class, 'kelolaSoal'])->name('guru.soal.kelola');
    // Tambah SOAL
    Route::get('/guru/soal', [SoalController::class, 'index'])->name('guru.soal.index');
    Route::get('/guru/soal/{id_sesi}/tambah', [SoalController::class, 'detail'])->name('guru.soal.detail');
    Route::post('/guru/soal/{id_control}/store', [SoalController::class, 'store'])->name('guru.soal.store');
    Route::post('/guru/soal/{id_control}/import', [SoalController::class, 'import'])->name('guru.soal.import');
    Route::delete('/guru/soal/item/{id_soal}', [SoalController::class, 'destroy'])->name('guru.soal.destroy');
    Route::delete('/guru/soal/destroy-all/{id}', [SoalController::class, 'destroyAll'])->name('guru.soal.destroyAll');
    
    // Export laporan nilai
    Route::get('/guru/sesi/{id_sesi}/laporan/pdf',[LaporanController::class, 'exportPdf'])->name('guru.laporan.pdf');
    Route::get('/guru/sesi/{id_sesi}/laporan/excel',[LaporanController::class, 'exportExcel'])->name('guru.laporan.excel');

});
