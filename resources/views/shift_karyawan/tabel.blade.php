<div class="table-responsive shift-karyawan-table-responsive">
    <table class="table table-hover table-bordered align-middle text-center mb-0 shift-karyawan-table">

        <thead class="table-light text-secondary shift-karyawan-table-head">
            <tr>
                <th class="shift-karyawan-name-column text-start px-3 py-3">
                    Nama Karyawan
                </th>

                @for($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                    <th class="shift-karyawan-date-column">
                        {{ $tgl }}
                    </th>
                @endfor
            </tr>
        </thead>

        <tbody class="shift-karyawan-table-body">

            @foreach($karyawan as $k)
                <tr class="shift-karyawan-row">

                    <td class="shift-karyawan-name text-start fw-semibold px-3 text-dark">
                        {{ $k->nama_karyawan }}
                    </td>

                    @for($tgl = 1; $tgl <= $jumlahHari; $tgl++)

                        @php
                            $tanggal = sprintf(
                                '%04d-%02d-%02d',
                                $tahun,
                                $bulan,
                                $tgl
                            );

                            $jadwal = $shift
                                ->where('karyawan_id', $k->id)
                                ->where('tanggal', $tanggal)
                                ->first();

                            $warna = '#ffffff';
                            $teks = '#333333';

                            if ($jadwal) {

                                if ($jadwal->shift == '1') {
                                    $warna = '#fff9c4';
                                    $teks = '#fbc02d';
                                }

                                elseif ($jadwal->shift == '2') {
                                    $warna = '#f5f5f5';
                                    $teks = '#616161';
                                }

                                elseif ($jadwal->shift == '3') {
                                    $warna = '#e3f2fd';
                                    $teks = '#1e88e5';
                                }

                                elseif ($jadwal->shift == 'OFF') {
                                    $warna = '#ffebee';
                                    $teks = '#e53935';
                                }
                            }
                        @endphp

                        <td
                            class="shift-karyawan-cell"
                            style="background: {{ $warna }}; color: {{ $teks }};"
                        >

                            @if($jadwal)

                                <button
                                    type="button"
                                    class="shift-edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditShift"
                                    data-karyawan-id="{{ $k->id }}"
                                    data-karyawan="{{ $k->nama_karyawan }}"
                                    data-shift="{{ $jadwal->shift }}"
                                    data-tanggal="{{ $tanggal }}"
                                >
                                    {{ $jadwal->shift }}
                                </button>

                            @endif

                        </td>

                    @endfor

                </tr>
            @endforeach

        </tbody>

    </table>
</div>