<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sesi Ujian - {{ $sesi->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pb-12">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-base">Edit Sesi Ujian</div>
        <a href="{{ route('sesi.managesesi') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded text-sm transition">
            &lt; Kembali
        </a>
    </nav>

    <div class="max-w-3xl mx-auto mt-6 px-4">
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm shadow">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <h3 class="font-bold text-gray-800 text-base mb-4 border-b pb-2">Form Perbarui Sesi Ujian</h3>

            <form action="{{ route('sesi.update', $sesi->id_sesi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Judul Ujian</label>
                        <input type="text" name="judul" value="{{ old('judul', $sesi->judul) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Kategori (Mata Pelajaran)</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $sesi->kategori) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Sesi Ke / Keterangan</label>
                        <select id="selectSesi" name="sesi" onchange="pilihLabelSesi(this.value)"
                                class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs sm:text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="" disabled>Pilih Sesi</option>
                            <option value="Sesi 1" {{ (old('sesi', $sesi->sesi ?? '') === 'Sesi 1') ? 'selected' : '' }}>Sesi 1</option>
                            <option value="Sesi 2" {{ (old('sesi', $sesi->sesi ?? '') === 'Sesi 2') ? 'selected' : '' }}>Sesi 2</option>
                            <option value="Sesi 3" {{ (old('sesi', $sesi->sesi ?? '') === 'Sesi 3') ? 'selected' : '' }}>Sesi 3</option>
                            <option value="Sesi Cadangan" {{ (old('sesi', $sesi->sesi ?? '') === 'Sesi Cadangan') ? 'selected' : '' }}>Sesi Cadangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Tanggal Ujian</label>
                        <input type="date" name="tgl_sesi" value="{{ old('tgl_sesi', $sesi->tgl_sesi) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-bold text-slate-700">Token Ujian</label>
                            <button type="button" onclick="acakToken()" class="text-[11px] text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Acak Token
                            </button>
                        </div>
                        <input type="text" id="inputToken" name="token" value="{{ old('token', $sesi->token) }}" required uppercase maxlength="10"
                            class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs sm:text-sm font-mono uppercase tracking-widest focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $sesi->waktu_mulai) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $sesi->waktu_selesai) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Durasi (Menit)</label>
                        <input type="number" name="durasi" value="{{ old('durasi', $sesi->durasi) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-xs font-bold mb-1">Guru Penanggung Jawab</label>
                    <select name="guru_id" required class="w-full px-3 py-2 border rounded-lg text-sm bg-white focus:ring-2 focus:ring-indigo-500">
                        @foreach($guruList as $guru)
                            <option value="{{ $guru->id_guru }}" {{ $sesi->guru_id == $guru->id_guru ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-xs font-bold mb-1">Target Kelas</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 max-h-36 overflow-y-auto p-2 border rounded-lg bg-gray-50">
                        @php $selectedKelas = $sesi->kelas->pluck('id_kelas')->toArray(); @endphp
                        @foreach($kelasList as $kelas)
                            <label class="flex items-center space-x-2 text-xs font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" name="kelas_id[]" value="{{ $kelas->id_kelas }}" {{ in_array($kelas->id_kelas, $selectedKelas) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 rounded">
                                <span>{{ $kelas->nama_kelas }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('sesi.managesesi') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded-lg text-xs transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2 rounded-lg text-xs transition shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function acakToken() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let token = '';
            for (let i = 0; i < 5; i++) {
                token += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('inputToken').value = token;
        }

        function acakSesi() {
            const nomorSesi = Math.floor(Math.random() * 5) + 1;
            document.getElementById('inputSesi').value = 'Sesi ' + nomorSesi;
        }
    </script>
</body>
</html>