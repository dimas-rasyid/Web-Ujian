<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Ujian Sekolah</title>
    <!-- Tailwind CSS via CDN ringan -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-400 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Login Siswa Ujian</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.siswa') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">NISN</label>
                <input type="text" name="nisn" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan NISN">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Password">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition mb-4">Masuk Ujian</button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login.guru') }}" class="text text-gray-500 hover:text-blue-600 underline">Login khusus Guru / Pengawas</a>
        </div>
    </div>

</body>
</html>