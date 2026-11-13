<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sesi Ujian</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 font-sans antialiased">

<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-slate-200">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h2 class="font-bold text-slate-900 text-lg">Edit Sesi Ujian</h2>
            <a href="{{ route('sesi.managesesi') }}" class="text-xs text-slate-500 hover:text-slate-700 font-semibold">&larr; Kembali ke Manajemen Sesi</a>
        </div>

        <!-- Form Edit -->
        <form action="{{ route('guru.sesi.update', $sesi->id_sesi) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Judul Ujian -->
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Ujian</label>
                <input id="judul" type="text" name="judul" required value="{{ old('judul', $sesi->judul) }}"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Mata Pelajaran (Multi-Select / Checkbox) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mata Pelajaran Ujian</label>
                <div class="border border-slate-200 rounded-lg max-h-40 overflow-y-auto p-3 bg-white grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @php
                        $selectedMapelIds = $sesi->control ? $sesi->control->pluck('mapel_id')->toArray() : [];
                    @endphp
                    @isset($listMapel)
                        @foreach($listMapel as $mapel)
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer border border-slate-200 rounded-md px-2.5 py-1.5 hover:bg-indigo-50 transition">
                                <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id_mapel }}"
                                    class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                    {{ in_array($mapel->id_mapel, old('mapel_ids', $selectedMapelIds)) ? 'checked' : '' }}>
                                <span class="font-medium">{{ $mapel->mapel }}</span>
                            </label>
                        @endforeach
                    @endisset
                </div>
            </div>

            <!-- Guru Penanggung Jawab -->
            <div>
                <label for="guru_id" class="block text-sm font-medium text-slate-700 mb-1">Guru Penanggung Jawab (PJ)</label>
                <select id="guru_id" name="guru_id" required
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Guru Pengampu...</option>
                    @isset($listGuru)
                        @foreach($listGuru as $guru)
                            <option value="{{ $guru->id_guru }}" {{ old('guru_id', $sesi->guru_id) == $guru->id_guru ? 'selected' : '' }}>
                                {{ $guru->nama }} ({{ ucfirst($guru->role) }})
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>

            <!-- Sesi dan Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sesi" class="block text-sm font-medium text-slate-700 mb-1">Label sesi</label>
                    <select id="sesi" name="sesi" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['Sesi 1', 'Sesi 2', 'Sesi 3', 'Sesi Cadangan'] as $opt)
                            <option value="{{ $opt }}" {{ old('sesi', $sesi->sesi) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tgl_sesi" class="block text-sm font-medium text-slate-700 mb-1">Tanggal pelaksanaan</label>
                    @php
                        $tglSesiOnly = $sesi->waktu_mulai ? date('Y-m-d', strtotime($sesi->waktu_mulai)) : date('Y-m-d');
                    @endphp
                    <input id="tgl_sesi" type="date" name="tgl_sesi" required value="{{ old('tgl_sesi', $tglSesiOnly) }}"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Waktu Mulai, Selesai, Durasi -->
            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-slate-700 mb-1">Jam mulai</label>
                    @php
                        $jamMulaiOnly = $sesi->waktu_mulai ? date('H:i', strtotime($sesi->waktu_mulai)) : '';
                    @endphp
                    <input id="waktu_mulai" type="time" name="waktu_mulai" required value="{{ old('waktu_mulai', $jamMulaiOnly) }}"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="waktu_selesai" class="block text-sm font-medium text-slate-700 mb-1">Jam selesai</label>
                    @php
                        $jamSelesaiOnly = $sesi->waktu_selesai ? date('H:i', strtotime($sesi->waktu_selesai)) : '';
                    @endphp
                    <input id="waktu_selesai" type="time" name="waktu_selesai" required value="{{ old('waktu_selesai', $jamSelesaiOnly) }}"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="durasi" class="block text-sm font-medium text-slate-700 mb-1">Durasi (menit)</label>
                    <input id="durasi" type="number" name="durasi" required min="1" value="{{ old('durasi', $sesi->durasi) }}"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Token Ujian -->
            <div>
                <label for="token" class="block text-sm font-medium text-slate-700 mb-1">Token ujian</label>
                <input id="token" type="text" name="token" required maxlength="10" value="{{ old('token', $sesi->token) }}"
                    class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm font-mono font-bold uppercase bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Kelas Peserta -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kelas peserta</label>
                <div class="border border-slate-200 rounded-lg max-h-48 overflow-y-auto p-3 bg-white">
                    @php
                        $selectedKelasIds = $sesi->control ? $sesi->control->pluck('kelas_id')->toArray() : [];
                        $kelasPerJurusan = $listKelas->groupBy(fn($k) => optional($k->jurusan)->nama_jurusan ?? 'Tanpa jurusan');
                    @endphp

                    @foreach($kelasPerJurusan as $namaJurusan => $kelasGroup)
                        <div class="mb-3">
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">{{ $namaJurusan }}</span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                @foreach($kelasGroup as $kelas)
                                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer border border-slate-200 rounded-md px-2 py-1.5 hover:bg-indigo-50 transition">
                                        <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id_kelas }}"
                                            class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                            {{ in_array($kelas->id_kelas, old('kelas_ids', $selectedKelasIds)) ? 'checked' : '' }}>
                                        <span>{{ $kelas->kelas }} ({{ $kelas->tingkat }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2 pt-4 border-t border-slate-200">
                <a href="{{ route('sesi.managesesi') }}" class="border border-slate-300 hover:bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm transition">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>