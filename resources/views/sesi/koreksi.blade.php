<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koreksi Ujian: {{ $siswa->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-12">

    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <h1 class="font-bold text-base">Lembar Koreksi Jawaban Siswa</h1>
        <a href="{{ route('guru.sesi.nilai', $sesi->id_sesi) }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
            Kembali ke Rekap Nilai
        </a>
    </nav>

    <main class="max-w-3xl mx-auto mt-6 px-4">
        <!-- Informasi Siswa & Ujian -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-6 flex justify-between items-center">
            <div>
                <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2 py-0.5 rounded-md border border-indigo-100">
                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                </span>
                <h2 class="text-lg font-bold text-slate-900 mt-1">{{ $siswa->nama }}</h2>
                <p class="text-xs text-slate-500">NISN: {{ $siswa->nisn }} | Ujian: {{ $sesi->judul }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 block">Skor Sementara</span>
                <span class="text-xl font-extrabold text-indigo-600">{{ $nilai->skor }}</span>
            </div>
        </div>

        <form action="{{ route('guru.sesi.koreksi.simpan', [$sesi->id_sesi, $siswa->id_siswa]) }}" method="POST">
            @csrf
            
            <div class="space-y-4 mb-6">
                @foreach($listSoal as $index => $soal)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                        <div class="flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                            <span class="text-xs font-bold text-indigo-600">Soal No. {{ $index + 1 }} ({{ $soal->tipe }})</span>
                        </div>

                        <div class="text-sm font-medium text-slate-900 mb-3">
                            {!! nl2br(e($soal->pertanyaan)) !!}
                        </div>

                        @php
                            $jawabanSiswa = $soal->jawaban->first()->jawaban ?? '-';
                        @endphp

                        @if($soal->tipe === 'Pilihan Ganda')
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs">
                                <span class="font-bold text-slate-600">Jawaban Siswa: </span>
                                <span class="font-bold text-indigo-700 uppercase">{{ $jawabanSiswa }}</span>
                            </div>
                        @else
                            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs mb-3">
                                <span class="font-bold text-slate-600 block mb-1">Jawaban Essay Siswa:</span>
                                <p class="text-slate-800 whitespace-pre-line bg-white p-3 rounded-lg border border-slate-100">{{ $jawabanSiswa }}</p>
                            </div>

                            <!-- Pilihan Penilaian Essay Otomatis -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Penilaian Essay:</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer bg-white px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                                        <input type="radio" name="nilai_essay[{{ $soal->id_soal }}]" value="0" checked class="text-indigo-600 focus:ring-indigo-500">
                                        <span class="font-semibold text-slate-700">Salah (0)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer bg-white px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                                        <input type="radio" name="nilai_essay[{{ $soal->id_soal }}]" value="0.5" class="text-indigo-600 focus:ring-indigo-500">
                                        <span class="font-semibold text-slate-700">Setengah Benar (0.5)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer bg-white px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                                        <input type="radio" name="nilai_essay[{{ $soal->id_soal }}]" value="1" class="text-indigo-600 focus:ring-indigo-500">
                                        <span class="font-semibold text-slate-700">Benar (1)</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold py-3.5 px-6 rounded-2xl text-sm transition shadow-md">
                Simpan Penilaian & Selesaikan Koreksi
            </button>
        </form>
    </main>
</body>
</html>