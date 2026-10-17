<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru & Admin - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-lg">Manajemen Guru & Admin - SMKS 2 PGRI Darjo</div>
        <a href="{{ route('guru.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded text-sm transition">
            Kembali ke Dashboard
        </a>
    </nav>

    <!-- MAIN -->
    <div class="max-w-6xl mx-auto mt-8 px-4 pb-12">
        
        <!-- Notif -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm shadow">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Form Tambah & Import Guru (Kiri) -->
            <div class="space-y-6">
                <!-- Form Tambah Guru Manual -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base mb-4">Akun Guru</h3>
                    <form action="{{ route('guru.manage.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Nama</label>
                            <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="masukkan nama untuk login" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Jurusan Terkait</label>
                            <select name="jurusan_id" required class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($listJurusan as $jurusan)
                                    <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Role / Hak Akses</label>
                            <select name="role" required class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="pengajar">Pengajar / Pengawas</option>
                                <option value="admin">Admin (Full Access)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-bold mb-2">Password Login</label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg text-sm transition">
                            Simpan Akun Guru
                        </button>
                    </form>
                </div>

                <!-- Form Tambahan: Import Data Guru via Excel -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base mb-2">Import Data Guru (Excel)</h3>
                    <p class="text-xs text-gray-500 mb-4">
                        Header kolom Excel: <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600">jurusan</code>, <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600">nama</code>, <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600">role</code>, <code class="bg-gray-100 px-1 py-0.5 rounded text-indigo-600">password</code>.<br>
                        <span class="italic text-gray-400">*Kosongkan kolom jurusan untuk otomatis masuk ke kategori "UMUM".</span>
                    </p>
                    
                    <form action="{{ route('guru.manage.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <input type="file" name="file_excel" required accept=".xlsx, .xls, .csv" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg text-sm transition">
                            Import Excel
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Guru & Pencarian (Kanan - 2 Kolom) -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">            
                        <!-- Form Pencarian -->
                        <form action="{{ route('guru.manageguru') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / jurusan..." class="px-3 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-64">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-1.5 rounded-lg text-sm transition">Cari</button>
                            @if(isset($search) && $search != '')
                                <a href="{{ route('guru.manageguru') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1.5 rounded-lg text-sm transition flex items-center">Reset</a>
                            @endif
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead class="bg-gray-50 border-b text-gray-600 text-xs uppercase">
                                <tr>
                                    <th class="p-3">No</th>
                                    <th class="p-3">Nama Guru</th>
                                    <th class="p-3">Jurusan</th>
                                    <th class="p-3">Role</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($listGuru as $index => $guru)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Menyesuaikan nomor urut agar tetap akurat lintas halaman pagination -->
                                        <td class="p-3 text-gray-500">{{ $listGuru->firstItem() + $index }}</td>
                                        <td class="p-3 font-semibold text-gray-800">{{ $guru->nama }}</td>
                                        <td class="p-3 text-gray-600 text-xs">{{ optional($guru->jurusan)->nama_jurusan ?? '-' }}</td>
                                        <td class="p-3">
                                            @if($guru->role === 'admin')
                                                <span class="bg-purple-100 text-purple-800 text-xs px-2.5 py-1 rounded font-bold">ADMIN</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded font-medium">PENGAJAR</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center">
                                            <form action="{{ route('guru.manage.destroy', $guru->id_guru) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun guru ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-xs bg-red-50 px-2 py-1 rounded">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-400 text-xs italic">
                                            Tidak ada data guru atau admin yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Navigasi Pagination -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $listGuru->links() }}
                </div>
            </div>

        </div>
    </div>
</body>
</html>