@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
@push('modals')
    @include('pos.create')
    @include('pos.edit')
    @include('pos.delete')
@endpush

<div class="pos-header">
    <div>
        <h2>POS Meja</h2>
        <p>Pilih meja untuk memulai transaksi.</p>
    </div>

    <div class="pos-header-action">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahMeja"> + Tambah Meja </button>
        <button class="btn btn-warning" id="btnEditLayout"> Edit Layout </button>
    </div>
</div>

<div class="pos-area-filter">
    <button class="pos-area-btn active" data-area="all"> Semua </button>
    <button class="pos-area-btn" data-area="Indoor"> Indoor </button>
    <button class="pos-area-btn" data-area="Outdoor"> Outdoor </button>
    <button class="pos-area-btn" data-area="VIP">  VIP  </button>
</div>

<div class="pos-floor-layout" id="posFloorLayout">
    @foreach($meja as $m)
        @php
            $transaksiAktif = $m->transaksi
                ->whereIn('status', ['pending', 'selesai'])
                ->first();
        @endphp
    <div class="pos-table-card
        pos-shape-{{ $m->bentuk }}
        {{ $transaksiAktif ? 'pos-status-terisi' : 'pos-status-kosong' }}"
        data-id="{{ $m->id }}"
        data-url="{{ route('transaction.edit', $m->id) }}"
        data-nama="{{ $m->nama_meja }}"
        data-kapasitas="{{ $m->kapasitas }}"
        data-area="{{ $m->area }}"
        data-bentuk="{{ $m->bentuk }}"
        style="left: {{ $m->posisi_x ?? 20 }}px; top: {{ $m->posisi_y ?? 20 }}px;">
            <div class="pos-table-name">
                {{ $m->nama_meja }}
            </div>

            <div style="font-size:12px">
                {{ $m->area }} | {{ $m->bentuk }}
            </div>
            @if($transaksiAktif)
                <div class="pos-table-customer">
                    {{ $transaksiAktif->nama_pelanggan ?: 'Tanpa Nama' }}
                </div>
            @else
                <div class="pos-table-status">
                    Tersedia
                </div>
            @endif

            <div class="pos-layout-action">
                <button type="button" class="pos-edit-btn" data-bs-toggle="modal" data-bs-target="#modalEditMeja" onclick="event.stopPropagation();"> <i class="fas fa-pen"></i> </button>
                <button type="button" class="pos-delete-btn" data-bs-toggle="modal" data-bs-target="#modalDeleteMeja" onclick="event.stopPropagation();"> <i class="fas fa-trash"></i> </button>
            </div>
        </div>
    @endforeach
</div>
<script src="{{ asset('js/pos.js') }}"></script>
@endsection