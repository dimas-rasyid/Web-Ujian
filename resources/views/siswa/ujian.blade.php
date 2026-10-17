<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian: {{ $sesi->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 pb-20">

    <!-- Navbar Atas & Timer -->
    <header class="bg-indigo-600 text-white px-4 py-3 sticky top-0 z-40 shadow-md flex justify-between items-center">
        <div>
            <h1 class="font-bold text-xs sm:text-sm tracking-wide line-clamp-1">{{ $sesi->judul }}</h1>
            <p class="text-[10px] text-indigo-200">Siswa: {{ session('nama') }}</p>
        </div>
        <div class="bg-indigo-900/80 border border-indigo-400 px-3 py-1.5 rounded-xl text-center shadow-inner">
            <span class="block text-[9px] text-indigo-300 uppercase tracking-wider">Sisa Waktu</span>
            <span id="timerText" class="font-mono font-bold text-sm sm:text-base text-amber-300">--:--:--</span>
        </div>
    </header>

    <!-- Banner Peringatan Koneksi -->
    <div id="networkStatusBanner" class="hidden bg-amber-500 text-white text-center text-xs sm:text-sm font-bold py-2 px-4 shadow-md transition-all duration-300 sticky top-0 z-50 flex items-center justify-center gap-2">
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <span id="networkStatusText">Koneksi internet terputus! Jawaban sementara tersimpan di perangkat.</span>
    </div>

    <main class="max-w-2xl mx-auto mt-4 px-3">
        <form id="formUjian" action="{{ route('siswa.sesi.selesai', $sesi->id_sesi) }}" method="POST">
            @csrf

            <!-- Daftar Soal -->
            <div id="containerSoal">
                @foreach($listSoal as $index => $soal)
                    <div class="soal-card {{ $index === 0 ? '' : 'hidden' }} bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 mb-4" data-index="{{ $index }}">
                        
                        <div class="flex justify-between items-center mb-3 pb-2 border-b border-slate-100">
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-lg">
                                Soal No. {{ $index + 1 }} dari {{ $listSoal->count() }}
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                {{ $soal->tipe }}
                            </span>
                        </div>

                        <div class="text-sm sm:text-base font-medium text-slate-900 mb-4 leading-relaxed">
                            {!! nl2br(e($soal->pertanyaan)) !!}
                        </div>

                        @if($soal->tipe === 'Pilihan Ganda')
                            <div class="space-y-2.5">
                                @foreach($soal->opsi as $opsi)
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                        <!-- Tambahkan logika checked di bawah ini -->
                                        <input type="radio" 
                                            name="jawaban[{{ $soal->id_soal }}]" 
                                            value="{{ $opsi->kode_opsi }}"
                                            {{ (isset($jawabanSiswa[$soal->id_soal]) && $jawabanSiswa[$soal->id_soal] === $opsi->kode_opsi) ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        
                                        <span class="font-bold text-slate-700 w-5">{{ $opsi->kode_opsi }}.</span>
                                        <span class="text-xs sm:text-sm text-slate-800">{{ $opsi->teks_opsi }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div>
                                <textarea name="jawaban[{{ $soal->id_soal }}]" rows="5" placeholder="Tuliskan jawaban essay Anda di sini..." class="w-full p-3 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <!-- Tombol Navigasi Sebelumnya / Selanjutnya -->
            <div class="flex justify-between items-center gap-2 mb-6">
                <button type="button" id="btnSebelumnya" onclick="gantiSoal(-1)" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                    &larr; Sebelumnya
                </button>
                <button type="button" id="btnSelanjutnya" onclick="gantiSoal(1)" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition shadow-sm">
                    Selanjutnya &rarr;
                </button>
            </div>

            <!-- Grid Navigasi Nomor Soal -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 mb-6">
                <p class="text-xs font-bold text-slate-600 mb-2">Navigasi Nomor Soal:</p>
                <div class="grid grid-cols-6 sm:grid-cols-8 gap-1.5">
                    @foreach($listSoal as $i => $s)
                        <button type="button" onclick="pindahKeSoal({{ $i }})" id="nav-btn-{{ $i }}" 
                                class="nav-btn h-9 rounded-lg text-xs font-bold border border-slate-200 bg-slate-50 text-slate-700 hover:bg-indigo-50 transition"
                                data-soal-id="{{ $s->id_soal }}">
                            {{ $i + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Selesai -->
            <div class="text-center">
                <button type="button" onclick="konfirmasiSelesai()" class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold py-3.5 px-6 rounded-2xl text-sm transition shadow-md">
                    Akhiri & Kirim Ujian
                </button>
            </div>
        </form>
    </main>

    <script>
        let currentIndex = 0;
        const totalSoal = {{ $listSoal->count() }};
        let sisaDetik = {{ $sisaDetik }};
        const sesiId = "{{ $sesi->id_sesi }}";
        const siswaId = "{{ session('id_siswa') }}";
        const storageKey = `jawaban_ujian_${sesiId}_${siswaId}`;

        // Timer Ujian
        const timerInterval = setInterval(() => {
            if (sisaDetik <= 0) {
                clearInterval(timerInterval);
                localStorage.removeItem(storageKey); // Bersihkan storage saat waktu habis & kirim
                alert('Waktu ujian telah habis! Jawaban Anda akan dikirim otomatis.');
                document.getElementById('formUjian').submit();
                return;
            }

            sisaDetik--;
            let jam = Math.floor(sisaDetik / 3600);
            let menit = Math.floor((sisaDetik % 3600) / 60);
            let detik = sisaDetik % 60;

            document.getElementById('timerText').innerText = 
                String(jam).padStart(2, '0') + ':' + 
                String(menit).padStart(2, '0') + ':' + 
                String(detik).padStart(2, '0');
        }, 1000);

        function tampilkanSoal(index) {
            const cards = document.querySelectorAll('.soal-card');
            cards.forEach((card, idx) => {
                if (idx === index) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            document.getElementById('btnSebelumnya').disabled = (index === 0);
            
            const btnSelanjutnya = document.getElementById('btnSelanjutnya');
            if (index === totalSoal - 1) {
                btnSelanjutnya.classList.add('opacity-40');
            } else {
                btnSelanjutnya.classList.remove('opacity-40');
            }

            currentIndex = index;
        }

        function gantiSoal(arah) {
            let target = currentIndex + arah;
            if (target >= 0 && target < totalSoal) {
                tampilkanSoal(target);
            }
        }

        function pindahKeSoal(index) {
            tampilkanSoal(index);
        }

        // Simpan jawaban ke localStorage saat siswa memilih/mengetik
        function simpanKeLokal() {
            let dataJawaban = {};
            const inputs = document.querySelectorAll('#formUjian input[type="radio"]:checked, #formUjian textarea');
            
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    // Ambil id_soal dari nama input (misal: jawaban[5] -> ambil angka 5)
                    const match = input.name.match(/\[(.*?)\]/);
                    if (match && match[1]) {
                        dataJawaban[match[1]] = input.value;
                    }
                }
            });

            localStorage.setItem(storageKey, JSON.stringify(dataJawaban));
            updateNavigasiWarna();
        }

        // Auto-save ke server setiap 45 detik sekali di background
        setInterval(() => {
            const savedData = localStorage.getItem(storageKey);
            if (!savedData) return;

            // Kirim data secara silent di background menggunakan Fetch API
            fetch(`/siswa/sesi/${sesiId}/autosave`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ jawaban: JSON.parse(savedData) })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Autosave berhasil:', data);
            })
            .catch(error => {
                console.log('Koneksi terputus, jawaban tetap aman di localStorage.');
            });
        }, 45000); // 45000 ms = 45 detik

        // Muat kembali jawaban dari localStorage saat halaman dibuka/refresh
        function muatDariLokal() {
            const savedData = localStorage.getItem(storageKey);
            if (!savedData) return;

            try {
                let dataJawaban = JSON.parse(savedData);
                for (let soalId in dataJawaban) {
                    let val = dataJawaban[soalId];
                    // Cek radio button
                    let radio = document.querySelector(`input[name="jawaban[${soalId}]"][value="${val}"]`);
                    if (radio) {
                        radio.checked = true;
                    }
                    // Cek textarea
                    let textarea = document.querySelector(`textarea[name="jawaban[${soalId}]"]`);
                    if (textarea) {
                        textarea.value = val;
                    }
                }
            } catch (e) {
                console.error("Gagal memuat jawaban lokal", e);
            }
            updateNavigasiWarna();
        }

        // Perbarui warna tombol navigasi nomor soal
        function updateNavigasiWarna() {
            const navButtons = document.querySelectorAll('.nav-btn');
            const savedData = JSON.parse(localStorage.getItem(storageKey) || '{}');

            navButtons.forEach((btn, idx) => {
                const soalId = btn.getAttribute('data-soal-id');
                const isTerisi = savedData[soalId] && savedData[soalId].trim() !== '';

                if (isTerisi) {
                    btn.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200');
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                } else {
                    btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                    btn.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
                }
            });
        }

        // Event listener untuk memantau perubahan jawaban
        document.addEventListener('change', simpanKeLokal);
        document.addEventListener('input', simpanKeLokal);

        // Saat halaman pertama kali dimuat
        window.addEventListener('DOMContentLoaded', () => {
            muatDariLokal();
            tampilkanSoal(0);
        });

        function konfirmasiSelesai() {
            if (confirm('Apakah Anda yakin ingin mengakhiri dan mengirimkan jawaban ujian ini?')) {
                localStorage.removeItem(storageKey); // Bersihkan cache lokal saat ujian dikirim
                document.getElementById('formUjian').submit();
            }
        }


        // --- Deteksi Status Jaringan (Online / Offline) ---
        const banner = document.getElementById('networkStatusBanner');
        const statusText = document.getElementById('networkStatusText');

        function updateOnlineStatus() {
            if (!navigator.onLine) {
                // Ketika Offline / Putus Internet
                banner.classList.remove('hidden');
                banner.classList.remove('bg-emerald-600');
                banner.classList.add('bg-amber-500');
                statusText.innerText = 'Anda sedang offline! Jawaban tetap aman di perangkat.';
            } else {
                // Ketika Kembali Online
                statusText.innerText = 'Koneksi kembali terhubung! Menyinkronkan...';
                banner.classList.remove('bg-amber-500');
                banner.classList.add('bg-emerald-600'); // Berubah hijau sebentar
                
                // Sembunyikan banner setelah 3 detik terkoneksi normal
                setTimeout(() => {
                    banner.classList.add('hidden');
                }, 3000);
            }
        }

        // Pasang Event Listener untuk Online dan Offline
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Cek status saat halaman pertama kali dimuat
        window.addEventListener('DOMContentLoaded', () => {
            if (!navigator.onLine) {
                updateOnlineStatus();
            }
        });
    </script>
</body>
</html>