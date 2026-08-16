@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
<div class="container">
    <div class="topbar">
        <div class="title">
            <h2>Daftar Menu</h2>
        </div>
        <button class="btn btn-primary" onclick="openTambah()"> + Tambah Menu </button>
    </div>
    <div class="category-filter">
        <button class="category-btn active" data-kategori="all">Semua</button>
        <button class="category-btn" data-kategori="Makanan">Makanan</button>
        <button class="category-btn" data-kategori="Minuman">Minuman</button>
        <button class="category-btn" data-kategori="Snack">Snack</button>
    </div>
    <div class="menu-grid">
        @foreach($menu as $m)
            <div class="menu-card" data-kategori="{{ $m->kategori }}">
                <div class="menu-image-box">
                    @if($m->gambar)
                        <img src="{{ asset('gambar/'.$m->gambar) }}" class="menu-image">
                    @else
                        <img src="https://via.placeholder.com/400x300" class="menu-image">
                    @endif
                    <button class="delete-icon" onclick="openDeleteModal('{{ $m->menu_id }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
               <div class="menu-content">
                <div class="menu-header">
                    <div class="menu-name"> {{ $m->nama_makanan }} </div>
                    <button class="detail-icon" onclick="openDetail({{ $m->menu_id }})">
                        <i class="fa-solid fa-circle-info"></i>
                    </button>
                </div>
                <div class="detail-sub"> {{ $m->kategori }} </div>
                <div class="menu-price"> Rp {{ number_format($m->harga) }} </div>
            </div>
            </div>

            {{-- Modal Detail --}}
            @include('menu.detail')
            {{-- Modal Edit --}}
            @include('menu.edit')
        @endforeach
    </div>
    {{-- Modal Delete --}}
    @include('menu.delete')
    {{-- Modal Tambah --}}
    @include('menu.tambah')
</div>
<script>
    const daftarBarang = @json($barang);
</script>

<script src="{{ asset('js/menu.js') }}"></script>
@endsection