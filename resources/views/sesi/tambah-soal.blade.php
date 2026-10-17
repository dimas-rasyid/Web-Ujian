<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Soal - {{ $sesi->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-base">Kelola Soal: <span class="font-normal">{{ $sesi->judul }}</span></div>
        <a href="{{ route('guru.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded text-sm transition">
            &lt; Kembali ke Dashboard
        </a>
    </nav>

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
                <h3 class="font-bold text-gray-800 text-base mb-4 border-b pb-2">Tambah Soal Baru</h3>
                
                <form action="{{ route('guru.soal.store', $sesi->id_sesi) }}" method="POST">
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
                        <textarea name="pertanyaan" rows="4" placeholder="Tuliskan pertanyaan ujian..." class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('pertanyaan') }}</textarea>
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

                <!-- Form Import Excel -->
                <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg mt-6">
                    <h4 class="font-bold text-indigo-900 text-sm mb-2">Import Soal dari Excel</h4>
                    <form action="{{ route('guru.soal.import', $sesi->id_sesi) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white border rounded-md">
                        <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition shadow whitespace-nowrap">
                            Import Excel
                        </button>
                    </form>
                    <p class="text-[11px] text-slate-500 mt-2">Format kolom excel: Kolom Soal, Opsi A, B, C, D, E, dan Kunci (Kosongkan opsi & kunci jika Essay).</p>
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

                    <!-- Tombol Hapus Semua Soal -->
                    @if($listSoal->count() > 0)
                        <form action="{{ route('guru.soal.destroyAll', $sesi->id_sesi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SELURUH soal pada sesi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-3 py-1 rounded text-xs transition border border-red-200">
                                Hapus Semua Soal
                            </button>
                        </form>
                    @endif
                </div>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
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
                            
                            <!-- Menjaga format baris baru / teks kode dengan whitespace-pre-line -->
                            <p class="text-sm font-medium text-gray-800 mb-3 whitespace-pre-line">{{ $soal->pertanyaan }}</p>

                            @if($soal->tipe == 'Pilihan Ganda')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    @foreach($soal->opsi as $opsi)
                                        <div class="p-2 rounded border {{ $opsi->is_correct ? 'bg-emerald-50 border-emerald-300 text-emerald-900 font-semibold' : 'bg-white text-gray-600' }}">
                                            <span class="font-bold mr-1">{{ $opsi->kode_opsi }}.</span> {{ $opsi->teks_opsi }}
                                            @if($opsi->is_correct)
                                                <span class="float-right text-[10px] bg-emerald-600 text-white px-1.5 py-0.5 rounded">Kunci</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-xs text-gray-400 italic bg-white p-2 rounded border">
                                    Jenis soal uraian (Essay) bebas jawaban siswa.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-xs italic">
                            Belum ada soal yang diinput untuk sesi ini. Silakan buat melalui form di sebelah kiri atau import dari Excel.
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
    </script>
</body>
</html>