@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/supplier.css') }}">

<div class="inventory-content">
    <div class="top-bar">
        <div class="title">
            <h1>Permintaan Barang</h1>
            <p>Daftar permintaan barang dari kitchen.</p>
        </div>
    </div>
    <div class="filter-bar">
    <div class="filter-group">

        <select id="filterTanggal">
            <option value="">Semua Data</option>
            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>
                Hari Ini
            </option>
            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>
                Minggu Ini
            </option>
            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>
                Bulan Ini
            </option>
            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>
                Tahun Ini
            </option>
        </select>
    </div>
</div>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Kode Request</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($data as $kode => $items)
                    @include('supplier.row',[
                        'kode'=>$kode,
                        'items'=>$items
                    ])

                @empty
                    <tr>
                        <td colspan="4" class="empty-data"> Belum ada permintaan barang. </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-footer">
            <div class="table-info">
                Menampilkan
                <strong>{{ $kodeRequest->firstItem() ?? 0 }}</strong>
                -
                <strong>{{ $kodeRequest->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $kodeRequest->total() }}</strong>
                data
            </div>
            <div class="custom-pagination">
                @if($kodeRequest->onFirstPage())
                    <span class="page-btn disabled">‹</span>
                @else
                    <a class="page-btn" href="{{ $kodeRequest->previousPageUrl() }}">‹</a>
                @endif

                @for($i = 1; $i <= $kodeRequest->lastPage(); $i++)
                    <a href="{{ $kodeRequest->url($i) }}"
                       class="page-btn {{ $kodeRequest->currentPage() == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor
                @if($kodeRequest->hasMorePages())
                    <a class="page-btn" href="{{ $kodeRequest->nextPageUrl() }}">›</a>
                @else
                    <span class="page-btn disabled">›</span>
                @endif
            </div>
        </div>
    </div>
</div>
@include('supplier.modal-update')
<script src="{{ asset('js/supplier.js') }}"></script>
@endsection