<div class="transaction-search">
    <i class="fas fa-search"></i>
    <input type="text" id="searchHistory" placeholder="Cari riwayat transaksi...">
</div>

<table class="table table-bordered table-hover transaction-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Daftar Pesanan</th>
            <th>Pelanggan</th>
            <th>Waktu Bayar</th>
            <th>Total</th>
            <th>Status Pesanan</th>
            <th width="170">Aksi</th>
        </tr>
    </thead>

    <tbody id="historyBody">
        @forelse($riwayat as $trx)
            <tr>
                <td>
                    {{ $trx->kode_transaksi }}
                </td>

                {{-- DAFTAR PESANAN --}}
                <td>
                    <div class="transaction-order-list">
                        @foreach($trx->detail as $detail)
                            <div class="transaction-order-item">
                                <span>
                                    {{ $detail->menu?->nama_makanan ?? 'Menu' }}
                                </span>
                                <span>
                                    x{{ $detail->qty }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </td>

                {{-- PELANGGAN --}}
                <td class="transaction-customer">
                    {{ $trx->nama_pelanggan ?: '-' }}
                </td>

                {{-- WAKTU BAYAR --}}
                <td>
                    {{ $trx->waktu_bayar
                        ? \Carbon\Carbon::parse($trx->waktu_bayar)->format('d-m-Y H:i')
                        : '-'
                    }}
                </td>

                {{-- TOTAL --}}
                <td>
                    <span class="transaction-total">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </span>
                </td>

                {{-- STATUS PESANAN --}}
                <td>
                    <div class="transaction-status-cell">
                        <span class="badge bg-success">
                            Paid
                        </span>
                    </div>
                </td>

                {{-- AKSI --}}
                <td>
                    <div class="transaction-action-group">

                        {{-- CETAK / DOWNLOAD STRUK PDF --}}
                        <a href="{{ route('transaction.print', $trx->id) }}"
                           class="transaction-print-btn">
                            <i class="fas fa-file-pdf"></i>
                            Struk PDF
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ url('/transaction/onhold/'.$trx->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="transaction-delete-btn"
                                    onclick="return confirm('Hapus riwayat transaksi ini?')">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7" class="text-center">
                    Belum ada riwayat transaksi.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($riwayat->hasPages())

<div class="transaction-pagination">

    @if($riwayat->onFirstPage())
        <span class="page-btn disabled">
            <i class="fas fa-chevron-left"></i>
        </span>
    @else
        <a href="{{ $riwayat->previousPageUrl() }}"
           class="page-btn">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif

    @for($i = 1; $i <= $riwayat->lastPage(); $i++)

        <a href="{{ $riwayat->url($i) }}"
           class="page-btn {{ $i == $riwayat->currentPage() ? 'active' : '' }}">
            {{ $i }}
        </a>

    @endfor

    @if($riwayat->hasMorePages())
        <a href="{{ $riwayat->nextPageUrl() }}"
           class="page-btn">
            <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <span class="page-btn disabled">
            <i class="fas fa-chevron-right"></i>
        </span>
    @endif

</div>

@endif