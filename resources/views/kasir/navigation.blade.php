<div class="kasir-workspace-header">

    <!-- <div class="kasir-page-heading">
        <h2>Kasir</h2>
        <p>Kelola transaksi penjualan</p>
    </div> -->

    <div class="kasir-navigation">

        <a href="{{ route('transaction.index') }}"
           class="kasir-nav-item {{ request()->routeIs('transaction.index') || request()->routeIs('transaction.edit') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Transaksi</span>
        </a>

        <a href="{{ route('pos.index') }}"
           class="kasir-nav-item {{ request()->routeIs('pos.index') ? 'active' : '' }}">
            <i class="fas fa-chair"></i>
            <span>Meja</span>
        </a>

        <a href="{{ route('transaction.onhold') }}"
           class="kasir-nav-item {{ request()->routeIs('transaction.onhold') ? 'active' : '' }}">
            <i class="fas fa-pause-circle"></i>
            <span>Ditangguhkan</span>

            @if(isset($jumlahDitangguhkan) && $jumlahDitangguhkan > 0)
                <span class="kasir-nav-badge">
                    {{ $jumlahDitangguhkan }}
                </span>
            @endif
        </a>

    </div>

</div>