<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengampu Mata Pelajaran - SMKS 2 PGRI Darjo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header / Navbar -->
    <div class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg">Manajemen Pengampu Mata Pelajaran</h1>
            <a href="{{ route('guru.dashboard') }}" class="bg-indigo-800 hover:bg-indigo-900 text-xs px-3 py-2 rounded font-semibold transition">Kembali ke Dashboard</a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto px-4 py-6">

        <!-- Pesan Sukses / Error -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Grid Layout 2 Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Form Gabungan Tambah Mapel & Assign Guru Pengampu -->
            <div class="space-y-6">
                <!-- Tambah Manual -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base mb-4">📚 Mata Pelajaran</h3>
                    <form action="{{ route('guru.mapel.store') }}" method="POST">
                        @csrf
                        
                        <!-- Mata Pelajaran (Bisa Pilih dari List atau Ketik Baru) -->
                        <div class="mb-3">
                            <label class="block text-gray-700 text-xs font-bold mb-1">Mata Pelajaran</label>
                            <input type="text" name="mapel" list="list-mapel" required placeholder="Ketik atau pilih mata pelajaran..." class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <datalist id="list-mapel">
                                @isset($listMapel)
                                    @foreach($listMapel as $m)
                                        <option value="{{ $m->mapel }}">
                                    @endforeach
                                @endisset
                            </datalist>
                            <p class="text-[10px] text-gray-400 mt-1">Jika belum ada di pilihan, ketik nama mapel baru untuk otomatis ditambahkan ke database.</p>
                        </div>

                        <!-- Guru Pengajar (Bisa Ketik/Search atau Pilih) -->
                        <div class="mb-3">
                            <label class="block text-gray-700 text-xs font-bold mb-1">Guru Pengajar</label>
                            <select name="id_guru" required class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih atau cari Guru...</option>
                                @isset($listGuru)
                                    @foreach($listGuru as $guru)
                                        <option value="{{ $guru->id_guru }}">{{ $guru->nama }} ({{ ucfirst($guru->role) }})</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <!-- Pilih Tingkat -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-1">Tingkat</label>
                            <select name="tingkat" required class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Tingkat</option>
                                <option value="X">X (Sepuluh)</option>
                                <option value="XI">XI (Sebelas)</option>
                                <option value="XII">XII (Duabelas)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                            Simpan & Tugaskan Mapel
                        </button>
                    </form>
                </div>

                <!-- Import Mapel -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mt-6">
                    <h3 class="font-bold text-gray-800 text-base mb-2">📥 Import Mapel (Excel)</h3>
                    <p class="text-xs text-gray-500 mb-4">Header kolom Excel yang diperlukan: <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600 font-semibold">mapel</code>, <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600 font-semibold">guru</code>, <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600 font-semibold">tingkat</code></p>

                    <form action="{{ route('guru.mapel.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Pilih File Excel (.xlsx, .xls)</label>
                            <input type="file" name="file_excel" required accept=".xlsx, .xls, .csv" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-150">
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                            Import Mapel
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Tabel Daftar Mapel & Guru Pengampunya -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-gray-800 text-base mb-4">Daftar Guru Pengampu per Mata Pelajaran</h3>
                
                <div class="bg-white rounded border border-gray-200 overflow-hidden">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                            <tr>
                                <th class="p-3">Mata Pelajaran</th>
                                <th class="p-3">Guru Pengampu & Tingkat</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @isset($listMapelGuru)
                                @forelse($listMapelGuru as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 text-gray-800 font-medium align-top">📚 {{ $item->mapel->mapel ?? '-' }}</td>
                                        <td class="p-3 text-gray-700">
                                            <div class="flex items-center space-x-2 py-1">
                                                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs font-semibold border border-indigo-100">
                                                    {{ $item->tingkat }}
                                                </span>
                                                <span>👨‍🏫 {{ $item->guru->nama ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3 text-right align-top">
                                            <form action="{{ route('guru.mapel.destroy', $item->id_mapgur ?? 0) }}" method="POST" onsubmit="return confirm('Hapus penugasan guru ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-gray-400 text-xs italic">
                                            Belum ada penugasan guru pengampu mapel.
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-gray-400 text-xs italic">
                                        Belum ada data penugasan.
                                    </td>
                                </tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>