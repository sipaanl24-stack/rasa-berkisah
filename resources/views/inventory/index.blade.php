@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="inventory-content">
    @include('inventory.create')
    @include('inventory.edit')
        <div class="title">
            <h1>Data Persediaan Bahan Masuk</h1>
                <div class="table-info">
                    <strong>{{ $data->total() }}</strong>
                    Total Bahan
                </div>
        </div><br>
        
    <div class="top-bar">
    <form id="filterForm" action="{{ url('/inventory') }}" method="GET" class="toolbar-form">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input id="searchInventory" type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." >
        </div>

        <select name="filter" id="quickFilter" class="filter-select">
            <option value="all" {{ $filter=='all' ? 'selected' : '' }}> Semua Data </option>
            <option value="today" {{ $filter=='today' ? 'selected' : '' }}> Hari Ini </option>
            <option value="week" {{ $filter=='week' ? 'selected' : '' }}> Minggu Ini </option>
            <option value="month" {{ $filter=='month' ? 'selected' : '' }}> Bulan Ini </option>
            <option value="year" {{ $filter=='year' ? 'selected' : '' }}> Tahun Ini </option>
        </select>

        <input type="text" id="dateRange" name="date_range" value="{{ request('date_range') }}" class="calendar-input">
        <button type="button" id="calendarBtn" class="calendar-btn">
            <i class="fas fa-calendar-alt"></i>
        </button>

        {{-- mempertahankan sorting --}}
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">

    </form>
    <button class="btn" onclick="openModal()"> + Tambah Barang  </button>
</div>
@include('inventory.table')
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="{{ asset('js/inventory.js') }}"></script>
@endsection