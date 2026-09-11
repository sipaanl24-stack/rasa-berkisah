<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kerja {{ $namaBulan }} {{ $tahun }}</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 17px;
        }

        .header p {
            margin: 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #999;
            text-align: center;
            vertical-align: middle;
            height: 26px;
            padding: 3px;
            overflow: hidden;
        }

        th {
            background: #f1f1f1;
            font-weight: bold;
        }

        .nama-karyawan {
            width: 125px;
            text-align: left;
            padding: 5px 7px;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.3;
            font-size: 8px;
        }

        .shift-1 {
            background: #fff9c4;
            color: #fbc02d;
            font-weight: bold;
        }

        .shift-2 {
            background: #f5f5f5;
            color: #616161;
            font-weight: bold;
        }

        .shift-3 {
            background: #e3f2fd;
            color: #1e88e5;
            font-weight: bold;
        }

        .shift-off {
            background: #ffebee;
            color: #e53935;
            font-weight: bold;
        }

        .keterangan {
            margin-top: 15px;
            font-size: 8px;
        }

        .keterangan-title {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .keterangan span {
            margin-right: 15px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>JADWAL KERJA KARYAWAN</h2>
        <p>{{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="nama-karyawan">Nama Karyawan</th>

                @for($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                    <th>{{ $tgl }}</th>
                @endfor
            </tr>
        </thead>

        <tbody>
            @foreach($karyawan as $k)
                <tr>
                    <td class="nama-karyawan">{{ $k->nama_karyawan }}</td>

                    @for($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                        @php
                            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tgl);
                            $jadwal = $shift
                                ->where('karyawan_id', $k->id)
                                ->where('tanggal', $tanggal)
                                ->first();
                        @endphp

                        @if($jadwal)
                            @switch($jadwal->shift)
                                @case('1')
                                    <td class="shift-1">P</td>
                                    @break

                                @case('2')
                                    <td class="shift-2">S</td>
                                    @break

                                @case('3')
                                    <td class="shift-3">M</td>
                                    @break

                                @case('OFF')
                                    <td class="shift-off">OFF</td>
                                    @break

                                @default
                                    <td>-</td>
                            @endswitch
                        @else
                            <td>-</td>
                        @endif
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="keterangan">
        <div class="keterangan-title">Keterangan:</div>
        <span>P = Shift Pagi</span>
        <span>S = Shift Siang</span>
        <span>M = Shift Malam</span>
        <span>OFF = Libur</span>
    </div>

</body>
</html>