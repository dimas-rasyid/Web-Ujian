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
        <div class="mb-0">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                {{ session('role') === 'admin' ? 'Manajemen Data Master' : 'Menu Pengajar' }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if(session('role') === 'admin')
                    <!-- Card Gabungan Jurusan & Kelas (Hanya Admin) -->
                    <a href="{{ route('guru.jurusan-kelas.index') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🏢 Jurusan & Kelas</div>
                        <p class="text-xs text-gray-500">Kelola data program keahlian dan rombel kelas</p>
                    </a>

                    <!-- Card Guru (Hanya Admin) -->
                    <a href="{{ route('guru.manageguru') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">👨‍🏫 Guru / Admin</div>
                        <p class="text-xs text-gray-500">Kelola akun pengajar & pengawas</p>
                    </a>

                    <!-- Card Siswa (Hanya Admin) -->
                    <a href="{{ route('guru.managesiswa') }}" class="bg-white p-5 rounded-lg shadow border border-gray-200 hover:border-indigo-500 hover:shadow-md transition group">
                        <div class="text-indigo-600 font-bold text-lg mb-1 group-hover:translate-x-1 transition-transform">🎓 Siswa</div>
                        <p class="text-xs text-gray-500">Kelola data peserta didik / NISN</p>
                    </a>
                @endif
            </div>
        </div>

        <!-- Daftar Sesi Ujian -->
        <div class="flex justify-between items-center mb-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Sesi Ujian</h2>
            </div>
            @if(session('role') === 'admin')
                <div>
                    <a href="{{ route('sesi.managesesi') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                        Kelola Sesi Ujian
                    </a>
                </div>
            @endif
        </div>

        <!-- Tabel Daftar Sesi -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 mt-6">
            <div class="p-6 flex justify-between items-center border-b">
                <h3 class="font-bold text-gray-800 text-base">Daftar Sesi Ujian</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-4">No</th>
                            <th class="p-4">Judul Ujian</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Kelas</th> <!-- Kolom Kelas Ditambahkan di Sini -->
                            <th class="p-4">Token</th>
                            <th class="p-4">Durasi</th>
                            <th class="p-4 text-center">Jumlah Soal</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        @forelse($listSesi as $index => $sesi)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">{{ $listSesi->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="font-semibold text-gray-900">{{ $sesi->judul }}</div>
                                    <div class="text-[11px] text-emerald-700 font-bold">{{ $sesi->sesi }} ({{ date('d/m/Y', strtotime($sesi->tgl_sesi)) }})</div>
                                </td>
                                <td class="p-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded font-medium">
                                        {{ strtoupper($sesi->kategori ?? 'Umum') }}
                                    </span>
                                </td>
                                
                                <!-- Kolom Data Kelas (Menampilkan badge untuk setiap kelas yang terelasi) -->
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($sesi->kelas as $kelasItem)
                                            <span class="bg-purple-100 text-purple-800 text-[11px] px-2 py-0.5 rounded font-semibold">
                                                {{ $kelasItem->nama_kelas }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-xs">Semua Kelas</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td class="p-4 font-mono font-bold text-indigo-600">{{ $sesi->token }}</td>
                                <td class="p-4">{{ $sesi->durasi }} Menit</td>
                                <td class="p-4 text-center">
                                    <span class="bg-gray-100 px-2.5 py-1 rounded font-bold text-xs">
                                        {{ $sesi->soal->count() }}
                                    </span>
                                </td>
                                <td class="p-4 text-center space-x-2 whitespace-nowrap">
                                    @php
                                        // Cek apakah tanggal sesi sudah lewat dari hari ini
                                        $isExpired = $sesi->tgl_sesi < date('Y-m-d');
                                    @endphp

                                    <!-- Tombol Tambah Soal (Berubah jadi kuning/amber jika tanggal sudah terlewat) -->
                                    <a href="{{ route('guru.soal.create', $sesi->id_sesi) }}" 
                                    class="inline-block font-bold px-2.5 py-1.5 rounded-lg transition text-xs {{ $isExpired ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-blue-700 bg-blue-50 hover:bg-blue-100' }}">
                                        {{ $isExpired ? 'Tambah Soal' : 'Tambah Soal' }}
                                    </a>

                                    <!-- Tombol Rekap Nilai -->
                                    <a href="{{ route('guru.sesi.nilai', $sesi->id_sesi) }}" class="inline-block text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-bold px-2.5 py-1.5 rounded-lg transition text-xs">
                                        Rekap Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 italic text-sm">
                                    Belum ada sesi ujian yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            @if(isset($listSesi) && $listSesi->hasPages())
                <div class="p-4 border-t bg-gray-50 text-xs text-gray-500">
                    {{ $listSesi->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>