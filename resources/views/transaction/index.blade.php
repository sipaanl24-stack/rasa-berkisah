@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
<div class="kasir-container">
    @include('transaction.menu')
    @include('transaction.form')
</div>

<script>
window.transactionData = {
    detail: @json($transaksi ? $transaksi->detail : [])
};
</script>

<script src="{{ asset('js/transaction.js') }}"></script>

@endsection