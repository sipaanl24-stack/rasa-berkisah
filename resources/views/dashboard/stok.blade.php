<div class="stock-grid">
    <!-- Stok Menipis -->
    <div>
        <div class="section-title"> Stok Barang Menipis (&lt; 5) </div>
        <div class="table-container">
            @if($stokMenipis->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokMenipis as $barang)
                        <tr>
                            <td> {{ $barang->nama_bahan }} </td>
                            <td>
                                <span class="badge-warning"> {{ $barang->stock }} </span>
                            </td>
                            <td> {{ $barang->satuan }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon"> ✅ </div>
                    <p> Semua barang stoknya mencukupi </p>
                </div>
            @endif
        </div>
    </div>
    <!-- Stok Habis -->
    <div>
        <div class="section-title"> Stok Barang Habis </div>
        <div class="table-container">
            @if($stokHabis->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokHabis as $barang)
                        <tr>
                            <td> {{ $barang->nama_bahan }} </td>
                            <td> {{ $barang->kategori }} </td>
                            <td>
                                <span class="badge-danger">HABIS</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                    </div>
                    <p>Tidak ada barang yang habis</p>
                </div>
            @endif
        </div>
    </div>
</div>