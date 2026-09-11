@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
<link rel="stylesheet" href="{{ asset('css/transaction-onhold.css') }}">

<div class="kasir-workspace">

    @include('kasir.navigation')

    <div class="transaction-content">
<!-- 
        <div class="transaction-header">

            <div>
                <h3 class="transaction-title">
                    Ditangguhkan
                </h3>

                <p class="transaction-subtitle">
                    Kelola transaksi yang ditangguhkan dan riwayat transaksi.
                </p>
            </div>

        </div> -->

        <div class="transaction-summary">

            <div class="transaction-summary-item">

                <span>On Hold</span>

                <h3>
                    {{ $onhold->total() }}
                </h3>

            </div>

            <div class="transaction-summary-item">

                <span>History</span>

                <h3>
                    {{ $riwayat->total() }}
                </h3>

            </div>

        </div>

        <div class="transaction-card">

            <ul class="nav nav-tabs transaction-tabs mb-4">

                <li class="nav-item">

                    <button
                        class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#onhold">

                        On Hold

                    </button>

                </li>

                <li class="nav-item">

                    <button
                        class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#history">

                        History

                    </button>

                </li>

            </ul>

            <div class="tab-content">

                <div
                    class="tab-pane fade show active"
                    id="onhold">

                    @include('transaction.onhold-list')

                </div>

                <div
                    class="tab-pane fade"
                    id="history">

                    @include('transaction.history-list')

                </div>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/transaction-onhold.js') }}"></script>

@endsection