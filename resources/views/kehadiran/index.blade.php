@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/kehadiran.css') }}">

{{-- ==================== HEADER ==================== --}}
<div class="kehadiran-header">
    <div>
        <h2>Daftar Kehadiran</h2>
        <p>Data absensi seluruh karyawan.</p>
    </div>
</div>


{{-- ==================== NAVIGASI TAB ==================== --}}
<div class="kehadiran-tabs">

    <a href="{{ route('kehadiran.index') }}"
       class="kehadiran-tab active">
        Kehadiran
    </a>

    <a href="{{ route('kehadiran.rekap') }}"
       class="kehadiran-tab">
        Rekap Kehadiran
    </a>

</div>


{{-- ==================== FILTER ==================== --}}
<div class="kehadiran-filter">

    <div class="filter-dropdown">

        <button type="button"
                class="filter-dropdown-btn"
                id="filterDropdownBtn">

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


        <div class="filter-dropdown-menu"
             id="filterDropdownMenu">

            <a href="{{ route('kehadiran.index') }}"
               class="{{ !request('tanggal') ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('kehadiran.index', [
                'tanggal' => now()->subDay()->format('Y-m-d')
            ]) }}"
               class="{{ request('tanggal') == now()->subDay()->format('Y-m-d') ? 'active' : '' }}">
                Kemarin
            </a>

            <a href="{{ route('kehadiran.index', [
                'tanggal' => now()->format('Y-m-d')
            ]) }}"
               class="{{ request('tanggal') == now()->format('Y-m-d') ? 'active' : '' }}">
                Hari Ini
            </a>

        </div>

    </div>


    <button type="button"
            class="calendar-btn"
            id="calendarBtn"
            title="Pilih tanggal">

        <i class="fas fa-calendar-alt"></i>

    </button>


    <input type="text"
           id="tanggalFilter"
           value="{{ request('tanggal') }}"
           hidden>

</div>


{{-- ==================== TABLE KEHADIRAN ==================== --}}
<div class="kehadiran-card">

    <div class="table-responsive">

        <table class="kehadiran-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                </tr>
            </thead>


            <tbody>

                @forelse($data as $d)

                    <tr>

                        <td>
                            {{ $data->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $d->nama_karyawan }}
                        </td>

                        <td>

                            <span class="role-badge role-{{ $d->role }}">
                                {{ ucfirst($d->role) }}
                            </span>

                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $d->jam_masuk ?? '-' }}
                        </td>

                        <td>
                            {{ $d->jam_keluar ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="empty">

                            Belum ada data kehadiran pada tanggal tersebut.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ==================== PAGINATION ==================== --}}
    @if($data->hasPages())

        <div class="pagination-wrapper">

            <ul class="pagination">

                <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">

                    @if($data->onFirstPage())

                        <span class="page-link">
                            &laquo;
                        </span>

                    @else

                        <a class="page-link"
                           href="{{ $data->previousPageUrl() }}">
                            &laquo;
                        </a>

                    @endif

                </li>


                @php

                    $current = $data->currentPage();
                    $last = $data->lastPage();

                    $start = max(1, $current - 1);
                    $end = min($last, $current + 1);

                    if ($current == 1) {
                        $end = min(3, $last);
                    }

                    if ($current == $last) {
                        $start = max(1, $last - 2);
                    }

                @endphp


                @for($i = $start; $i <= $end; $i++)

                    <li class="page-item {{ $i == $current ? 'active' : '' }}">

                        <a class="page-link"
                           href="{{ $data->url($i) }}">

                            {{ $i }}

                        </a>

                    </li>

                @endfor


                <li class="page-item {{ !$data->hasMorePages() ? 'disabled' : '' }}">

                    @if(!$data->hasMorePages())

                        <span class="page-link">
                            &raquo;
                        </span>

                    @else

                        <a class="page-link"
                           href="{{ $data->nextPageUrl() }}">
                            &raquo;
                        </a>

                    @endif

                </li>

            </ul>

        </div>

    @endif

</div>


{{-- ==================== FLATPICKR ==================== --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="{{ asset('js/kehadiran.js') }}"></script>

@endsection