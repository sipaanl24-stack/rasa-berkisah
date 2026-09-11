@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/kehadiran.css') }}">

{{-- ==================== HEADER ==================== --}}
<div class="kehadiran-header">
    <div>
        <h2>Rekap Kehadiran</h2>
        <p>Rekap jam kerja seluruh karyawan.</p>
    </div>
</div>


{{-- ==================== NAVIGASI TAB ==================== --}}
<div class="kehadiran-tabs">
    <a href="{{ route('kehadiran.index') }}" class="kehadiran-tab">
        Kehadiran
    </a>

    <a href="{{ route('kehadiran.rekap') }}" class="kehadiran-tab active">
        Rekap Kehadiran
    </a>
</div>


{{-- ==================== FILTER ==================== --}}
<div class="kehadiran-filter">
    <div class="filter-dropdown">
        <button type="button" class="filter-dropdown-btn" id="filterDropdownBtn">
            <span>
                @if(request('tanggal') == now()->format('Y-m-d'))
                    Hari Ini
                @elseif(request('tanggal') == now()->subDay()->format('Y-m-d'))
                    Kemarin
                @elseif(request('tanggal'))
                    {{ \Carbon\Carbon::parse(request('tanggal'))->format('d-m-Y') }}
                @else
                    Semua
                @endif
            </span>
            <i class="fas fa-chevron-down"></i>
        </button>

        <div class="filter-dropdown-menu"  id="filterDropdownMenu">
            <a href="{{ route('kehadiran.rekap') }}" class="{{ !request('tanggal') ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('kehadiran.rekap', [ 'tanggal' => now()->subDay()->format('Y-m-d') ]) }}"
               class="{{ request('tanggal') == now()->subDay()->format('Y-m-d') ? 'active' : '' }}">
                Kemarin
            </a>

            <a href="{{ route('kehadiran.rekap', [
                'tanggal' => now()->format('Y-m-d')
            ]) }}"
               class="{{ request('tanggal') == now()->format('Y-m-d') ? 'active' : '' }}">
                Hari Ini
            </a>

        </div>

    </div>


    <button type="button" class="calendar-btn" id="calendarBtn" title="Pilih tanggal">
        <i class="fas fa-calendar-alt"></i>
    </button>
    <input type="text" id="tanggalFilter" value="{{ request('tanggal') }}" hidden>
</div>


{{-- ==================== REKAP JAM KERJA ==================== --}}
<div class="kehadiran-card">
    <div class="table-responsive">
        <table class="kehadiran-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Total Jam Kerja</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jamKerja as $index => $item)
                    <tr>
                        <td>
                            {{ $index + 1 }}
                        </td>
                        <td>
                            {{ $item->nama_karyawan }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>
                        <td>
                            {{ $item->jam_masuk ?? '-' }}
                        </td>
                        <td>
                            {{ $item->jam_keluar ?? '-' }}
                        </td>
                        <td>

                            @if($item->status === 'Terlambat')
                                <span class="status-badge terlambat">
                                    Terlambat
                                </span>
                            @else
                                <span class="status-badge hadir">
                                    Hadir
                                </span>
                            @endif
                        </td>
                        <td>

                            @if($item->total_jam !== null)
                                {{ $item->total_jam }}
                                jam
                                {{ $item->total_menit }}
                                menit

                            @else

                                Belum selesai

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="empty">

                            Belum ada data jam kerja.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- ==================== FLATPICKR ==================== --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/kehadiran.js') }}"></script>
@endsection
