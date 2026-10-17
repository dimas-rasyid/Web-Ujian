<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai: {{ $sesi->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-10">

    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <h1 class="font-bold text-base">Rekap Nilai & Koreksi Ujian</h1>
        <a href="{{ route('guru.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
            Kembali ke Dashboard
        </a>
    </nav>

    <main class="max-w-5xl mx-auto mt-6 px-4">
        <!-- Informasi Sesi -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $sesi->judul }}</h2>
                <p class="text-xs text-slate-500 mt-1">Tanggal: {{ $sesi->tgl_sesi }} | Durasi: {{ $sesi->durasi }} Menit</p>
            </div>

            <!-- Filter Kelas -->
            <form method="GET" action="{{ route('guru.sesi.nilai', $sesi->id_sesi) }}" class="flex items-center gap-2 w-full sm:w-auto">
                <label class="text-xs font-bold text-slate-600 whitespace-nowrap">Filter Kelas:</label>
                <select name="kelas_id" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @foreach($listKelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($kelasIdDipilih == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Tabel Rekap Nilai -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-600 uppercase">
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NISN</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Skor Akhir</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($listNilai as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-semibold text-slate-500">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-slate-900">{{ $item->siswa->nama ?? '-' }}</td>
                            <td class="p-4 text-slate-600 font-mono">{{ $item->siswa->nisn ?? '-' }}</td>
                            <td class="p-4 text-slate-600 font-semibold">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="p-4">
                                @if($item->status === 'menunggu_koreksi')
                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full font-bold text-[10px]">Menunggu Koreksi</span>
                                @elseif($item->status === 'selesai')
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-bold text-[10px]">Selesai</span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full font-bold text-[10px]">Sedang Mengerjakan</span>
                                @endif
                            </td>
                            <td class="p-4 text-center font-bold text-slate-900 text-sm">
                                {{ $item->skor }}
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('guru.sesi.koreksi', [$sesi->id_sesi, $item->siswa_id]) }}" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-bold px-3 py-1.5 rounded-lg transition">
                                    Koreksi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data siswa untuk kelas ini pada sesi ujian tersebut.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>