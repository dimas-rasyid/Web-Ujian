<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Panel Pengajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar Guru -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-lg">Panel Guru / Pengawas - SMKS 2 PGRI Darjo</div>
        <div class="flex items-center gap-4">
            <span class="text-sm bg-indigo-700 px-3 py-1 rounded">Halo, {{ session('nama') }}</span>
            <form action="{{ route('logout.guru') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-6xl mx-auto mt-6 px-4 pb-12">
        
        <!-- Flash Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card Menu Manajemen Data Master -->
        <div class="mb-3">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                {{ session('role') === 'admin' ? 'Manajemen Data Master' : 'Menu Pengajar' }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if(session('role') === 'admin')
                    <!-- Card Gabungan Jurusan & Kelas -->
                    <a href="{{ route('guru.jurusan-kelas.index') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🏢 Jurusan & Kelas</div>
                        <p class="text-xs text-gray-500">Kelola data program keahlian dan rombel kelas</p>
                    </a>

                    <!-- Card Mapel Guru -->
                    <a href="{{ route('guru.mapel.index') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🔗 Mata Pelajaran</div>
                        <p class="text-xs text-gray-500">Kelola pengampu mata pelajaran</p>
                    </a>

                    <!-- Card Guru -->
                    <a href="{{ route('guru.manageguru') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">👨‍🏫 Guru / Admin</div>
                        <p class="text-xs text-gray-500">Kelola akun pengajar & pengawas</p>
                    </a>

                    <!-- Card Siswa -->
                    <a href="{{ route('guru.managesiswa') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🎓 Siswa</div>
                        <p class="text-xs text-gray-500">Kelola data peserta didik / NISN</p>
                    </a>

                    <!-- Card Manage Sesi -->
                    <a href="{{ route('sesi.managesesi') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🕒 Manajemen Sesi</div>
                        <p class="text-xs text-gray-500">Kelola jadwal, waktu, token, dan sesi ujian</p>
                    </a>
                @endif

                <!-- Card Manage Soal (Bisa diakses Admin maupun Guru Pengampu) -->
                <a href="{{ route('guru.soal.index') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                    <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">📝 Manage Soal</div>
                    <p class="text-xs text-gray-500">Kelola soal dan jawaban</p>
                </a>
            </div>
        </div>

        <!-- Daftar Sesi Ujian -->
        <div class="flex justify-between items-center mb-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Sesi Ujian</h2>
            </div>
        </div>
        <!-- Tabel Daftar Sesi -->
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4">No</th>
                            <th class="p-4">Judul Ujian</th>
                            <th class="p-4">Mata Pelajaran (Sesi Ini)</th> <!-- Diubah label headernya -->
                            <th class="p-4">Kelas</th>
                            <th class="p-4">Token</th>
                            <th class="p-4">Durasi</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        @forelse($listSesi as $index => $sesi)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">{{ $listSesi->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="font-semibold text-gray-900">{{ $sesi->judul }}</div>
                                    <div class="text-[11px] text-emerald-700 font-bold">{{ $sesi->sesi }} ({{ date('d/m/Y', strtotime($sesi->waktu_mulai)) }})</div>
                                </td>
                                
                                <!-- Kolom Daftar Mata Pelajaran dalam Sesi (Melalui relasi control) -->
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @php
                                            // Mengambil mapel unik yang terhubung ke sesi ini melalui tabel control
                                            $mapelsInSesi = \App\Models\Control::where('sesi_id', $sesi->id_sesi)
                                                ->with('mapel')
                                                ->get()
                                                ->pluck('mapel')
                                                ->unique('id_mapel');
                                        @endphp

                                        @forelse($mapelsInSesi as $mapelItem)
                                            <span class="bg-blue-100 text-blue-800 text-[11px] px-2 py-0.5 rounded font-semibold">
                                                {{ strtoupper($mapelItem->mapel ?? '-') }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-xs">Tidak ada mapel</span>
                                        @endforelse
                                    </div>
                                </td>
                                
                                <!-- Kolom Data Kelas -->
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($sesi->kelas as $kelasItem)
                                            <span class="bg-purple-100 text-purple-800 text-[11px] px-2 py-0.5 rounded font-semibold">
                                                {{ $kelasItem->kelas }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-xs">Semua Kelas</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td class="p-4 font-mono font-bold text-indigo-600">{{ $sesi->token }}</td>
                                <td class="p-4">{{ $sesi->durasi }} Menit</td>
                                
                                <td class="p-4 text-center space-x-2 whitespace-nowrap">
                                    <!-- Tombol Rekap Nilai -->
                                    <a href="#" class="inline-block text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-bold px-2.5 py-1.5 rounded-lg transition text-xs">
                                        Rekap Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 italic text-sm">
                                    Belum ada sesi ujian yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            @if(isset($listSesi) && $listSesi->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50 text-xs text-gray-500">
                    {{ $listSesi->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>