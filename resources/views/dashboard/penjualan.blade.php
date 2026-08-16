<div class="section-title"> Top 3 Produk Paling Laris </div>
<div class="table-container">
    @if($produkPalingLaris->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Total Terjual</th>
                    <th>Total Omzet</th>
                </tr>
            </thead>
            <tbody>
              @foreach($produkPalingLaris as $produk)
                    <tr>
                        <td>
                            @if($loop->index == 0)
                                🥇
                            @elseif($loop->index == 1)
                                🥈
                            @elseif($loop->index == 2)
                                🥉
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </td>

                        <td>{{ $produk->nama_makanan }}</td>
                        <td>{{ $produk->kategori }}</td>
                        <td>Rp {{ number_format($produk->harga) }}</td>
                        <td>{{ $produk->total_terjual }}</td>
                        <td>Rp {{ number_format($produk->total_omzet) }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p>Belum ada data penjualan.</p>
        </div>
    @endif
</div>