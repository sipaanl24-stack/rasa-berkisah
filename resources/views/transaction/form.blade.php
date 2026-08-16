<div class="transaksi-section">
    <form action="/transaction/simpan" method="POST">
        @csrf
        @if($transaksi)
            <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
        @endif
        <div class="transaksi-card">
            <h3>Transaksi Berjalan</h3>
            <div class="transaksi-list">
                <div class="transaksi-list">
                <div id="tbody">
                    <div class="empty-cart">Belum ada menu dipilih</div>
                </div>
            </div>
            </div>

@if($mejaId)
    <input
        type="hidden"
        name="meja_id"
        value="{{ $mejaId }}"
    >
@endif

<div class="customer-group">

    <label>Nama Pelanggan</label>

    <input
        type="text"
        name="nama_pelanggan"
        class="input-bayar"
        placeholder="Contoh : Andi"
        value="{{ $transaksi->nama_pelanggan ?? '' }}"
    >

</div>

            <div class="total-box">
                <div class="total-row">
                    <span>Total</span>
                    <strong>Rp <span id="total">0</span></strong>
                </div>

                <input type="number" id="bayar" name="bayar" class="input-bayar" placeholder="Masukkan nominal bayar">
                <div class="total-row total-kembalian">
                    <span>Kembalian</span>
                    <strong>Rp <span id="kembalian">0</span></strong>
                </div>

                <button type="submit" name="status" value="pending" class="btn-simpan btn-pending"> Simpan Pesanan </button>
                <button type="submit" name="status" value="paid" class="btn-simpan"> Bayar </button>
            </div>
        </div>
    </form>
</div>