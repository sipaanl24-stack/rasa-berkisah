<div class="section-title">  Kehadiran Karyawan Hari Ini </div>
<div class="table-container">
    @if($kehadiranHariIni->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kehadiranHariIni as $kehadiran)
                <tr>
                    <td>{{ $kehadiran->karyawan->nama_karyawan ?? 'N/A' }} </td>
                    <td> {{ $kehadiran->jam_masuk ?? '-' }} </td>
                    <td> {{ $kehadiran->jam_keluar ?? '-' }} </td>
                    <td>
                        @switch($kehadiran->status)
                           @case('Hadir')
                                <span class="badge-success"> ✓ Hadir </span>
                                @break
                            @case('Sakit')
                                <span class="badge-warning"> ⚕️ Sakit  </span>
                                @break
                            @case('Izin')
                                <span class="badge-warning"> 📋 Izin </span>
                                @break
                            @default
                                <span class="badge-danger"> ✗ Tidak Hadir </span>
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">  </div>
            <p> Belum ada data kehadiran hari ini. </p>
        </div>
    @endif
</div>