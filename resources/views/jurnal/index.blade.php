@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/jurnal.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<h4 class="page-title">Jurnal Umum</h4>
<div class="top-bar">

    <form id="filterForm" action="{{ url('/jurnal') }}" method="GET" class="toolbar-form">

        <select name="filter" id="quickFilter" class="filter-select">
            <option value="all" {{ $filter=='all' ? 'selected' : '' }}>Semua Data</option>
            <option value="today" {{ $filter=='today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="week" {{ $filter=='week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="month" {{ $filter=='month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="year" {{ $filter=='year' ? 'selected' : '' }}>Tahun Ini</option>
        </select>

        <input type="text" id="dateRange" name="date_range" value="{{ request('date_range') }}" class="calendar-input">
        <button type="button" id="calendarBtn" class="calendar-btn">
            <i class="fas fa-calendar-alt"></i>
        </button>

    </form>

</div>
<div class="jurnal-content">
    <div class="jurnal-card shadow">
        <div class="jurnal-body">
            <table class="jurnal-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Akun</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
<tbody>
    @forelse($jurnal as $item)
        <tr>
            <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
            <td>{{ $item->keterangan }}</td>
            <td>{{ $item->akun }}</td>
            <td>Rp {{ number_format($item->debit,0,',','.') }}</td>
            <td>Rp {{ number_format($item->kredit,0,',','.') }}</td>
        </tr>
    @empty
        <tr class="empty-row">
            <td colspan="5" class="empty-message">
                <i class="fas fa-folder-open"></i>
                <div class="empty-title">
                    Tidak ada catatan jurnal pada rentang waktu ini
                </div>
                <div class="empty-subtitle">
                    Coba pilih rentang tanggal atau filter yang berbeda.
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

                <tfoot>
                    <tr>
                        <th colspan="3">TOTAL</th>
                        <th id="totalDebit">
                            Rp {{ number_format($totalDebit,0,',','.') }}
                        </th>
                        <th id="totalKredit">
                            Rp {{ number_format($totalKredit,0,',','.') }}
                        </th>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="{{ asset('js/jurnal.js') }}"></script>
@endsection