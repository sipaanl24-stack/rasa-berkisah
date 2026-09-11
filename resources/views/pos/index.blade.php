@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">

@push('modals')
    @include('pos.create')
    @include('pos.edit')
    @include('pos.delete')
@endpush


<div class="kasir-workspace">

    {{-- ==================== NAVIGASI ==================== --}}
    @include('kasir.navigation')


    {{-- ==================== TOOLBAR POS ==================== --}}
    <div class="pos-toolbar">

        {{-- FILTER AREA --}}
        <div class="pos-area-filter">

            <button
                type="button"
                class="pos-area-btn active"
                data-area="all">
                Semua
            </button>

            <button
                type="button"
                class="pos-area-btn"
                data-area="Indoor">
                Indoor
            </button>

            <button
                type="button"
                class="pos-area-btn"
                data-area="Outdoor">
                Outdoor
            </button>

            <button
                type="button"
                class="pos-area-btn"
                data-area="VIP">
                VIP
            </button>

        </div>


        {{-- AKSI POS --}}
        <div class="pos-header-action">

            <button
                type="button"
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahMeja">
                + Tambah Meja
            </button>

            <button
                type="button"
                class="btn btn-warning"
                id="btnEditLayout">
                Edit Layout
            </button>

        </div>

    </div>


    {{-- ==================== LAYOUT MEJA ==================== --}}
    <div
        class="pos-floor-layout"
        id="posFloorLayout">

        @foreach($meja as $m)

            @php
                $transaksiAktif = $m->transaksi
                    ->whereIn('status', ['pending', 'selesai'])
                    ->first();
            @endphp


            {{-- ==================== MEJA ==================== --}}
            <div
                class="
                    pos-table-card
                    pos-shape-{{ $m->bentuk }}
                    {{ $transaksiAktif
                        ? 'pos-status-terisi'
                        : 'pos-status-kosong'
                    }}
                "

                data-id="{{ $m->id }}"
                data-url="{{ route('transaction.edit', $m->id) }}"
                data-nama="{{ $m->nama_meja }}"
                data-kapasitas="{{ $m->kapasitas }}"
                data-area="{{ $m->area }}"
                data-bentuk="{{ $m->bentuk }}"

                style="
                    left: {{ $m->posisi_x ?? 20 }}px;
                    top: {{ $m->posisi_y ?? 20 }}px;
                "
            >

                {{-- NAMA MEJA --}}
                <div class="pos-table-name">
                    {{ $m->nama_meja }}
                </div>


                {{-- INFORMASI MEJA --}}
                <div class="pos-table-info">
                    {{ $m->area }} | {{ $m->bentuk }}
                </div>


                {{-- STATUS MEJA --}}
                @if($transaksiAktif)

                    <div class="pos-table-customer">
                        {{ $transaksiAktif->nama_pelanggan ?: 'Tanpa Nama' }}
                    </div>

                @else

                    <div class="pos-table-status">
                        Tersedia
                    </div>

                @endif


                {{-- ==================== AKSI LAYOUT ==================== --}}
                <div class="pos-layout-action">

                    {{-- EDIT MEJA --}}
                    <button
                        type="button"
                        class="pos-edit-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditMeja"
                        onclick="event.stopPropagation();">

                        <i class="fas fa-pen"></i>

                    </button>


                    {{-- HAPUS MEJA --}}
                    <button
                        type="button"
                        class="pos-delete-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDeleteMeja"
                        onclick="event.stopPropagation();">

                        <i class="fas fa-trash"></i>

                    </button>

                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- ==================== JAVASCRIPT ==================== --}}
<script src="{{ asset('js/pos.js') }}"></script>

@endsection