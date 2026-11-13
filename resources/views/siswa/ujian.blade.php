<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian: {{ $sesi->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* [TAMBAHAN] Teks halaman tidak bisa diblok / disalin */
        body {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none; /* matikan menu tekan-lama di iPhone/iPad */
        }
        /* Kolom jawaban harus tetap bisa diketik (penting di iOS Safari) */
        textarea, input {
            -webkit-user-select: text;
            user-select: text;
        }
        /* Halaman kosong saat dicetak / disimpan sebagai PDF */
        @media print {
            body { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 pb-20">

    <!-- [TAMBAHAN] Layar penuh wajib (hanya tampil jika WAJIB_LAYAR_PENUH = true di script) -->
    <div id="overlayLayarPenuh" class="hidden fixed inset-0 z-[60] bg-slate-900/95 items-center justify-center p-6">
        <div class="bg-white rounded-2xl p-6 max-w-sm text-center shadow-xl">
            <h2 class="font-bold text-slate-900 mb-2">Mode Layar Penuh Diperlukan</h2>
            <p class="text-sm text-slate-600 mb-4">Ujian harus dikerjakan dalam mode layar penuh. Klik tombol di bawah untuk melanjutkan.</p>
            <button type="button" onclick="masukLayarPenuh()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                Masuk Layar Penuh
            </button>
        </div>
    </div>

    <!-- [TAMBAHAN] Kartu peringatan bertingkat (warna diatur lewat JavaScript) -->
    <div id="overlayPeringatan" class="hidden fixed inset-0 z-[70] items-center justify-center p-4">
        <div id="kartuPeringatan" class="w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border-4">
            <div id="kartuHeader" class="px-5 py-3 font-extrabold text-xs sm:text-sm tracking-wider"></div>
            <div class="px-5 py-4">
                <p id="kartuJudul" class="font-bold text-lg mb-1"></p>
                <p id="kartuPesan" class="text-sm leading-relaxed"></p>
                <p id="kartuDetail" class="text-xs mt-3 opacity-80"></p>
                <button id="kartuTombol" type="button" onclick="tutupPeringatan()" class="mt-4 w-full font-bold py-2.5 rounded-xl text-sm transition hover:opacity-90">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

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

    <!-- [TAMBAHAN] Peringatan aturan ujian (hapus blok ini jika tidak diperlukan) -->
    <div class="bg-red-50 border-b border-red-200 text-red-700 text-[11px] sm:text-xs text-center py-1.5 px-3">
        Meninggalkan halaman ujian dicatat sebagai pelanggaran. Setelah 3 peringatan, ujian diselesaikan otomatis.
        <span class="font-bold">(Peringatan: <span id="jumlahPelanggaranText">0</span> dari 3)</span>
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
                                <!-- [PERUBAHAN] isi textarea dari jawaban tersimpan di server -->
                                <textarea name="jawaban[{{ $soal->id_soal }}]" rows="5" placeholder="Tuliskan jawaban essay Anda di sini..." class="w-full p-3 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ $jawabanSiswa[$soal->id_soal] ?? '' }}</textarea>
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

        // [TAMBAHAN] Penanda ujian sudah dikirim, agar tidak terkirim/tersimpan dua kali
        const formUjian = document.getElementById('formUjian');
        let sudahSelesai = false;

        // [TAMBAHAN] Batas toleransi meninggalkan halaman, dihitung sepenuhnya di browser
        const BATAS_KELUAR_MS = 10000;                // 10 detik
        const leaveKey = `${storageKey}_left`;        // waktu siswa meninggalkan halaman (disimpan di localStorage)
        const pendingKey = `${storageKey}_pending`;   // ujian yang harus dikirim begitu internet kembali

        // [TAMBAHAN] Pencatatan pelanggaran ke server (disimpan di log)
        const urlPelanggaran = "{{ route('siswa.sesi.pelanggaran', $sesi->id_sesi) }}";
        const WAJIB_LAYAR_PENUH = false;   // ubah ke true untuk mewajibkan mode layar penuh
        const JEDA_LAPOR_MS = 3000;        // gangguan lebih singkat dari ini diabaikan (notifikasi sistem, dll.)
        let sedangDialog = false;          // true saat confirm() tampil agar tidak dianggap kehilangan fokus

        // [TAMBAHAN] Blokir salin / tempel / blok teks (ubah ke false untuk mematikan)
        const BLOKIR_SALIN_TEMPEL = true;

        // [TAMBAHAN] Sistem peringatan bertingkat
        const MAKS_PERINGATAN = 3;               // peringatan 1, 2, 3 (terakhir); pelanggaran berikutnya mengakhiri ujian
        const AKHIRI_JIKA_KELUAR_LAMA = true;    // true = keluar lebih dari BATAS_KELUAR_MS tetap langsung mengakhiri ujian
        const pelanggaranKey = `${storageKey}_pelanggaran`;
        // Ambil yang terbesar antara catatan browser dan catatan server, agar tidak bisa direset dengan menghapus data browser
        let jumlahPelanggaran = Math.max(
            parseInt(localStorage.getItem(pelanggaranKey) || '0', 10) || 0,
            {{ (int) ($jumlahPelanggaran ?? 0) }}
        );
        let sedangDiakhiri = false;              // true saat hitung mundur penyelesaian paksa berjalan

        // [PERUBAHAN] Timer dihitung dari jam sebenarnya, bukan dikurangi 1 per detik.
        // Browser memperlambat setInterval di tab yang tidak aktif, sehingga cara lama bisa melenceng.
        const deadlineMs = Date.now() + (sisaDetik * 1000);

        // Timer Ujian
        const timerInterval = setInterval(() => {
            sisaDetik = Math.max(0, Math.ceil((deadlineMs - Date.now()) / 1000));

            if (sisaDetik <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timerText').innerText = '00:00:00';
                // alert tidak muncul di tab yang sedang tidak aktif, jadi lewati jika tab disembunyikan
                if (!document.hidden) {
                    alert('Waktu ujian telah habis! Jawaban Anda akan dikirim otomatis.');
                }
                selesaikanSekarang('Waktu habis'); // [PERUBAHAN] aman jika sedang offline
                return;
            }

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
            if (sudahSelesai) return; // [TAMBAHAN]

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

        // Auto-save ke server (dibuat fungsi agar bisa dipanggil juga saat halaman ditinggalkan / internet kembali)
        function kirimAutosave(keepalive = false) {
            if (sudahSelesai) return;

            const savedData = localStorage.getItem(storageKey);
            if (!savedData) return;

            // Kirim data secara silent di background menggunakan Fetch API
            fetch(`/siswa/sesi/${sesiId}/autosave`, {
                method: 'POST',
                keepalive: keepalive,
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
        }

        // Auto-save ke server setiap 45 detik sekali di background
        setInterval(() => kirimAutosave(), 45000); // 45000 ms = 45 detik

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
            simpanKeLokal(); // [TAMBAHAN] gabungkan jawaban dari server + lokal, lalu warnai navigasi
            tampilkanSoal(0);

            // [TAMBAHAN] Ada ujian yang tertunda dikirim (karena offline saat harus selesai)?
            const tertunda = localStorage.getItem(pendingKey);
            if (tertunda) {
                if (navigator.onLine) {
                    kirimUjian(tertunda);
                } else {
                    tampilBannerTertunda();
                }
                return;
            }

            lapor('halaman_dimuat');
            inisialisasiLayarPenuh();

            // [TAMBAHAN] Tampilkan hitungan peringatan; jika sudah melebihi batas (mis. di-refresh saat hitung mundur), akhiri
            perbaruiInfoPelanggaran();
            if (jumlahPelanggaran > MAKS_PERINGATAN) {
                akhiriKarenaPelanggaran('Melebihi batas pelanggaran');
                return;
            }

            // [TAMBAHAN] Refresh -> selisihnya hanya beberapa detik, lanjut.
            // Menutup tab lalu membuka lagi setelah > 30 detik -> ujian diakhiri.
            periksaKembali();
        });

        function konfirmasiSelesai() {
            sedangDialog = true;
            const yakin = confirm('Apakah Anda yakin ingin mengakhiri dan mengirimkan jawaban ujian ini?');
            sedangDialog = false;

            if (yakin) {
                sudahSelesai = true; // [TAMBAHAN]
                localStorage.removeItem(storageKey); // Bersihkan cache lokal saat ujian dikirim
                localStorage.removeItem(pelanggaranKey);
                localStorage.removeItem(leaveKey);
                document.getElementById('formUjian').submit();
            }
        }

        // --- [TAMBAHAN] Mengakhiri ujian ---
        function kirimUjian(alasan = '') {
            if (sudahSelesai) return;
            sudahSelesai = true;
            clearInterval(timerInterval);
            localStorage.removeItem(storageKey);
            localStorage.removeItem(leaveKey);
            localStorage.removeItem(pendingKey);
            localStorage.removeItem(pelanggaranKey);

            if (alasan) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'alasan';
                input.value = alasan;
                formUjian.appendChild(input);
            }
            formUjian.submit();
        }

        // Jika offline, jangan submit (halaman akan error dan jawaban lokal ikut terhapus).
        // Tandai tertunda: jawaban tetap di perangkat, dikirim otomatis begitu internet kembali.
        function selesaikanSekarang(alasan) {
            if (sudahSelesai) return;

            if (!navigator.onLine) {
                localStorage.setItem(pendingKey, alasan);
                tampilBannerTertunda();
                return;
            }
            kirimUjian(alasan);
        }

        function tampilBannerTertunda() {
            banner.classList.remove('hidden');
            banner.classList.remove('bg-emerald-600');
            banner.classList.add('bg-amber-500');
            statusText.innerText = 'Ujian telah diakhiri, tetapi Anda offline. Jawaban akan dikirim otomatis begitu internet kembali.';
        }

        // --- [TAMBAHAN] Deteksi meninggalkan halaman (sepenuhnya di frontend) ---
        // Saat keluar: catat waktunya di localStorage + simpan jawaban terakhir ke server.
        // Saat kembali (tab aktif lagi, atau halaman dimuat ulang): hitung lamanya.
        function catatKeluar() {
            if (sudahSelesai) return;

            // Jangan timpa catatan yang lebih awal (visibilitychange dan pagehide bisa berurutan)
            if (!localStorage.getItem(leaveKey)) {
                localStorage.setItem(leaveKey, String(Date.now()));
            }

            simpanKeLokal();
            kirimAutosave(true); // keepalive: tetap terkirim walau halaman sedang ditutup
        }

        function periksaKembali() {
            if (sudahSelesai) return;

            const tercatat = parseInt(localStorage.getItem(leaveKey) || '0', 10);
            localStorage.removeItem(leaveKey);
            if (!tercatat) return;

            const lama = Date.now() - tercatat;
            if (AKHIRI_JIKA_KELUAR_LAMA && lama > BATAS_KELUAR_MS) {
                selesaikanSekarang(`Meninggalkan halaman lebih dari ${BATAS_KELUAR_MS / 1000} detik`);
            }
        }

        // Pindah tab / minimize / pindah aplikasi
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                catatKeluar();
            } else {
                periksaKembali();
            }
        });

        // Refresh / tutup tab / pindah halaman
        window.addEventListener('pagehide', catatKeluar);

        // Halaman dipulihkan dari cache browser (tombol back/forward) tanpa reload
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) periksaKembali();
        });

        // --- [TAMBAHAN] Pencatatan pelanggaran ke server ---
        // Hanya MELAPORKAN kejadian (disimpan di log); tidak mengubah aturan 30 detik di atas.
        // sendBeacon dipakai agar laporan tetap terkirim walau halaman sedang ditutup.
        function lapor(jenis, lamaMs = 0) {
            if (sudahSelesai) return;

            const data = new FormData();
            data.append('_token', '{{ csrf_token() }}');
            data.append('jenis', jenis);
            data.append('lama_ms', String(Math.round(lamaMs)));

            try {
                navigator.sendBeacon(urlPelanggaran, data);
            } catch (e) { /* abaikan */ }
        }

        // 1) Pindah tab / minimize / pindah aplikasi.
        //    Dilaporkan hanya jika berlangsung > 3 detik, sehingga refresh tidak ikut tercatat.
        let hiddenSejak = null;
        let hiddenDilaporkan = false;
        let timerHidden = null;

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                hiddenSejak = Date.now();
                clearTimeout(timerBlur); // blur akibat pindah tab tidak perlu dilaporkan dua kali
                timerHidden = setTimeout(() => {
                    if (document.visibilityState === 'hidden') {
                        hiddenDilaporkan = true;
                        lapor('tab_disembunyikan');
                        catatPelanggaran('Pindah tab / aplikasi');
                    }
                }, JEDA_LAPOR_MS);
            } else {
                clearTimeout(timerHidden);
                if (hiddenDilaporkan) {
                    lapor('tab_kembali', Date.now() - hiddenSejak);
                }
                hiddenSejak = null;
                hiddenDilaporkan = false;
            }
        });

        // 2) Kehilangan fokus padahal tab masih terlihat (split-screen, jendela lain di atasnya, dua monitor)
        let blurSejak = null;
        let blurDilaporkan = false;
        let timerBlur = null;

        window.addEventListener('blur', () => {
            if (sedangDialog || sudahSelesai) return;
            blurSejak = Date.now();
            timerBlur = setTimeout(() => {
                if (document.visibilityState === 'visible' && !document.hasFocus()) {
                    blurDilaporkan = true;
                    lapor('fokus_hilang');
                    catatPelanggaran('Kehilangan fokus jendela (split screen / jendela lain)');
                }
            }, JEDA_LAPOR_MS);
        });

        window.addEventListener('focus', () => {
            clearTimeout(timerBlur);
            if (blurDilaporkan) {
                lapor('fokus_kembali', Date.now() - blurSejak);
            }
            blurSejak = null;
            blurDilaporkan = false;
        });

        // 3) Halaman ditinggalkan (refresh atau tutup tab).
        //    Refresh: diikuti 'halaman_dimuat' beberapa detik kemudian. Tutup tab: tidak diikuti apa pun.
        window.addEventListener('pagehide', () => lapor('halaman_ditinggalkan'));

        // 4) Layar penuh
        let pernahLayarPenuh = false;
        const overlayLayarPenuh = document.getElementById('overlayLayarPenuh');
        const layarPenuhDidukung = !!document.documentElement.requestFullscreen; // iPhone/iOS Safari tidak mendukung

        function tampilkanOverlay(tampil) {
            overlayLayarPenuh.classList.toggle('hidden', !tampil);
            overlayLayarPenuh.classList.toggle('flex', tampil);
        }

        function masukLayarPenuh() {
            document.documentElement.requestFullscreen().catch(() => { /* ditolak browser */ });
        }

        function inisialisasiLayarPenuh() {
            if (WAJIB_LAYAR_PENUH && layarPenuhDidukung && !document.fullscreenElement) {
                tampilkanOverlay(true);
            }
        }

        document.addEventListener('fullscreenchange', () => {
            if (sudahSelesai) return;

            if (document.fullscreenElement) {
                pernahLayarPenuh = true;
                tampilkanOverlay(false);
            } else if (pernahLayarPenuh || WAJIB_LAYAR_PENUH) {
                lapor('layar_penuh_keluar');
                catatPelanggaran('Keluar dari mode layar penuh');
                if (WAJIB_LAYAR_PENUH && layarPenuhDidukung) tampilkanOverlay(true);
            }
        });

        // --- [TAMBAHAN] Sistem peringatan bertingkat ---
        // 1 = kuning, 2 = oranye, 3 = merah (terakhir), 4 = gelap (ujian diselesaikan paksa)
        const TEMA_PERINGATAN = {
            1: { bg: '#FEF9C3', border: '#FACC15', header: '#FACC15', headerText: '#422006', text: '#713F12',
                 label: 'PERINGATAN 1 DARI 3', judul: 'Peringatan Pertama',
                 pesan: 'Anda terdeteksi meninggalkan halaman ujian. Tetaplah berada di halaman ujian sampai selesai.' },
            2: { bg: '#FFEDD5', border: '#F97316', header: '#F97316', headerText: '#FFFFFF', text: '#7C2D12',
                 label: 'PERINGATAN 2 DARI 3', judul: 'Peringatan Kedua',
                 pesan: 'Ini pelanggaran kedua. Jika berulang, Anda akan menerima peringatan terakhir.' },
            3: { bg: '#FEE2E2', border: '#DC2626', header: '#DC2626', headerText: '#FFFFFF', text: '#7F1D1D',
                 label: 'PERINGATAN TERAKHIR (3 DARI 3)', judul: 'Peringatan Terakhir',
                 pesan: 'Pelanggaran berikutnya akan membuat ujian Anda diselesaikan otomatis.' },
            4: { bg: '#0F172A', border: '#000000', header: '#000000', headerText: '#FFFFFF', text: '#E2E8F0',
                 label: 'UJIAN DISELESAIKAN OTOMATIS', judul: 'Batas Pelanggaran Terlampaui',
                 pesan: 'Anda telah melebihi batas pelanggaran. Ujian diselesaikan otomatis dan jawaban Anda sedang dikirim.' }
        };

        function perbaikiInfoPelanggaranTeks() {
            return Math.min(jumlahPelanggaran, MAKS_PERINGATAN);
        }

        function perbaruiInfoPelanggaran() {
            const el = document.getElementById('jumlahPelanggaranText');
            if (el) el.innerText = perbaikiInfoPelanggaranTeks();
        }

        function tampilkanKartu(level, label) {
            const tema = TEMA_PERINGATAN[level];
            const overlay = document.getElementById('overlayPeringatan');
            const kartu = document.getElementById('kartuPeringatan');
            const header = document.getElementById('kartuHeader');
            const tombol = document.getElementById('kartuTombol');
            const terakhir = level > MAKS_PERINGATAN;

            kartu.style.backgroundColor = tema.bg;
            kartu.style.borderColor = tema.border;
            kartu.style.color = tema.text;

            header.style.backgroundColor = tema.header;
            header.style.color = tema.headerText;
            header.innerText = tema.label;

            document.getElementById('kartuJudul').innerText = tema.judul;
            document.getElementById('kartuPesan').innerText = tema.pesan;
            document.getElementById('kartuDetail').innerText =
                'Pelanggaran terdeteksi: ' + label +
                (terakhir ? '' : ' · Sisa peringatan: ' + (MAKS_PERINGATAN - level));

            tombol.style.backgroundColor = tema.header;
            tombol.style.color = tema.headerText;
            tombol.classList.toggle('hidden', terakhir); // kartu hitam tidak bisa ditutup

            overlay.style.backgroundColor = terakhir ? 'rgba(0,0,0,0.85)' : 'rgba(0,0,0,0.55)';
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function tutupPeringatan() {
            const overlay = document.getElementById('overlayPeringatan');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        // Dipanggil setiap kali pelanggaran terdeteksi
        function catatPelanggaran(label) {
            if (sudahSelesai || sedangDiakhiri) return;

            jumlahPelanggaran++;
            localStorage.setItem(pelanggaranKey, String(jumlahPelanggaran));
            perbaruiInfoPelanggaran();

            if (jumlahPelanggaran > MAKS_PERINGATAN) {
                akhiriKarenaPelanggaran(label);
            } else {
                tampilkanKartu(jumlahPelanggaran, label);
            }
        }

        function akhiriKarenaPelanggaran(label) {
            if (sudahSelesai || sedangDiakhiri) return;
            sedangDiakhiri = true;

            tampilkanKartu(MAKS_PERINGATAN + 1, label);

            // Beri waktu singkat agar siswa sempat membaca kartu, lalu kirim jawaban
            setTimeout(() => selesaikanSekarang('Melebihi batas pelanggaran (' + label + ')'), 4000);
        }

        // --- [TAMBAHAN] Blokir salin / tempel / blok teks ---
        if (BLOKIR_SALIN_TEMPEL) {
            // Salin, potong, tempel (termasuk di kolom jawaban essay)
            ['copy', 'cut', 'paste'].forEach(jenis => {
                document.addEventListener(jenis, (e) => e.preventDefault());
            });

            // Jaga-jaga untuk tempel / seret teks dari luar ke kolom jawaban
            document.addEventListener('beforeinput', (e) => {
                if (e.inputType === 'insertFromPaste' || e.inputType === 'insertFromDrop') {
                    e.preventDefault();
                }
            });
            document.addEventListener('drop', (e) => e.preventDefault());
            document.addEventListener('dragstart', (e) => e.preventDefault());

            // Klik kanan / menu tekan-lama
            document.addEventListener('contextmenu', (e) => e.preventDefault());

            // Blok teks dengan mouse atau sentuhan: hanya boleh di kolom jawaban
            document.addEventListener('selectstart', (e) => {
                const target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
                if (!target || !target.closest('textarea, input')) {
                    e.preventDefault();
                }
            });

            // Pintasan keyboard: Ctrl/Cmd + C, X, V, P, S, U, dan A (kecuali di kolom jawaban)
            document.addEventListener('keydown', (e) => {
                if (!(e.ctrlKey || e.metaKey)) return;

                const key = e.key.toLowerCase();
                const diKolomJawaban = e.target.closest && e.target.closest('textarea');

                if (['c', 'x', 'v', 'p', 's', 'u'].includes(key) || (key === 'a' && !diKolomJawaban)) {
                    e.preventDefault();
                }
            });
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
                // [TAMBAHAN] Ada ujian tertunda? Kirim sekarang.
                const tertunda = localStorage.getItem(pendingKey);
                if (tertunda) {
                    kirimUjian(tertunda);
                    return;
                }

                // Ketika Kembali Online
                statusText.innerText = 'Koneksi kembali terhubung! Menyinkronkan...';
                banner.classList.remove('bg-amber-500');
                banner.classList.add('bg-emerald-600'); // Berubah hijau sebentar

                kirimAutosave(); // [TAMBAHAN] benar-benar sinkronkan jawaban ke server
                
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