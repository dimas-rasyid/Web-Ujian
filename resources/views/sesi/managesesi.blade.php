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
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold">No</th>
                                <th class="px-4 py-3 font-semibold">Judul / Mapel</th>
                                <th class="px-4 py-3 font-semibold">PJ / Guru</th>
                                <th class="px-4 py-3 font-semibold">Sesi & Waktu</th>
                                <th class="px-4 py-3 font-semibold">Token</th>
                                <th class="px-4 py-3 font-semibold">Kelas Peserta</th>
                                <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($listSesi as $index => $sesi)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <!-- Nomor -->
                                    <td class="px-4 py-3 text-slate-500">
                                        {{ $listSesi->firstItem() + $index }}
                                    </td>

                                    <!-- Judul & Mapel -->
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-slate-900">{{ $sesi->judul }}</div>
                                        <div class="text-xs text-indigo-600 font-medium mt-0.5">
                                            {{ optional($sesi->mapel)->mapel ?? '-' }}
                                        </div>
                                    </td>

                                    <!-- Guru PJ -->
                                    <td class="px-4 py-3">
                                        <div class="text-slate-900 font-medium">{{ optional($sesi->guru)->nama ?? '-' }}</div>
                                        <div class="text-xs text-slate-400 uppercase">{{ optional($sesi->guru)->role ?? '' }}</div>
                                    </td>

                                    <!-- Sesi & Waktu Pelaksanaan -->
                                    <td class="px-4 py-3">
                                        <div class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 mb-1">
                                            {{ $sesi->sesi }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            <div>📅 {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('d M Y') }}</div>
                                            <div>⏰ {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }} WIB</div>
                                        </div>
                                    </td>

                                    <!-- Token Ujian -->
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-mono font-bold bg-slate-100 text-slate-800 px-2 py-1 rounded text-xs tracking-wider border border-slate-200">
                                                {{ $sesi->token }}
                                            </span>
                                            <button type="button" onclick="salinToken('{{ $sesi->token }}', this)"
                                                class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-1.5 py-1 rounded hover:bg-indigo-50 transition" title="Salin Token">
                                                Salin
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Kelas Peserta (Many-to-Many via relasi kelas) -->
                                    <td class="px-4 py-3 max-w-xs">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($sesi->kelas as $k)
                                                <span class="bg-slate-100 text-slate-700 text-[11px] px-2 py-0.5 rounded-md border border-slate-200">
                                                    {{ $k->kelas }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Aksi (Edit & Hapus) -->
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Tombol Edit Sesi -->
                                            <a href="{{ route('guru.sesi.edit', $sesi->id_sesi) }}" class="text-slate-500 hover:text-indigo-600 p-1 rounded transition" title="Edit Sesi">
                                                ✏️
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('sesi.destroy', $sesi->id_sesi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sesi ujian ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 hover:text-red-600 p-1 rounded transition" title="Hapus Sesi">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-slate-400 italic">
                                        Belum ada sesi ujian yang terdaftar. Silakan buat sesi baru melalui tombol di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paging / Pagination links -->
                @if($listSesi->hasPages())
                    <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                        {{ $listSesi->links() }}
                    </div>
                @endif
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

                            <!-- Judul Ujian -->
                            <div x-data="{
                                    open: false,
                                    q: '{{ addslashes(old('judul')) }}',
                                    matches(judul) {
                                        return judul.includes(this.q.toLowerCase().trim());
                                    },
                                    noResult() {
                                        const items = this.$refs.list.querySelectorAll('li[data-judul]');
                                        const q = this.q.toLowerCase().trim();
                                        return items.length > 0 && ![...items].some(li => li.dataset.judul.includes(q));
                                    },
                                    pick(judul) {
                                        this.q = judul;
                                        this.open = false;
                                    },
                                    pickFirst() {
                                        const q = this.q.toLowerCase().trim();
                                        const first = [...this.$refs.list.querySelectorAll('li[data-judul]')]
                                            .find(li => li.dataset.judul.includes(q));
                                        if (first) this.pick(first.dataset.label);
                                    }
                                }"
                                @click.away="open = false"
                                @keydown.escape="open = false">

                                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Ujian</label>

                                <div class="relative">
                                    <input id="judul" type="text" name="judul" required autocomplete="off"
                                        x-model="q"
                                        @focus="open = true"
                                        @input="open = true"
                                        @keydown.enter="if (open && !noResult() && $refs.list.querySelector('li[data-judul]')) { $event.preventDefault(); pickFirst(); }"
                                        placeholder="Ketik judul baru atau pilih dari riwayat..."
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                                    <ul x-ref="list" x-show="open" x-cloak
                                        class="absolute left-0 right-0 top-full mt-1 z-50 max-h-48 overflow-y-auto bg-white border border-slate-300 rounded-lg shadow-lg py-1 text-sm">
                                        @isset($listBankSesi)
                                            @foreach($listBankSesi->pluck('judul')->filter()->unique() as $judulBank)
                                                <li data-judul="{{ strtolower($judulBank) }}"
                                                    data-label="{{ $judulBank }}"
                                                    x-show="matches($el.dataset.judul)"
                                                    @click="pick($el.dataset.label)"
                                                    class="px-3 py-2 cursor-pointer text-slate-700 hover:bg-indigo-50 hover:text-indigo-700">
                                                    {{ $judulBank }}
                                                </li>
                                            @endforeach
                                        @endisset

                                        <li x-show="noResult()" x-cloak class="px-3 py-2 text-slate-400 italic">
                                            Tidak ada riwayat yang cocok, judul baru akan dipakai
                                        </li>
                                    </ul>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1">Ketik manual secara bebas atau klik untuk memilih judul dari sesi yang sudah pernah dibuat.</p>
                            </div>

                            <!-- Mata Pelajaran -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-sm font-medium text-slate-700">Mata Pelajaran Ujian</label>
                                    <span class="text-xs text-slate-500"><span id="mapelCount">0</span> mapel dipilih</span>
                                </div>

                                <!-- Input Pencarian Mapel Sederhana -->
                                <input type="text" oninput="filterMapel(this.value)" placeholder="Cari mata pelajaran..."
                                    class="w-full px-3 py-1.5 mb-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                                <div class="border border-slate-200 rounded-lg max-h-44 overflow-y-auto p-3 bg-white">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="mapelContainer">
                                        @isset($listMapel)
                                            @foreach($listMapel as $mapel)
                                                <label data-mapel="{{ strtolower($mapel->mapel) }}"
                                                    class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer border border-slate-200 rounded-md px-2.5 py-1.5 hover:bg-indigo-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-300 transition">
                                                    <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id_mapel }}"
                                                        onchange="updateMapelCount()"
                                                        class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                                        {{ (is_array(old('mapel_ids')) && in_array($mapel->id_mapel, old('mapel_ids'))) ? 'checked' : '' }}>
                                                    <span class="font-medium">{{ $mapel->mapel }}</span>
                                                </label>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                                <p id="mapelError" class="hidden text-xs text-red-600 mt-1">Pilih minimal satu mata pelajaran.</p>
                            </div>

                            <!-- Guru Penanggung Jawab (PJ Sesi) -->
                            <div>
                                <label for="guru_id" class="block text-sm font-medium text-slate-700 mb-1">Guru Penanggung Jawab (PJ)</label>
                                <select id="guru_id" name="guru_id" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Guru Pengampu...</option>
                                    @isset($listGuru)
                                        @foreach($listGuru as $guru)
                                            <option value="{{ $guru->id_guru }}" {{ (old('guru_id') == $guru->id_guru) ? 'selected' : '' }}>
                                                {{ $guru->nama }} ({{ ucfirst($guru->role) }})
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <!-- Sesi dan Tgl -->
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

                            <!-- Jam Mulai- Selesai & Durasi -->
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

                            <!-- Token -->
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
                                                    {{-- Sesuaikan properti menjadi $kelas->kelas sesuai database terbaru --}}
                                                    <label data-kelas="{{ strtolower($kelas->kelas . ' ' . $namaJurusan) }}"
                                                        class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer border border-slate-200 rounded-md px-2 py-1.5 hover:bg-indigo-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-300 transition">
                                                        <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id_kelas }}"
                                                            onchange="updateKelasCount()"
                                                            class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                                            {{ (is_array(old('kelas_ids')) && in_array($kelas->id_kelas, old('kelas_ids'))) ? 'checked' : '' }}>
                                                        <span>{{ $kelas->kelas }} ({{ $kelas->tingkat }})</span>
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

        
        // ---------- Multiple Mapel ----------
        function updateMapelCount() {
            const checkboxes = document.querySelectorAll('input[name="mapel_ids[]"]:checked');
            document.getElementById('mapelCount').innerText = checkboxes.length;
        }

        function filterMapel(query) {
            const q = query.toLowerCase();
            const items = document.querySelectorAll('#mapelContainer label[data-mapel]');
            items.forEach(item => {
                const text = item.getAttribute('data-mapel');
                if (text.includes(q)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Jalankan saat halaman dimuat untuk menghitung state awal jika ada old()
        document.addEventListener('DOMContentLoaded', () => {
            updateMapelCount();
        });

        function cekFormSesi(event) {
            const kelasChecked = document.querySelectorAll('inputname="kelas_ids[]"]:checked').length;
            const mapelChecked = document.querySelectorAll('input[name="mapel_ids[]"]:checked').length;
            
            let isValid = true;

            if (mapelChecked === 0) {
                document.getElementById('mapelError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('mapelError').classList.add('hidden');
            }

            if (kelasChecked === 0) {
                document.getElementById('kelasError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('kelasError').classList.add('hidden');
            }

            if (!isValid) {
                event.preventDefault();
                alert('Harap pilih minimal satu Mata Pelajaran dan satu Kelas.');
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

            if (selectSesi && inputMulai && inputSelesai) {
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
            }
        });
    </script>
</body>
</html>