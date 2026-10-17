<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jurusan & Kelas - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-lg">Manajemen Jurusan & Kelas - SMKS 2 PGRI Darjo</div>
        <a href="{{ route('guru.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded text-sm transition">
            Kembali ke Dashboard
        </a>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-6xl mx-auto mt-8 px-4 pb-12">
        
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Form Input Tambah (Kiri) -->
            <div class="space-y-6">
                <!-- Form Tambah Jurusan -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base mb-4">Tambah Jurusan Baru</h3>
                    <form action="{{ route('guru.jurusan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Nama Jurusan</label>
                            <input type="text" name="nama_jurusan" required placeholder="Contoh: Multimedia" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg text-sm transition">
                            Simpan Jurusan
                        </button>
                    </form>
                </div>

                <!-- Form Tambah Kelas -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base mb-4">Tambah Kelas Baru</h3>
                    <form action="{{ route('guru.kelas.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Pilih Jurusan</label>
                            <select name="jurusan_id" required class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($listJurusan as $jurusan)
                                    <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Nama Kelas</label>
                            <input type="text" name="nama_kelas" required placeholder="Contoh: XII MM 1" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg text-sm transition">
                            Simpan Kelas
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Data Jurusan & Kelas (Kanan - 2 Kolom) -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-gray-800 text-base mb-4">Daftar Jurusan & Kelas Terdaftar</h3>
                
                <div class="space-y-6">
                    @forelse($listJurusan as $jurusan)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-indigo-700 text-base">🏢 {{ $jurusan->nama_jurusan }}</h4>
                                <form action="{{ route('guru.jurusan.destroy', $jurusan->id_jurusan) }}" method="POST" onsubmit="return confirm('Hapus jurusan ini beserta semua kelas didalamnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold underline">Hapus Jurusan</button>
                                </form>
                            </div>

                            <!-- List Kelas di Jurusan Ini -->
                            <div class="bg-white rounded border border-gray-200 overflow-hidden">
                                <table class="w-full text-left border-collapse text-sm">
                                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                                        <tr>
                                            <th class="p-2.5">Nama Kelas</th>
                                            <th class="p-2.5 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($jurusan->kelas as $kelas)
                                            <tr class="hover:bg-gray-50">
                                                <td class="p-2.5 text-gray-800 font-medium">🏫 {{ $kelas->nama_kelas }}</td>
                                                <td class="p-2.5 text-right">
                                                    <form action="{{ route('guru.kelas.destroy', $kelas->id_kelas) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="p-3 text-center text-gray-400 text-xs italic">
                                                    Belum ada kelas pada jurusan ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 text-sm">
                            Belum ada data jurusan. Silakan tambahkan melalui form di samping.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</body>
</html>