<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\Control;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel; 
use Illuminate\Support\Str;

class SesiController extends Controller
{
    // Menampilkan Daftar Sesi Ujian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $listSesi = Sesi::with(['guru', 'mapel', 'kelas'])
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('sesi', 'like', "%{$search}%")
                             ->orWhereHas('mapel', function ($q) use ($search) {
                                 $q->where('mapel', 'like', "%{$search}%");
                             });
            })
            ->orderBy('id_sesi', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Data yang dibutuhkan untuk form / modal sesi ujian
        $listKelas    = Kelas::with('jurusan')->get();
        $listGuru     = Guru::all();
        $listMapel    = Mapel::all();
        $listBankSesi = Sesi::select('judul')->distinct()->get();
        $randomToken  = strtoupper(\Illuminate\Support\Str::random(5));

        return view('sesi.managesesi', compact(
            'listSesi', 
            'listKelas', 
            'listGuru', 
            'listMapel', 
            'search', 
            'listBankSesi', 
            'randomToken'
        ));
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
            'judul'         => 'required|string|max:255',
            'sesi'          => 'required|string',
            'tgl_sesi'      => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'durasi'        => 'required|integer|min:1',
            'token'         => 'required|string|max:10',
            'guru_id'       => 'required|exists:guru,id_guru',
            'mapel_ids'     => 'required|array|min:1',
            'mapel_ids.*'   => 'exists:mapel,id_mapel',
            'kelas_ids'     => 'required|array|min:1',
            'kelas_ids.*'   => 'exists:kelas,id_kelas',
        ]);

        // 1. Gabungkan tanggal dan waktu
        $waktuMulaiFull   = $request->tgl_sesi . ' ' . $request->waktu_mulai . ':00';
        $waktuSelesaiFull = $request->tgl_sesi . ' ' . $request->waktu_selesai . ':00';

        // 2. Buat data Sesi Utama
        $sesiUjian = Sesi::create([
            'judul'         => $request->judul,
            'sesi'          => $request->sesi,
            'waktu_mulai'   => $waktuMulaiFull,
            'waktu_selesai' => $waktuSelesaiFull,
            'durasi'        => $request->durasi,
            'token'         => strtoupper($request->token),
            'guru_id'       => $request->guru_id,
        ]);

        // 3. Simpan relasi ke tabel control secara paralel (1-to-1 index)
        $mapelIds = $request->mapel_ids;
        $kelasIds = $request->kelas_ids;
        
        $maxCount = max(count($mapelIds), count($kelasIds));

        for ($i = 0; $i < $maxCount; $i++) {
            Control::firstOrCreate([
                'sesi_id'  => $sesiUjian->id_sesi,
                'mapel_id' => $mapelIds[$i] ?? $mapelIds[0], // Ambil mapel sesuai indeks ke-i
                'kelas_id' => $kelasIds[$i] ?? $kelasIds[0], // Ambil kelas sesuai indeks ke-i
            ]);
        }

        return redirect()->back()->with('success', 'Sesi ujian berhasil dibuat!');
    }

    // Menampilkan Halaman / Form Edit Sesi
    public function edit($id)
    {
        $sesi = Sesi::with(['kelas', 'mapel'])->findOrFail($id);
        
        $listGuru  = \App\Models\Guru::all();
        $listKelas = \App\Models\Kelas::with('jurusan')->get();
        $listMapel = \App\Models\Mapel::all();

        return view('sesi.editsesi', compact('sesi', 'listGuru', 'listKelas', 'listMapel'));
    }

    // Memperbarui Data Sesi di Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'sesi'          => 'required|string',
            'tgl_sesi'      => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'durasi'        => 'required|integer|min:1',
            'token'         => 'required|string|max:10',
            'guru_id'       => 'required|exists:guru,id_guru',
            'mapel_ids'     => 'required|array|min:1',
            'mapel_ids.*'   => 'exists:mapel,id_mapel',
            'kelas_ids'     => 'required|array|min:1',
            'kelas_ids.*'   => 'exists:kelas,id_kelas',
        ]);

        $sesi = Sesi::findOrFail($id);

        // Gabungkan tanggal dan waktu
        $waktuMulaiFull   = $request->tgl_sesi . ' ' . $request->waktu_mulai . ':00';
        $waktuSelesaiFull = $request->tgl_sesi . ' ' . $request->waktu_selesai . ':00';

        // 1. Update data utama sesi
        $sesi->update([
            'judul'         => $request->judul,
            'sesi'          => $request->sesi,
            'waktu_mulai'   => $waktuMulaiFull,
            'waktu_selesai' => $waktuSelesaiFull,
            'durasi'        => $request->durasi,
            'token'         => strtoupper($request->token),
            'guru_id'       => $request->guru_id,
        ]);

        // 2. Sinkron ulang relasi pada tabel control (hapus yang lama, masukkan yang baru sesuai pilihan edit)
        \App\Models\Control::where('sesi_id', $sesi->id_sesi)->delete();

        $mapelIds = $request->mapel_ids;
        $kelasIds = $request->kelas_ids;
        $maxCount = max(count($mapelIds), count($kelasIds));

        for ($i = 0; $i < $maxCount; $i++) {
            \App\Models\Control::create([
                'sesi_id'  => $sesi->id_sesi,
                'mapel_id' => $mapelIds[$i] ?? $mapelIds[0],
                'kelas_id' => $kelasIds[$i] ?? $kelasIds[0],
            ]);
        }

        return redirect()->route('sesi.managesesi')->with('success', 'Sesi ujian berhasil diperbarui!');
    }

    // Menghapus Sesi
    public function destroy($id)
    {
        $sesi = Sesi::findOrFail($id);

        // 1. Ambil semua control_id yang berelasi dengan sesi ini
        $controlIds = \App\Models\Control::where('sesi_id', $id)->pluck('id_control');

        // 2. Hapus data nilai siswa berdasarkan control_id (sesuai ERD)
        \App\Models\Nilai::whereIn('control_id', $controlIds)->delete();

        // 3. Ambil semua id_soal yang terikat pada control_id tersebut
        $soalIds = \App\Models\Soal::whereIn('control_id', $controlIds)->pluck('id_soal');

        // 4. Hapus jawaban siswa berdasarkan soal_id
        \App\Models\Jawaban::whereIn('soal_id', $soalIds)->delete();

        // 5. Hapus opsi soal dan soalnya
        foreach (\App\Models\Soal::whereIn('control_id', $controlIds)->get() as $soal) {
            $soal->opsiSoal()->delete(); // Hapus opsi pilihan ganda
            $soal->delete();            // Hapus soal
        }

        // 6. Hapus data dari tabel control
        \App\Models\Control::where('sesi_id', $id)->delete();

        // 7. Terakhir, hapus sesi utamanya
        $sesi->delete();

        return back()->with('success', 'Sesi ujian beserta seluruh data terkait berhasil dihapus!');
    }
}