@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid pesanan-page">
    <div id="focusClock" class="focus-clock">
        00:00:00
    </div>
    <button id="focusModeBtn" class="focus-btn" title="Focus Mode">
        <i class="fa-solid fa-expand"></i>
    </button>
    <button id="exitFocusBtn" class="exit-focus-btn d-none" title="Keluar Focus Mode">
        <i class="fa-solid fa-compress"></i>
    </button>

<div id="focusClock" class="focus-clock d-none"></div>

    <h2 class="pesanan-title"> Kitchen Management </h2>
    <ul class="nav pesanan-tabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pesanan"> Daftar Pesanan </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#riwayat"> Riwayat Pesanan </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="pesanan">
            @include('pesanan.daftar')
        </div>
        <div class="tab-pane fade" id="riwayat">
            @include('pesanan.riwayat')
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('js/pesanan.js') }}"></script>
@endsection