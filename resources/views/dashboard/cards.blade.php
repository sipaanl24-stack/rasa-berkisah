<div class="cards-grid">
    <!-- Total Order Minum -->
    <div class="card card-primary">
        <div class="card-label"> Total Order Minum </div>
        <div class="card-value"> {{ $totalOrderMinum }} </div>
        <div class="card-footer">
           {{ request('filter','today') == 'today' ? 'Hari Ini' : ucfirst(request('filter')) }}
        </div>
    </div>

    <!-- Laba Kotor -->
    <div class="card card-success">
        <div class="card-label"> Laba Kotor </div>
        <div class="card-value"> Rp{{ number_format($labaKotor, 0, ',', '.') }} </div>
        <div class="card-footer"> Total penjualan - HPP </div>
    </div>

    <!-- Laba Bersih -->
    <div class="card card-success">
        <div class="card-label"> Laba Bersih </div>
        <div class="card-value"> Rp{{ number_format($labaBersih, 0, ',', '.') }} </div>
        <div class="card-footer"> Setelah biaya operasional </div>
    </div>

    <!-- Total Transaksi -->
    <div class="card card-info">
        <div class="card-label"> Total transaksi </div>
        <div class="card-value"> {{ $totalTransaksi }} </div>
        <div class="card-footer"> {{ request('filter','today') == 'today' ? 'Hari Ini' : ucfirst(request('filter')) }} </div>
    </div>

</div>