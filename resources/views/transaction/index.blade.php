@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

<div class="kasir-workspace">

    @include('kasir.navigation')

    <div class="kasir-container">
        @include('transaction.menu')
        @include('transaction.form')
    </div>

</div>

<script>
window.transactionData = {
    detail: @json($transaksi ? $transaksi->detail : []),
    oldDetail: @json($oldDetail)
};
</script>

<script src="{{ asset('js/transaction.js') }}"></script>

@endsection