@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/request.css') }}">
<div class="container">
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="request-header">
        <h3>Request</h3>
        <button class="btn-tambah" onclick="openForm()"> + Tambah Request </button>
    </div>
    {{-- Navbar Tab --}}
    <ul class="nav request-tabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#request"> Request </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#history"> Riwayat Request </button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- Request Pending --}}
        <div class="tab-pane fade show active" id="request">
            @include('request.table_request')
        </div>
        {{-- Riwayat --}}
        <div class="tab-pane fade" id="history">
            @include('request.history')
        </div>
    </div>
</div>
<div class="overlay" id="overlay" onclick="closeForm()"> </div>
@include('request.form')
<script src="{{ asset('js/request.js') }}"></script>
@endsection