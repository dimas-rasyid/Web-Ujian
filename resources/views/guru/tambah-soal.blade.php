<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Soal - {{ $sesi->judul ?? 'Ujian' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <!-- Navbar / Header -->
    <div class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <h1 class="font-bold text-lg">Kelola Soal:</h1>
            </div>
            <a href="{{ route('guru.soal.index') }}" class="bg-indigo-800 hover:bg-indigo-900 text-xs px-3 py-2 rounded font-semibold transition">Kembali ke Daftar Sesi</a>
        </div>
    </div>

    <!-- Konten Utama (Grid 2 Kolom: Kiri Form, Kanan Daftar Soal) -->
    <div class="max-w-7xl mx-auto mt-6 px-4 pb-12">
        
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm shadow">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- KOLOM KIRI: Form Input Soal (Lebar 5 Kolom) -->
            <div class="lg:col-span-5 bg-white p-6 rounded-lg shadow border border-gray-200 h-fit">
                <h3 class="font-bold text-gray-800 text-base mb-1">Tambah Soal</h3>
    
                <!-- Ubah bagian banner/label informasi soal -->
                <div class="mb-4">
                    <!-- Hanti atau sesuaikan agar hanya menampilkan Mapel dan Tingkat -->
                    <span class="font-semibold text-gray-800">Untuk:</span> 
                    <span class="text-indigo-600 font-bold">{{ $control->mapel->mapel ?? '-' }}</span> — 
                    <span class="text-dark-600 font-bold">Tingkat: {{ $control->kelas->tingkat ?? '-' }}</span>
                </div>
                
                <form action="{{ route('guru.soal.store', $control->id_control) }}" method="POST">
                    @csrf
                    
                    <!-- Pilihan Tipe Soal Sederhana (Tab / Tombol) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs font-bold mb-2">Tipe Soal</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label id="label-pg" class="flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer {{ old('tipe', 'Pilihan Ganda') === 'Pilihan Ganda' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'bg-white border-gray-300 text-gray-700' }} transition">
                                <input type="radio" name="tipe" value="Pilihan Ganda" {{ old('tipe', 'Pilihan Ganda') === 'Pilihan Ganda' ? 'checked' : '' }} class="hidden" onchange="toggleTipeSoal(this.value)">
                                Pilihan Ganda
                            </label>
                            <label id="label-essay" class="flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer {{ old('tipe') === 'Essay' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'bg-white border-gray-300 text-gray-700' }} transition">
                                <input type="radio" name="tipe" value="Essay" {{ old('tipe') === 'Essay' ? 'checked' : '' }} class="hidden" onchange="toggleTipeSoal(this.value)">
                                Essay
                            </label>
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs font-bold mb-2">Pertanyaan / Soal</label>
                        <textarea name="pertanyaan" rows="2" placeholder="Tuliskan pertanyaan ujian..." required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('pertanyaan') }}</textarea>
                    </div>

                    <!-- Bagian Opsi Pilihan Ganda (Muncul otomatis jika Pilihan Ganda dipilih) -->
                    <div id="container-opsi" class="mb-4 space-y-2 border-t pt-3">
                        <label class="block text-gray-700 text-xs font-bold mb-1">Pilihan Opsi & Kunci Jawaban (A-E)</label>
                        <p class="text-[11px] text-gray-400 mb-2">Klik radio button di sebelah kiri opsi yang menjadi kunci jawaban benar.</p>
                        
                        @foreach(['A', 'B', 'C', 'D', 'E'] as $huruf)
                            <div class="flex items-center gap-2 bg-gray-50 p-2 rounded border">
                                <input type="radio" name="kunci_jawaban" value="{{ $huruf }}" {{ old('kunci_jawaban') === $huruf ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500" title="Tandai sebagai kunci jawaban">
                                <span class="font-bold text-gray-700 text-xs w-4">{{ $huruf }}.</span>
                                <input type="text" name="opsi[{{ $huruf }}]" value="{{ old('opsi.' . $huruf) }}" placeholder="Opsi {{ $huruf }}..." class="w-full px-2.5 py-1 border rounded text-xs bg-white focus:ring-1 focus:ring-indigo-500 opsi-input">
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg text-sm transition shadow mt-2">
                        Simpan Soal
                    </button>
                </form>

                <!-- CARD Import dan Bank Soal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

                    <!-- 1. Card Import Soal dari Excel -->
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-indigo-900 text-sm mb-1">Import Soal Excel</h4>
                            <p class="text-[11px] text-slate-600 mb-2">Format file: Excel / CSV.</p>
                        </div>
                        
                        <!-- Pastikan action-nya mengarah ke route import dengan parameter id_sesi -->
                        <form action="{{ route('guru.soal.import', $control->id_control) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white border border-slate-300 rounded">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-3 py-1.5 rounded text-xs transition shadow-sm">
                                Import Excel
                            </button>
                        </form>
                    </div>

                    <!-- 2. Card Tambah dari Bank Soal (Sesi Sebelumnya) -->
                    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-emerald-900 text-sm mb-1">Bank Soal</h4>
                            <p class="text-[11px] text-slate-600 mb-3">Salin soal dari sesi sebelumnya.</p>
                        </div>
                        
                        <div>
                            <!-- Tombol untuk Membuka Modal -->
                            <button onclick="document.getElementById('modalBankSoal').classList.remove('hidden')" type="button" class="w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded text-xs transition shadow-sm">
                                Ambil dari Bank &rarr;
                            </button>
                        </div>

                        <!-- ===== STRUKTUR MODAL DENGAN BACKGROUND BLUR ===== -->
                        <div id="modalBankSoal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
                            <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                                
                                <!-- Header Modal -->
                                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                                    <h3 class="font-bold text-slate-800 text-sm sm:text-base">Pilih Soal dari Bank Soal (Sesi Sebelumnya)</h3>
                                    <button type="button" onclick="document.getElementById('modalBankSoal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold text-xl px-2">&times;</button>
                                </div>

                                <!-- Body Modal -->
                                <div class="p-6 overflow-y-auto flex-1 space-y-4">
                                    <div>
                                        <input type="text" id="inputCariBank" onkeyup="filterTabelBank()" placeholder="Cari berdasarkan judul sesi..." class="w-full text-xs sm:text-sm px-3.5 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                    </div>

                                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                                        <table id="tabelBankSoal" class="w-full text-left border-collapse text-xs sm:text-sm">
                                            <thead class="bg-slate-100 text-slate-700 uppercase font-semibold text-[11px]">
                                                <tr>
                                                    <th class="p-3">No</th>
                                                    <th class="p-3">Judul Sesi</th>
                                                    <th class="p-3">Token</th>
                                                    <th class="p-3 text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 text-slate-700">
                                                @forelse($listBankSesi as $index => $bankSesi)
                                                    <tr class="hover:bg-slate-50 row-bank">
                                                        <td class="p-3">{{ $index + 1 }}</td>
                                                        <td class="p-3 font-semibold text-slate-900 data-judul">{{ $bankSesi->judul }}</td>
                                                        <td class="p-3">{{ $bankSesi->token }}</td>
                                                        <td class="p-3 text-center">
                                                            <span class="text-xs text-gray-400 italic">Segera Hadir</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="p-6 text-center text-slate-400 italic">
                                                            Belum ada data bank sesi ujian yang tersedia.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Footer Modal -->
                                <div class="px-6 py-3 border-t border-slate-200 bg-slate-50 flex justify-end">
                                    <button type="button" onclick="document.getElementById('modalBankSoal').classList.add('hidden')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs transition">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- KOLOM KANAN: Daftar Soal yang Sudah Diinput (Lebar 7 Kolom) -->
            <div class="lg:col-span-7 bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-gray-800 text-base">Daftar Soal Masuk</h3>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full">
                            Total: {{ $listSoal->count() }} Soal
                        </span>
                    </div>

                    <!-- Tombol Hapus Semua di Pojok Kanan Atas -->
                    @if($listSoal->isNotEmpty())
                        <form action="{{ route('guru.soal.destroyAll', $control->id_control ?? $id_sesi) }}" method="POST" onsubmit="return confirm('PERHATIAN: Apakah Anda yakin ingin menghapus SELURUH soal dan opsi untuk sesi/kontrol ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-lg transition shadow-sm flex items-center gap-1">
                                🗑️ Hapus Semua
                            </button>
                        </form>
                    @endif
                </div>

                <div class="space-y-4 max-h-[750px] overflow-y-auto pr-2">
                    @forelse($listSoal as $index => $soal)
                        <div class="border rounded-lg p-4 bg-gray-50 hover:bg-white transition shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="bg-gray-800 text-white text-xs font-bold px-2 py-0.5 rounded">Soal No. {{ $index + 1 }}</span>
                                    <span class="bg-blue-100 text-blue-800 text-[10px] font-semibold px-2 py-0.5 rounded">{{ $soal->tipe }}</span>
                                </div>
                                
                                <!-- Tombol Hapus Satuan -->
                                <form action="{{ route('guru.soal.destroy', $soal->id_soal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium bg-red-50 px-2 py-0.5 rounded transition border border-red-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            
                            <p class="text-sm font-medium text-gray-800 mb-3 whitespace-pre-line">{{ $soal->pertanyaan }}</p>

                            @if($soal->tipe == 'Pilihan Ganda')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    @foreach($soal->opsiSoal as $opsi)
                                        <div class="p-2 rounded border {{ $opsi->is_correct ? 'bg-emerald-50 border-emerald-300 text-emerald-900 font-semibold' : 'bg-white text-gray-600' }}">
                                            <span class="font-bold mr-1">{{ $opsi->kode_opsi }}.</span> {{ $opsi->text_opsi }}
                                            @if($opsi->is_correct)
                                                <span class="float-right text-[10px] bg-emerald-600 text-white px-1.5 py-0.5 rounded">Kunci</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-xs italic">
                            Belum ada soal yang diinput untuk sesi ini. Silakan buat melalui form di sebelah kiri.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Script JavaScript untuk Toggle Pilihan Ganda / Essay Sederhana -->
    <script>
        function toggleTipeSoal(tipe) {
            const containerOpsi = document.getElementById('container-opsi');
            const opsiInputs = document.querySelectorAll('.opsi-input');
            const radioKunci = document.querySelectorAll('input[name="kunci_jawaban"]');
            
            const labelPg = document.getElementById('label-pg');
            const labelEssay = document.getElementById('label-essay');

            if (tipe === 'Essay') {
                containerOpsi.style.display = 'none';
                // Hapus atribut required agar tidak wajib diisi saat essay
                opsiInputs.forEach(input => input.removeAttribute('required'));
                radioKunci.forEach(radio => radio.removeAttribute('required'));

                // Styling aktif tombol tab
                labelEssay.className = "flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer bg-indigo-50 border-indigo-500 text-indigo-700 transition";
                labelPg.className = "flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer bg-white border-gray-300 text-gray-700 transition";
            } else {
                containerOpsi.style.display = 'block';
                opsiInputs.forEach(input => input.setAttribute('required', 'required'));
                radioKunci.forEach(radio => radio.setAttribute('required', 'required'));

                // Styling aktif tombol tab
                labelPg.className = "flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer bg-indigo-50 border-indigo-500 text-indigo-700 transition";
                labelEssay.className = "flex items-center justify-center px-3 py-2 border rounded-lg text-sm font-semibold cursor-pointer bg-white border-gray-300 text-gray-700 transition";
            }
        }

        // Jalankan pengecekan awal saat halaman dimuat (untuk mendeteksi state old() jika validasi gagal)
        document.addEventListener("DOMContentLoaded", function() {
            const checkedTipe = document.querySelector('input[name="tipe"]:checked');
            if (checkedTipe) {
                toggleTipeSoal(checkedTipe.value);
            }
        });
    </script>

    <!-- Script MODAL AMBIL SOAL DARI BANK SOAL -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Script Sederhana untuk Filter Pencarian Tabel Bank Soal -->
    <script>
        function filterTabelBank() {
            let input = document.getElementById('inputCariBank').value.toLowerCase();
            let rows = document.querySelectorAll('.row-bank');

            rows.forEach(row => {
                let judul = row.querySelector('.data-judul') ? row.querySelector('.data-judul').innerText.toLowerCase() : '';
                let kategori = row.querySelector('.data-kategori') ? row.querySelector('.data-kategori').innerText.toLowerCase() : '';
                let sesi = row.querySelector('.data-sesi') ? row.querySelector('.data-sesi').innerText.toLowerCase() : '';

                if (judul.includes(input) || kategori.includes(input) || sesi.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>