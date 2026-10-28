
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Ujian</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        h2, p {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #e5e7eb;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>LAPORAN NILAI UJIAN</h2>
    <p>{{ $sesi->judul }}</p>
    <p>
        Kategori: {{ $sesi->kategori }}
        | Tanggal: {{ $sesi->tgl_sesi }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Skor</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($listNilai as $nilai)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $nilai->siswa->nama ?? '-' }}</td>
                    <td>{{ $nilai->siswa->nisn ?? '-' }}</td>
                    <td>{{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="center">{{ $nilai->skor ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">
                        Belum ada data nilai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
