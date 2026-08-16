@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
<div class="pos-layout-page">
    <div class="pos-layout-header">
        <div>
            <h2>Layout Meja</h2>
            <p> Atur posisi meja untuk tampilan kasir dan kitchen. </p>
        </div>
        <button type="button" class="pos-layout-save-btn" onclick="savePosLayout()"> Simpan Posisi </button>
    </div>
    <div class="pos-layout-canvas" id="posLayoutCanvas">
        @foreach($meja as $m)
            <div class="pos-layout-table pos-shape-{{ $m->bentuk }}" data-id="{{ $m->id }}"  style="left: {{ $m->posisi_x ?? 20 }}px; top: {{ $m->posisi_y ?? 20 }}px;">
                <div class="pos-layout-table-name"> {{ $m->nama_meja }} </div>
                <div class="pos-layout-table-area"> {{ $m->area }} </div>
            </div>
        @endforeach
    </div>
</div>
<script src="{{ asset('js/pos-layout.js') }}"></script>
@endsection