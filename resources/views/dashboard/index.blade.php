@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-container">
<div class="dashboard-header">
    <div>
        <h1>Dashboard POS</h1>
        <p>
            Selamat datang di dashboard
            Rasa Berkisah & Coffee Point
        </p>
    </div>

    <form method="GET" class="dashboard-filter">

        <select name="filter" class="form-select" onchange="this.form.submit()">
            <option value="today" {{ request('filter','today') == 'today' ? 'selected' : '' }}>  Hari Ini </option>
            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}> Minggu Ini </option>
            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}> Bulan Ini </option>
            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}> Tahun Ini </option>
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}> Semua </option>
        </select>
    </form>
</div>

    @include('dashboard.cards')
    @include('dashboard.penjualan')
    @include('dashboard.stok')
    @include('dashboard.kehadiran')
</div>

<script>
const grafikData = {
    labels: @json($grafikPenjualan['labels']),
    datasets: [{
        label: 'Penjualan (Rp)',
        data: @json($grafikPenjualan['data']),
        borderColor: '#3498db',
        backgroundColor: 'rgba(52,152,219,.1)',
        borderWidth: 2,
        fill: true,
        tension: .4,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: '#3498db',
        pointBorderColor: '#fff',
        pointBorderWidth: 2
    }]
};
</script>

<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection