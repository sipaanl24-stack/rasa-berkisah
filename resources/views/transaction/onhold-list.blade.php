<div class="transaction-search">
    <i class="fas fa-search"></i>
    <input type="text" id="searchOnhold" placeholder="Cari transaksi on hold...">
</div>
<table class="table table-bordered table-hover transaction-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Meja</th>
            <th>Pelanggan</th>
            <th>Waktu Pesan</th>
            <th>Total</th>
            <th>Status Pesanan</th>
            <th>Status Meja</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody id="onholdBody">
        @forelse($onhold as $trx)
            <tr>
                <td> {{ $trx->kode_transaksi }} </td>
                <td>
                    <span class="transaction-meja-badge">
                        {{ $trx->meja?->nama_meja ?? 'Meja belum ditentukan' }}
                    </span>
                </td>
                <td class="transaction-customer"> {{ $trx->nama_pelanggan }} </td>
                <td> {{ $trx->created_at->format('d-m-Y H:i') }} </td>
                <td>
                    <span class="transaction-total"> Rp {{ number_format($trx->total_harga,0,',','.') }} </span>
                </td>
                <td>
                    <div class="transaction-status-cell">
                        @if($trx->status == 'pending')
                            <span class="badge bg-warning text-dark"> Menunggu Dapur </span>
                        @elseif($trx->status == 'selesai')
                            <span class="badge bg-success"> Siap Dibayar </span>
                        @endif
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
                    <div class="transaction-action">
                        <a href="{{ url('/transaction/'.$trx->id) }}" class="transaction-open-btn"> Buka </a>
                        <form action="{{ url('/transaction/onhold/'.$trx->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transaction-delete-btn" onclick="return confirm('Hapus transaksi ini?')"> Hapus </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center"> Belum ada transaksi on hold. </td>
            </tr>
        @endforelse
    </tbody>
</table>
@if($onhold->hasPages())
<div class="transaction-pagination">
    @if($onhold->onFirstPage())
        <span class="page-btn disabled"> <i class="fas fa-chevron-left"></i> </span>
    @else
        <a href="{{ $onhold->previousPageUrl() }}" class="page-btn"> <i class="fas fa-chevron-left"></i> </a>
    @endif
    @for($i = 1; $i <= $onhold->lastPage(); $i++)
        <a href="{{ $onhold->url($i) }}" class="page-btn {{ $i == $onhold->currentPage() ? 'active' : '' }}"> {{ $i }} </a>
    @endfor
    @if($onhold->hasMorePages())
        <a href="{{ $onhold->nextPageUrl() }}" class="page-btn"> <i class="fas fa-chevron-right"></i> </a>
    @else
        <span class="page-btn disabled"> <i class="fas fa-chevron-right"></i> </span>
    @endif
</div>
@endif