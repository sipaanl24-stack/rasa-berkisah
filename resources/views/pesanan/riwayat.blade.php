<div class="pesanan-history-container">
    <div class="history-header">
        <h3 class="history-title">Riwayat Pesanan</h3>
        <input type="text" id="searchHistory" class="history-search" placeholder="Cari pesanan...">
    </div>

    @if($riwayat->count() > 0)
        <div class="history-list">
            @foreach($riwayat as $item)
            <div class="history-item">
                <div class="history-item-top">
                    <div class="history-info">
                        <div class="history-code">{{ $item->kode_transaksi }}</div>
                        <div class="history-customer">{{ $item->nama_pelanggan }}</div>
                    </div>
                    <div class="history-meta">
                        <div class="history-time">{{ $item->created_at->format('d M Y') }}</div>
                        <div class="history-time-detail">{{ $item->created_at->format('H:i:s') }}</div>
                    </div>
                    <div class="history-status">
                        <span class="status-badge completed">Selesai</span>
                    </div>
                </div>

                <div class="history-items">
                    @foreach($item->detail as $detail)
                    <div class="history-item-detail">
                        <span class="item-name">{{ $detail->menu?->nama_makanan ?? 'Menu tidak ditemukan' }}</span>
                        <span class="item-qty">{{ $detail->qty }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="history-empty">
            <i class="bi bi-inbox"></i>
            <p>Belum ada riwayat pesanan</p>
        </div>
    @endif


</div>