<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Support\Str;

class SesiController extends Controller
{
    // Menampilkan Daftar Sesi Ujian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $listSesi = Sesi::with(['guru', 'kelas'])
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('kategori', 'like', "%{$search}%")
                             ->orWhere('sesi', 'like', "%{$search}%");
            })
            ->orderBy('id_sesi', 'asc') // <-- Ubah dari latest() menjadi asc agar berurutan sesuai input
            ->paginate(10)
            ->withQueryString();

        $listKelas = Kelas::with('jurusan')->get();
        $listGuru = Guru::all();

        return view('sesi.managesesi', compact('listSesi', 'listKelas', 'listGuru', 'search'));
    }

    // Menampilkan Form Tambah Sesi
    public function create()
    {
        $listKelas = Kelas::with('jurusan')->get();
        // Generate token acak 5 karakter alfanumerik kapital untuk ujian
        $randomToken = strtoupper(Str::random(5)); 

        return view('guru.sesi.create', compact('listKelas', 'randomToken'));
    }

    // Menyimpan Sesi Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'kategori'        => 'nullable|string|max:100',
            'sesi'            => 'required|string|max:200',
            'tgl_sesi'        => 'required|date',
            'guru_nama_input' => 'required|string|exists:guru,nama', // Pastikan nama guru valid
            'token'           => 'required|string|max:10',
            'waktu_mulai'     => 'required',
            'waktu_selesai'   => 'required',
            'durasi'          => 'required|integer|min:1',
            'kelas_ids'       => 'required|array',
            'kelas_ids.*'     => 'exists:kelas,id_kelas',
        ]);

        // Cari data guru berdasarkan nama yang diketik di input
        $guru = Guru::where('nama', $request->guru_nama_input)->first();

        $sesiUjian = Sesi::create([
            'guru_id'       => $guru->id_guru, // Masukkan id_guru yang ditemukan ke database
            'judul'         => $request->judul,
            'kategori'      => $request->kategori,
            'sesi'          => $request->sesi,
            'tgl_sesi'      => $request->tgl_sesi,
            'token'         => $request->token,
            'waktu_mulai'   => $request->waktu_mulai,   
            'waktu_selesai' => $request->waktu_selesai, 
            'durasi'        => $request->durasi,
        ]);

        // Simpan relasi ke tabel pivot sesi_kelas
        $sesiUjian->kelas()->attach($request->kelas_ids);

        return redirect()->route('sesi.managesesi')->with('success', 'Sesi ujian berhasil dibuat!');
    }

    // Menampilkan Form Edit Sesi
    public function edit($id)
    {
        $sesi = Sesi::with('kelas', 'guru')->findOrFail($id);
        $guruList = Guru::all();
        $kelasList = Kelas::all();

        return view('sesi.editsesi', compact('sesi', 'guruList', 'kelasList'));
    }

    // Memperbarui Data Sesi di Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'kategori'      => 'required|string|max:255',
            'sesi'          => 'required|string|max:255',
            'tgl_sesi'      => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'durasi'        => 'required|integer',
            'token'         => 'required|string|max:10',
            'guru_id'       => 'required|exists:guru,id_guru',
            'kelas_id'      => 'required|array', // Mendukung relasi banyak kelas
        ]);

        $sesi = Sesi::findOrFail($id);
        
        $sesi->update([
            'judul'         => $request->judul,
            'kategori'      => $request->kategori,
            'sesi'          => $request->sesi,
            'tgl_sesi'      => $request->tgl_sesi,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi'        => $request->durasi,
            'token'         => strtoupper($request->token),
            'guru_id'       => $request->guru_id,
        ]);

        // Sinkronisasi kelas pada tabel pivot sesi_kelas
        $sesi->kelas()->sync($request->kelas_id);

        return redirect()->route('sesi.managesesi')->with('success', 'Sesi ujian berhasil diperbarui!');
    }

    // Menghapus Sesi
    public function destroy($id)
    {
        $sesi = Sesi::findOrFail($id);

        // 1. Hapus relasi pivot dengan kelas
        $sesi->kelas()->detach(); 

        // 2. Hapus data nilai siswa yang terkait sesi ini
        \App\Models\Nilai::where('sesi_id', $id)->delete();

        // 3. Hapus data jawaban siswa (melalui relasi soal atau langsung berdasarkan sesi)
        $soalIds = \App\Models\Soal::where('sesi_id', $id)->pluck('id_soal');
        \App\Models\Jawaban::whereIn('soal_id', $soalIds)->delete();

        // 4. Hapus opsi soal & soal terkait sesi ini
        foreach (\App\Models\Soal::where('sesi_id', $id)->get() as $soal) {
            $soal->opsi()->delete(); // Hapus opsi pilihan ganda
            $soal->delete();        // Hapus soalnya
        }

        // 5. Terakhir, hapus sesi utamanya
        $sesi->delete();

        return back()->with('success', 'Sesi ujian beserta seluruh soal dan data terkait berhasil dihapus!');
    }
}