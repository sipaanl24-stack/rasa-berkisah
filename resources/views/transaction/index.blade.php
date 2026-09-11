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
@if(session('print_id'))
<script>
    window.addEventListener('load', function () {

        const printId = @json(session('print_id'));

        const downloadUrl = "{{ url('/transaction/print') }}/" + printId;

        const link = document.createElement('a');

        link.href = downloadUrl;
        link.style.display = 'none';

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
    });
</script>
@endif

@endsection