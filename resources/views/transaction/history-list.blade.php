<div class="transaction-search">
    <i class="fas fa-search"></i>
    <input type="text" id="searchHistory" placeholder="Cari riwayat transaksi...">
</div>
<table class="table table-bordered table-hover transaction-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Meja</th>
            <th>Pelanggan</th>
            <th>Waktu Bayar</th>
            <th>Total</th>
            <th>Status Pesanan</th>
            <th>Status Meja</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody id="historyBody">
        @forelse($riwayat as $trx)
            <tr>
                <td>
                    {{ $trx->kode_transaksi }}
                </td>
                <td>
                    <span class="transaction-meja-badge">
                        {{ $trx->meja?->nama_meja ?? 'Meja belum ditentukan' }}
                    </span>
                </td>
                <td class="transaction-customer">
                    {{ $trx->nama_pelanggan }}
                </td>
                <td>
                    {{ $trx->waktu_bayar ? \Carbon\Carbon::parse($trx->waktu_bayar)->format('d-m-Y H:i') : '-' }}
                </td>

                <td>
                    <span class="transaction-total"> Rp {{ number_format($trx->total_harga, 0, ',', '.') }} </span>
                </td>

                <td>
                    <div class="transaction-status-cell">
                        <span class="badge bg-success"> Paid </span>
                    </div>
                </td>
                <td>
                    @php
                        $statusMeja = $trx->meja?->status ?? 'kosong';
                    @endphp
                    <span class="transaction-table-status {{ $statusMeja === 'kosong' ? 'status-kosong' : 'status-terisi' }}">
                        {{ $statusMeja === 'kosong' ? 'Kosong' : 'Terisi' }}
                    </span>
                </td>
                <td>
                    <form action="{{ url('/transaction/onhold/'.$trx->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="transaction-delete-btn" onclick="return confirm('Hapus riwayat transaksi ini?')"> Hapus </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center"> Belum ada riwayat transaksi. </td>
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
        <a href="{{ $riwayat->previousPageUrl() }}" class="page-btn">
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
        <a href="{{ $riwayat->nextPageUrl() }}" class="page-btn">
            <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <span class="page-btn disabled">
            <i class="fas fa-chevron-right"></i>
        </span>
    @endif

</div>

@endif