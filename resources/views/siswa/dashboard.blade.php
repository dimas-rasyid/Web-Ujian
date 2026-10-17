<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Ujian Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-10">

    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-4 py-3.5 flex justify-between items-center shadow-md sticky top-0 z-40">
        <h1 class="font-bold text-sm sm:text-base tracking-wide">Ujian Online Siswa</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 active:scale-95 px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                Keluar
            </button>
        </form>
    </nav>

    <main class="max-w-md sm:max-w-2xl lg:max-w-4xl mx-auto mt-4 px-4">

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-xs shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profil siswa -->
        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-slate-200 mb-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Selamat datang,</p>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">{{ $siswa->nama ?? session('nama') }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2 py-0.5 rounded-md border border-indigo-100">
                        {{ $siswa->kelas->nama_kelas ?? 'Kelas tidak diketahui' }}
                    </span>
                    <span class="text-slate-400 text-xs">&bull;</span>
                    <span class="text-slate-500 text-xs">NISN: {{ $siswa->nisn ?? '-' }}</span>
                </div>
            </div>
            <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm shadow-inner">
                {{ strtoupper(mb_substr($siswa->nama ?? 'S', 0, 1)) }}
            </div>
        </div>

        <!-- Daftar sesi -->
        <div class="flex justify-between items-center mb-3 px-1">
            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Daftar ujian</h3>
            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">
                {{ $listSesi->count() }} sesi
            </span>
        </div>

        <div class="space-y-3">
            @forelse($listSesi as $sesi)
                @php
                    // Status ditentukan dari jadwal dan data nilai siswa ini
                    $tgl     = \Carbon\Carbon::parse($sesi->tgl_sesi)->format('Y-m-d');
                    $mulai   = \Carbon\Carbon::parse($tgl . ' ' . $sesi->waktu_mulai);
                    $selesai = \Carbon\Carbon::parse($tgl . ' ' . $sesi->waktu_selesai);
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
                @endphp

                <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200">
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                            {{ $sesi->kategori ?? 'Umum' }}
                        </span>
                        <span class="text-[11px] font-medium text-slate-400">{{ $mulai->translatedFormat('d M Y') }}</span>
                    </div>

                    <h4 class="font-bold text-slate-900 text-base sm:text-lg mb-1 leading-snug">{{ $sesi->judul }}</h4>

                    <div class="grid grid-cols-2 gap-2 my-3 text-xs text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <div>
                            <span class="text-slate-400 block text-[10px]">Waktu ujian</span>
                            <span class="font-semibold text-slate-700">{{ $mulai->format('H:i') }} - {{ $selesai->format('H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Durasi</span>
                            <span class="font-semibold text-slate-700">{{ $sesi->durasi }} menit</span>
                        </div>
                    </div>

                    {{-- Tombol aksi sesuai status --}}
                    @if($state === 'buka')
                        <button type="button"
                                data-url="{{ route('siswa.sesi.token', $sesi->id_sesi) }}"
                                data-judul="{{ $sesi->judul }}"
                                onclick="bukaModalToken(this)"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm transition shadow-sm">
                            Mulai ujian
                        </button>

                    @elseif($state === 'lanjut')
                        <form action="{{ route('siswa.sesi.token', $sesi->id_sesi) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-amber-500 hover:bg-amber-600 active:scale-[0.98] text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm transition shadow-sm">
                                Lanjutkan ujian
                            </button>
                        </form>

                    @elseif($state === 'belum')
                        <button type="button" disabled
                                class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm cursor-not-allowed">
                            Dibuka pukul {{ $mulai->format('H:i') }}
                        </button>

                    @elseif($state === 'berakhir')
                    <button type="button" disabled
                            class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm cursor-not-allowed">
                        Waktu ujian berakhir
                    </button>

                    @else
                        {{-- Ambil nilai khusus sesi ini dari variabel $statusNilai / query --}}
                        @php
                            $dataNilai = \App\Models\Nilai::where('siswa_id', $siswa->id_siswa)
                                ->where('sesi_id', $sesi->id_sesi)
                                ->first();
                        @endphp

                        @if($dataNilai && $dataNilai->status === 'menunggu_koreksi')
                            {{-- Tampilan Jika Ada Soal Essay (Menunggu Koreksi Guru) --}}
                            <div class="w-full bg-amber-50 text-amber-800 border border-amber-200 font-semibold py-2.5 px-4 rounded-xl text-xs sm:text-sm flex justify-between items-center">
                                <span>Status Ujian:</span>
                                <span class="bg-amber-200/70 text-amber-900 px-2.5 py-1 rounded-lg text-xs font-bold">
                                    Menunggu Koreksi Guru
                                </span>
                            </div>
                        @else
                            {{-- Tampilan Jika Pilihan Ganda Murni / Sudah Selesai Dikoreksi --}}
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
                <div class="bg-white rounded-xl p-8 text-center border border-slate-200 shadow-sm">
                    <p class="text-slate-600 text-xs sm:text-sm font-medium">Belum ada sesi ujian untuk kelas Anda.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal token -->
    <div id="modalToken" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50"
         onclick="if (event.target === this) tutupModalToken()">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-100">
            <h3 id="modalJudulSesi" class="font-bold text-slate-900 text-base mb-1">Konfirmasi token ujian</h3>
            <p class="text-xs text-slate-500 mb-4">Masukkan token akses yang diberikan oleh pengawas.</p>

            <form id="formToken" method="POST">
                @csrf
                <div class="mb-4">
                    <input id="inputToken" type="text" name="token" required maxlength="10" autocomplete="off"
                           placeholder="Ketik token di sini"
                           class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm uppercase font-mono tracking-widest text-center focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="tutupModalToken()"
                            class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-xl text-xs transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-xs transition shadow-sm">
                        Masuk ujian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalToken');

        // Judul dan URL dibaca dari data-attribute, bukan disisipkan ke string JavaScript,
        // supaya judul yang memuat tanda kutip tidak merusak skrip.
        function bukaModalToken(btn) {
            document.getElementById('formToken').action = btn.dataset.url;
            document.getElementById('modalJudulSesi').textContent = 'Ujian: ' + btn.dataset.judul;

            const input = document.getElementById('inputToken');
            input.value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            input.focus();
        }

        function tutupModalToken() {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupModalToken(); });

        // Muat ulang tiap menit supaya tombol "Mulai ujian" aktif saat jadwal tiba.
        // Tidak dijalankan saat modal token sedang terbuka.
        setInterval(() => {
            if (modal.classList.contains('hidden')) location.reload();
        }, 60000);
    </script>
</body>
</html>