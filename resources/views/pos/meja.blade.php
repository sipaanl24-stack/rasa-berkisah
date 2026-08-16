@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
<div class="pos-management-page">
    <div class="pos-management-header">
        <div>
            <h2>Pengaturan Meja</h2>
            <p>Kelola meja yang digunakan pada sistem POS.</p>
        </div>
        <button type="button" class="pos-management-add-btn" onclick="openPosTableModal()"> + Tambah Meja </button>
    </div>

    <div class="pos-management-table-wrapper">
        <table class="pos-management-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Meja</th>
                    <th>Kapasitas</th>
                    <th>Area</th>
                    <th>Bentuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($meja as $m)
                    <tr>
                        <td> {{ $m->kode_meja }} </td>
                        <td> {{ $m->nama_meja }} </td>
                        <td> {{ $m->kapasitas }} Orang </td>
                        <td> {{ $m->area }} </td>
                        <td> {{ $m->bentuk }} </td>
                        <td>
                            @if($m->is_active)
                                <span class="pos-management-active"> Aktif </span>
                            @else
                                <span class="pos-management-inactive"> Nonaktif </span>
                            @endif
                        </td>
                        <td>
                            <div class="pos-management-actions">
                                <button type="button" onclick='editPosTable( @json($m)  )'> Edit </button>
                                @if($m->is_active)
                                    <form action="{{ route( 'pos.meja.destroy', $m->id ) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm( 'Nonaktifkan meja ini?' )"> Hapus </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="pos-management-empty"> Belum ada data meja. </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@push('modals')
    @include('pos.meja-modal')
@endpush
<script src="{{ asset('js/pos-meja.js') }}"></script>
@endsection