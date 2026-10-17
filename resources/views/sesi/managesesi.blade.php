<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sesi Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">

    <div x-data="{ openForm: {{ $errors->any() ? 'true' : 'false' }} }" @keydown.escape.window="openForm = false">

        {{-- Navbar --}}
        <nav class="bg-indigo-600 text-white border-b border-indigo-700 sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
                <div class="font-bold text-base">Manajemen sesi ujian</div>
                <a href="{{ route('guru.dashboard') }}"
                class="text-xs bg-indigo-700 hover:bg-indigo-800 text-white font-semibold rounded-lg px-3 py-1.5 transition">
                    Kembali ke dashboard
                </a>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-6 pb-12">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                    class="mb-4 flex items-start justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm">
                    <span>{{ session('success') }}</span>
                    <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900" aria-label="Tutup">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <div class="font-medium mb-1">Sesi belum tersimpan. Periksa isian berikut:</div>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Header halaman: pencarian + tombol tambah --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div>
                    <h1 class="text-lg font-semibold text-slate-900">Daftar sesi ujian</h1>
                    <p class="text-sm text-slate-500">{{ $listSesi->total() }} sesi terdaftar</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <form action="{{ route('sesi.managesesi') }}" method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau sesi"
                            class="w-full sm:w-64 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm transition">Cari</button>
                        @if(!empty($search))
                            <a href="{{ route('sesi.managesesi') }}"
                            class="border border-slate-300 hover:bg-slate-100 text-slate-700 px-3 py-2 rounded-lg text-sm transition flex items-center">Reset</a>
                        @endif
                    </form>

                    <button type="button" @click="openForm = true"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition shadow-sm">
                        Buat sesi ujian
                    </button>
                </div>
            </div>

            {{-- Tabel sesi --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[960px] text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-12">No</th>
                                <th class="px-4 py-3">Ujian</th>
                                <th class="px-4 py-3">Guru penanggung jawab</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3">Jadwal</th>
                                <th class="px-4 py-3">Token</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($listSesi as $index => $sesi)
                                @php
                                    $tgl     = \Carbon\Carbon::parse($sesi->tgl_sesi)->format('Y-m-d');
                                    $mulai   = \Carbon\Carbon::parse($tgl . ' ' . $sesi->waktu_mulai);
                                    $selesai = \Carbon\Carbon::parse($tgl . ' ' . $sesi->waktu_selesai);

                                    if (now()->lt($mulai)) {
                                        $status = ['Belum mulai', 'bg-slate-100 text-slate-600'];
                                    } elseif (now()->lte($selesai)) {
                                        $status = ['Berlangsung', 'bg-emerald-100 text-emerald-700'];
                                    } else {
                                        $status = ['Selesai', 'bg-slate-200 text-slate-500'];
                                    }

                                    $kelasSesi = $sesi->kelas;
                                @endphp
                                <tr class="hover:bg-slate-50 align-top">
                                    <td class="px-4 py-3 text-slate-400">{{ $listSesi->firstItem() + $index }}</td>

                                    <td class="px-4 py-3">
                                        <div class="font-medium text-slate-900">{{ $sesi->judul }}</div>
                                        <div class="mt-1 flex flex-wrap items-center gap-1.5 text-xs">
                                            <span class="text-slate-500">{{ $sesi->kategori ?? 'Umum' }}</span>
                                            <span class="bg-indigo-50 text-indigo-700 rounded px-1.5 py-0.5 font-medium">{{ $sesi->sesi }}</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ optional($sesi->guru)->nama ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($kelasSesi->take(3) as $k)
                                                <span class="bg-slate-100 text-slate-700 rounded px-1.5 py-0.5 text-xs">{{ $k->nama_kelas }}</span>
                                            @endforeach
                                            @if($kelasSesi->count() > 3)
                                                <span class="bg-slate-200 text-slate-600 rounded px-1.5 py-0.5 text-xs cursor-help"
                                                    title="{{ $kelasSesi->skip(3)->pluck('nama_kelas')->join(', ') }}">
                                                    +{{ $kelasSesi->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-xs text-slate-600 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $mulai->format('d/m/Y') }}</div>
                                        <div>{{ substr($sesi->waktu_mulai, 0, 5) }} - {{ substr($sesi->waktu_selesai, 0, 5) }}</div>
                                        <div class="text-slate-500">Durasi {{ $sesi->durasi }} menit</div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <button type="button" onclick="salinToken('{{ $sesi->token }}', this)"
                                                title="Klik untuk menyalin"
                                                class="font-mono font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded px-2 py-1 text-sm transition">
                                            {{ $sesi->token }}
                                        </button>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-medium {{ $status[1] }}">{{ $status[0] }}</span>
                                    </td>

                                    <td class="p-4 text-center space-x-1 flex justify-center items-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('sesi.edit', $sesi->id_sesi) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold px-2.5 py-1 rounded text-xs transition border border-amber-200">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus (yang sudah ada) -->
                                        <form action="{{ route('sesi.destroy', $sesi->id_sesi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sesi ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-2.5 py-1 rounded text-xs transition border border-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center">
                                        <div class="text-slate-600 text-sm">
                                            {{ !empty($search) ? 'Tidak ada sesi yang cocok dengan pencarian.' : 'Belum ada sesi ujian.' }}
                                        </div>
                                        @if(empty($search))
                                            <button type="button" @click="openForm = true"
                                                    class="mt-3 text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                                Buat sesi pertama
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan {{ $listSesi->firstItem() ?? 0 }} - {{ $listSesi->lastItem() ?? 0 }} dari {{ $listSesi->total() }} sesi
                    </div>
                    <div class="overflow-x-auto max-w-full">
                        {{ $listSesi->withQueryString()->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </main>

        {{-- Modal: form buat sesi --}}
        <div x-show="openForm" x-cloak class="fixed inset-0 z-40" role="dialog" aria-modal="true" aria-labelledby="judul-form">
            <div class="absolute inset-0 bg-slate-900/50" @click="openForm = false"></div>

            <div class="relative h-full flex items-start sm:items-center justify-center p-4 pointer-events-none">
                <div x-show="openForm" x-transition
                    class="pointer-events-auto bg-white w-full max-w-2xl max-h-full flex flex-col rounded-xl shadow-xl">

                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 id="judul-form" class="font-semibold text-slate-900">Buat sesi ujian</h2>
                        <button type="button" @click="openForm = false" class="text-slate-400 hover:text-slate-700 text-2xl leading-none" aria-label="Tutup">&times;</button>
                    </div>

                    <form action="{{ route('guru.sesi.store') }}" method="POST" onsubmit="return cekKelas(event)" class="flex flex-col min-h-0">
                        @csrf

                        <div class="px-6 py-5 overflow-y-auto space-y-4">

                            <div>
                                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul ujian</label>
                                <input id="judul" type="text" name="judul" required value="{{ old('judul') }}"
                                    placeholder="Contoh: UAS Pemrograman Web, Senin, 07.30"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori atau mapel</label>
                                    <input id="kategori" type="text" name="kategori" value="{{ old('kategori') }}"
                                        placeholder="Contoh: Produktif TKJ"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div class="mb-4">
                                    <label for="guru" class="block text-sm font-medium text-slate-700 mb-1">Guru penanggung jawab</label>
                                    <!-- Ubah name menjadi 'guru_nama_input' tanpa spasi, atau langsung simpan id -->
                                    <input id="guru" list="list-guru" name="guru_nama_input" required
                                        value="{{ old('guru_nama_input') }}" placeholder="Ketik nama guru"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <datalist id="list-guru">
                                        @foreach($listGuru as $guru)
                                            <option value="{{ $guru->nama }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="sesi" class="block text-sm font-medium text-slate-700 mb-1">Label sesi</label>
                                    <select id="sesi" name="sesi" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Pilih sesi</option>
                                        @foreach(['Sesi 1', 'Sesi 2', 'Sesi 3', 'Sesi Cadangan'] as $opt)
                                            <option value="{{ $opt }}" {{ old('sesi') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-slate-400 mt-1">Jam mulai dan selesai terisi otomatis.</p>
                                </div>

                                <div>
                                    <label for="tgl_sesi" class="block text-sm font-medium text-slate-700 mb-1">Tanggal pelaksanaan</label>
                                    <input id="tgl_sesi" type="date" name="tgl_sesi" required value="{{ old('tgl_sesi', date('Y-m-d')) }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                                <div>
                                    <label for="waktu_mulai" class="block text-sm font-medium text-slate-700 mb-1">Jam mulai</label>
                                    <input id="waktu_mulai" type="time" name="waktu_mulai" required value="{{ old('waktu_mulai') }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="waktu_selesai" class="block text-sm font-medium text-slate-700 mb-1">Jam selesai</label>
                                    <input id="waktu_selesai" type="time" name="waktu_selesai" required value="{{ old('waktu_selesai') }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="durasi" class="block text-sm font-medium text-slate-700 mb-1">Durasi (menit)</label>
                                    <input id="durasi" type="number" name="durasi" required min="1" value="{{ old('durasi', 90) }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <div>
                                <label for="tokenInput" class="block text-sm font-medium text-slate-700 mb-1">Token ujian</label>
                                <div class="flex gap-2 max-w-xs">
                                    <input id="tokenInput" type="text" name="token" required maxlength="10"
                                        value="{{ old('token', strtoupper(\Illuminate\Support\Str::random(5))) }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm font-mono font-bold uppercase bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="generateToken()"
                                            class="border border-slate-300 hover:bg-slate-100 text-slate-700 px-3 py-2 rounded-lg text-sm transition">Acak</button>
                                </div>
                            </div>

                            {{-- Picker kelas --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-sm font-medium text-slate-700">Kelas peserta</label>
                                    <span class="text-xs text-slate-500"><span id="kelasCount">0</span> kelas dipilih</span>
                                </div>

                                <input type="text" oninput="filterKelas(this.value)" placeholder="Cari kelas atau jurusan"
                                    class="w-full px-3 py-1.5 mb-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                                <div class="border border-slate-200 rounded-lg max-h-52 overflow-y-auto divide-y divide-slate-100">
                                    @php
                                        $kelasPerJurusan = $listKelas->groupBy(fn($k) => optional($k->jurusan)->nama_jurusan ?? 'Tanpa jurusan');
                                    @endphp

                                    @foreach($kelasPerJurusan as $namaJurusan => $kelasGroup)
                                        <div data-group class="p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-xs font-semibold text-slate-600">{{ $namaJurusan }}</span>
                                                <button type="button" onclick="toggleGroup(this)"
                                                        class="text-xs text-indigo-600 hover:text-indigo-700">Pilih semua</button>
                                            </div>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                @foreach($kelasGroup as $kelas)
                                                    <label data-kelas="{{ strtolower($kelas->nama_kelas . ' ' . $namaJurusan) }}"
                                                        class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer border border-slate-200 rounded-md px-2 py-1.5 hover:bg-indigo-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-300 transition">
                                                        <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id_kelas }}"
                                                            onchange="updateKelasCount()"
                                                            class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                                            {{ (is_array(old('kelas_ids')) && in_array($kelas->id_kelas, old('kelas_ids'))) ? 'checked' : '' }}>
                                                        <span>{{ $kelas->nama_kelas }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p id="kelasError" class="hidden text-xs text-red-600 mt-1">Pilih minimal satu kelas.</p>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl flex justify-end gap-2">
                            <button type="button" @click="openForm = false"
                                    class="border border-slate-300 hover:bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm transition">Batal</button>
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition shadow-sm">Simpan sesi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---------- Token ----------
        function generateToken() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let token = '';
            for (let i = 0; i < 5; i++) token += chars.charAt(Math.floor(Math.random() * chars.length));
            document.getElementById('tokenInput').value = token;
        }

        function salinToken(token, btn) {
            const selesai = () => {
                const asli = btn.textContent;
                btn.textContent = 'Tersalin';
                setTimeout(() => btn.textContent = asli, 1200);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(token).then(selesai);
            } else {
                // Cadangan untuk akses lewat http (jaringan lokal sekolah)
                const t = document.createElement('textarea');
                t.value = token;
                document.body.appendChild(t);
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                selesai();
            }
        }

        // ---------- Picker kelas ----------
        const semuaKelas = () => document.querySelectorAll('input[name="kelas_ids[]"]');

        function updateKelasCount() {
            const n = [...semuaKelas()].filter(c => c.checked).length;
            document.getElementById('kelasCount').textContent = n;
            if (n > 0) document.getElementById('kelasError').classList.add('hidden');
        }

        function toggleGroup(btn) {
            const grup = btn.closest('[data-group]');
            const boxes = [...grup.querySelectorAll('input[type=checkbox]')]
                .filter(b => b.closest('label').style.display !== 'none');
            const semuaTercentang = boxes.every(b => b.checked);
            boxes.forEach(b => b.checked = !semuaTercentang);
            updateKelasCount();
        }

        function filterKelas(q) {
            q = q.trim().toLowerCase();
            document.querySelectorAll('[data-group]').forEach(grup => {
                let tampil = 0;
                grup.querySelectorAll('label[data-kelas]').forEach(l => {
                    const cocok = l.dataset.kelas.includes(q);
                    l.style.display = cocok ? '' : 'none';
                    if (cocok) tampil++;
                });
                grup.style.display = tampil ? '' : 'none';
            });
        }

        function cekKelas(e) {
            const ada = [...semuaKelas()].some(c => c.checked);
            if (!ada) {
                document.getElementById('kelasError').classList.remove('hidden');
                return false;
            }
            return true;
        }

        // ---------- Jam otomatis per label sesi (tersimpan di browser) ----------
        const defaultJadwalSesi = {
            "Sesi 1":        { mulai: "07:30", selesai: "09:30" },
            "Sesi 2":        { mulai: "10:00", selesai: "12:00" },
            "Sesi 3":        { mulai: "13:00", selesai: "15:00" },
            "Sesi Cadangan": { mulai: "15:30", selesai: "17:30" }
        };

        function bacaJadwal(nama) {
            try { return JSON.parse(localStorage.getItem('custom_jadwal_' + nama)); }
            catch (e) { return null; }
        }

        function simpanJadwal(nama, data) {
            try { localStorage.setItem('custom_jadwal_' + nama, JSON.stringify(data)); }
            catch (e) { /* abaikan jika penyimpanan browser diblokir */ }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const selectSesi   = document.querySelector('select[name="sesi"]');
            const inputMulai   = document.querySelector('input[name="waktu_mulai"]');
            const inputSelesai = document.querySelector('input[name="waktu_selesai"]');

            updateKelasCount();

            selectSesi.addEventListener('change', function () {
                const nama = this.value;
                if (!nama) return;
                const jadwal = bacaJadwal(nama) || defaultJadwalSesi[nama];
                if (jadwal) {
                    inputMulai.value = jadwal.mulai;
                    inputSelesai.value = jadwal.selesai;
                }
            });

            function simpanJamTerakhir() {
                if (selectSesi.value) {
                    simpanJadwal(selectSesi.value, { mulai: inputMulai.value, selesai: inputSelesai.value });
                }
            }
            inputMulai.addEventListener('change', simpanJamTerakhir);
            inputSelesai.addEventListener('change', simpanJamTerakhir);
        });
    </script>
</body>
</html>