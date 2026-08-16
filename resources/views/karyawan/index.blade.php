@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/karyawan.css') }}">
<div class="container">
    <div class="topbar">
        <h2>Data Karyawan</h2>
        <button class="btn btn-primary" onclick="openTambah()"> + Tambah Karyawan </button>
    </div>
    @include('karyawan.table')
</div>

@include('karyawan.create')
@include('karyawan.edit')
<script src="{{ asset('js/karyawan.js') }}"></script>
@endsection