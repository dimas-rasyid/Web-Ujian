<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ujian Siswa</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between">

    <div>
        <!-- Navbar -->
        <nav class="bg-indigo-600 text-white px-4 py-3.5 flex justify-between items-center shadow-md sticky top-0 z-40">
            <h1 class="font-bold text-sm sm:text-base tracking-wide flex items-center gap-2">
                🎓 Ujian Online Siswa
            </h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 active:scale-95 px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                    Keluar
                </button>
            </form>
        </nav>

        <main class="max-w-md sm:max-w-2xl lg:max-w-4xl mx-auto mt-6 px-4 pb-12">

            <!-- Alert Error -->
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-xs shadow-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Alert Success -->
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profil Siswa -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 font-medium">Selamat datang,</p>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">{{ $siswa->nama ?? session('nama') }}</h2>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-0.5 rounded-md border border-indigo-100">
                            {{ $siswa->kelas->kelas ?? 'Kelas tidak diketahui' }} ({{ $siswa->kelas->tingkat ?? '-' }})
                        </span>
                        <span class="text-slate-300 text-xs">&bull;</span>
                        <span class="text-slate-500 text-xs font-medium">NISN: {{ $siswa->nisn ?? '-' }}</span>
                    </div>
                </div>
                <div class="h-12 w-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-base shadow-inner">
                    {{ strtoupper(mb_substr($siswa->nama ?? 'S', 0, 1)) }}
                </div>
            </div>

            <!-- Header Daftar Sesi -->
            <div class="flex justify-between items-center mb-3 px-1">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base">Jadwal & Daftar Ujian</h3>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    {{ $listSesi->count() }} Sesi Tersedia
                </span>
            </div>

            <!-- List Sesi Ujian -->
            <div class="space-y-4">
                @forelse($listSesi as $sesi)
                    @php
                        // Langsung parse dari waktu_mulai dan waktu_selesai
                        $mulai   = \Carbon\Carbon::parse($sesi->waktu_mulai);
                        $selesai = \Carbon\Carbon::parse($sesi->waktu_selesai);
                        $nilaiStatus = $statusNilai[$sesi->id_sesi] ?? null;

                        if (in_array($nilaiStatus, ['selesai', 'menunggu_koreksi'])) {
                            $state = 'dikerjakan';
                        } elseif (now()->lt($mulai)) {
                            $state = 'belum';
                        } elseif (now()->gt($selesai)) {
                            $state = 'berakhir';
                        } elseif ($nilaiStatus === 'mengerjakan') {
                            $state = 'lanjut';
                        } else {
                            $state = 'buka';
                        }

                        // Ambil daftar mata pelajaran dari tabel Control sesuai ERD terbaru
                        $mapelsInSesi = \App\Models\Control::where('sesi_id', $sesi->id_sesi)
                            ->with('mapel')
                            ->get()
                            ->pluck('mapel')
                            ->unique('id_mapel');
                    @endphp

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 hover:border-slate-300 transition">
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                {{ $sesi->sesi ?? 'Ujian' }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-2.5 py-1 rounded-lg">
                                📅 {{ $mulai->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        <h4 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug">{{ $sesi->judul }}</h4>

                        <!-- Badge Mata Pelajaran (Dinamis dari Relasi Control) -->
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="text-xs text-slate-400 self-center mr-1">Mapel:</span>
                            @forelse($mapelsInSesi as $mapelItem)
                                <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[11px] font-bold px-2 py-0.5 rounded-md">
                                    {{ strtoupper($mapelItem->mapel ?? '-') }}
                                </span>
                            @empty
                                <span class="text-slate-400 text-xs italic">Umum</span>
                            @endforelse
                        </div>

                        <!-- Info Waktu & Durasi -->
                        <div class="grid grid-cols-2 gap-3 my-3 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] font-medium uppercase tracking-wider">Waktu Pelaksanaan</span>
                                <span class="font-bold text-slate-700">🕒 {{ $mulai->format('H:i') }} - {{ $selesai->format('H:i') }} WIB</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] font-medium uppercase tracking-wider">Durasi Pengerjaan</span>
                                <span class="font-bold text-slate-700">⏱️ {{ $sesi->durasi }} Menit</span>
                            </div>
                        </div>

                        {{-- Tombol Aksi Sesuai Status Ujian --}}
                        @if($state === 'buka')
                            <button type="button"
                                    data-url="{{ route('siswa.sesi.token', $sesi->id_sesi) }}"
                                    data-judul="{{ $sesi->judul }}"
                                    onclick="bukaModalToken(this)"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm transition shadow-sm">
                                Mulai Ujian Sekarang
                            </button>

                        @elseif($state === 'lanjut')
                            <form action="{{ route('siswa.sesi.token', $sesi->id_sesi) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-amber-500 hover:bg-amber-600 active:scale-[0.98] text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm transition shadow-sm">
                                    Lanjutkan Ujian
                                </button>
                            </form>

                        @elseif($state === 'belum')
                            <button type="button" disabled
                                    class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm cursor-not-allowed">
                                Dibuka pukul {{ $mulai->format('H:i') }} WIB
                            </button>

                        @elseif($state === 'berakhir')
                            <button type="button" disabled
                                    class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm cursor-not-allowed">
                                Waktu Ujian Telah Berakhir
                            </button>

                        @else
                            @php
                                $dataNilai = \App\Models\Nilai::where('siswa_id', $siswa->id_siswa)
                                    ->where('sesi_id', $sesi->id_sesi)
                                    ->first();
                            @endphp

                            @if($dataNilai && $dataNilai->status === 'menunggu_koreksi')
                                <div class="w-full bg-amber-50 text-amber-800 border border-amber-200 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm flex justify-between items-center">
                                    <span>Status Ujian:</span>
                                    <span class="bg-amber-200/70 text-amber-900 px-2.5 py-1 rounded-lg text-xs font-bold">
                                        Menunggu Koreksi Guru
                                    </span>
                                </div>
                            @else
                                <div class="w-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm flex justify-between items-center">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Ujian Selesai
                                    </span>
                                    <span class="bg-emerald-600 text-white font-bold px-3 py-1 rounded-lg text-xs shadow-sm">
                                        Nilai: {{ $dataNilai->skor ?? 0 }}
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-10 text-center border border-slate-200 shadow-sm">
                        <div class="text-3xl mb-2">🎉</div>
                        <p class="text-slate-600 text-xs sm:text-sm font-semibold">Belum ada jadwal sesi ujian untuk kelas Anda saat ini.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Modal Token Ujian -->
    <div id="modalToken" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50 transition-opacity"
         onclick="if (event.target === this) tutupModalToken()">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 transform transition-all">
            <h3 id="modalJudulSesi" class="font-bold text-slate-900 text-base mb-1">Konfirmasi Token Ujian</h3>
            <p class="text-xs text-slate-500 mb-4">Masukkan token akses yang diberikan oleh pengawas atau guru pengampu.</p>

            <form id="formToken" method="POST">
                @csrf
                <div class="mb-4">
                    <input id="inputToken" type="text" name="token" required maxlength="10" autocomplete="off"
                           placeholder="Ketik token di sini"
                           class="w-full px-3.5 py-3 border border-slate-300 rounded-xl text-sm uppercase font-mono tracking-widest text-center focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-slate-50">
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="tutupModalToken()"
                            class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-xl text-xs transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-xs transition shadow-sm">
                        Masuk Ujian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function bukaModalToken(button) {
            const url = button.getAttribute('data-url');
            const judul = button.getAttribute('data-judul');

            document.getElementById('formToken').action = url;
            document.getElementById('modalJudulSesi').innerText = judul;
            document.getElementById('modalToken').classList.remove('hidden');
            document.getElementById('modalToken').classList.add('flex');
            document.getElementById('inputToken').focus();
        }

        function tutupModalToken() {
            document.getElementById('modalToken').classList.remove('flex');
            document.getElementById('modalToken').classList.add('hidden');
            document.getElementById('inputToken').value = '';
        }
    </script>
</body>
</html>