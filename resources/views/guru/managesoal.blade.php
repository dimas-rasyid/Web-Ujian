<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Soal Ujian - SMKS 2 PGRI Darjo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header / Navbar -->
    <div class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg">Manajemen Soal Ujian</h1>
            <a href="{{ route('guru.dashboard') }}" class="bg-indigo-800 hover:bg-indigo-900 text-xs px-3 py-2 rounded font-semibold transition">Kembali ke Dashboard</a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto px-4 py-6">

        <!-- Filter Judul Sesi / Pencarian -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
            <h3 class="font-bold text-gray-800 text-base mb-3">🔍 Filter Sesi Ujian</h3>
            <form action="{{ route('guru.soal.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul sesi atau mata pelajaran..." class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2 rounded text-sm transition">
                    Filter / Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('guru.soal.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded text-sm text-center transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Daftar Sesi / Kontrol Soal -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 text-base">Pilih Sesi Ujian untuk Mengelola Soal</h3>
            </div>
            
            <div class="bg-white rounded border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Judul Sesi</th>
                            <th class="p-3">Mata Pelajaran</th>
                            <th class="p-3">Kelas / Tingkat</th>
                            <th class="p-3 text-center">Jumlah Soal</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @isset($listControl)
                            @forelse($listControl as $index => $control)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-500 text-xs">{{ $index + 1 }}</td>
                                    <td class="p-3 text-gray-800 font-medium">
                                        📝 {{ $control->sesi->judul ?? '-' }}
                                        <div class="text-xs text-gray-400 font-normal">Token: {{ $control->sesi->token ?? '-' }}</div>
                                    </td>
                                    <td class="p-3 text-indigo-700 font-semibold">📚 {{ $control->mapel->mapel ?? '-' }}</td>
                                    <td class="p-3 text-gray-700">
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs border border-indigo-100 font-semibold">
                                            {{ $control->kelas->kelas ?? '-' }} ({{ $control->kelas->tingkat ?? '-' }})
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded text-xs font-bold border border-emerald-200">
                                            {{ $control->soal_count ?? 0 }} Soal
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <!-- Tombol Masuk ke Halaman Tambah/Kelola Soal berdasarkan Control ID -->
                                        <a href="{{ route('guru.soal.detail', $control->sesi_id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded text-xs transition inline-block">
                                            Kelola Soal
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 text-xs italic">
                                        Belum ada data sesi ujian / kontrol yang terdaftar. Silakan buat sesi ujian terlebih dahulu.
                                    </td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-400 text-xs italic">
                                    Data sesi tidak ditemukan.
                                </td>
                            </tr>
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>