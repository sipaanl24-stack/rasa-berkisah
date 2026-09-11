@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/shift_karyawan.css') }}">
@endpush

@section('content')

<div class="container-fluid py-4 shift-karyawan-page">

    <div class="shift-karyawan-page-header mb-4">
        <h3 class="page-title fw-bold mb-0">
            Jadwal Shift Karyawan
        </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm shift-karyawan-alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm shift-karyawan-form-card">

        {{-- Filter + Tambah Shift + Download PDF --}}
        @include('shift_karyawan.filter')

        <div class="shift-karyawan-form-card-body">
            @include('shift_karyawan.tabel')
        </div>

    </div>

    @include('shift_karyawan.keterangan')

    @push('modals')
        @include('shift_karyawan.form')
    @endpush

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/shift_karyawan.js') }}"></script>
@endpush