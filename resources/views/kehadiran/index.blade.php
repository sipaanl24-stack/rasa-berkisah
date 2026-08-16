@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/kehadiran.css') }}">

    <div class="kehadiran-header">
        <div>
            <h2>Daftar Kehadiran</h2>
            <p>Data absensi seluruh karyawan.</p>
        </div>
    </div>

    <div class="kehadiran-card">
        <div class="table-responsive">
            <table class="kehadiran-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $d->nama_karyawan }}</td>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->jam_masuk }}</td>
                            <td>{{ $d->jam_keluar ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada data kehadiran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous --}}
                <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}">&laquo;</a>
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
                        <a class="page-link" href="{{ $data->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                {{-- Next --}}
                <li class="page-item {{ !$data->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}">&raquo;</a>
                </li>

            </ul>
        </div>
    </div>

<script src="{{ asset('js/kehadiran.js') }}"></script>
@endsection