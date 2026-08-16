<div class="swiper kdsSwiper">
    <div class="swiper-wrapper">
        @forelse($pesanan as $item)
        <div class="swiper-slide">
            <div class="kds-card">
                <div class="kds-header">
                    <div>
                        <h4> {{ $item->nama_pelanggan ?: 'Tanpa Nama' }} </h4>
                        <span> {{ $item->kode_transaksi }} </span>
                    </div>
                    <div class="kds-status"> Menunggu Dapur </div>
                </div>
                        <div class="kds-body">
                            <div class="kds-info">
                            <strong>Waktu Pesan</strong>
                            <p> {{ $item->created_at->format('d-m-Y H:i:s') }} </p>
                        </div>
                    <div class="kds-menu">
                        <h5>Daftar Pesanan</h5>
                        <ul>
                            @foreach($item->detail as $detail)
                            <li>
                                <span class="menu-name"> {{ $detail->menu?->nama_makanan ?? 'Menu tidak ditemukan' }} </span>

                                <span class="menu-qty">
                                    {{ $detail->qty }}x
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <form action="{{ route('pesanan.selesai',$item->id) }}" method="POST" class="kds-form">
                        @csrf
                        <button type="submit" class="kds-finish-btn">
                            <i class="bi bi-check-circle-fill me-2"></i> Pesanan Selesai </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="swiper-slide">
            <div class="kds-empty">
                <i class="bi bi-cup-hot fs-1 mb-3"></i>
                <h4>Tidak Ada Pesanan</h4>
                <p>Semua pesanan telah selesai diproses.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>