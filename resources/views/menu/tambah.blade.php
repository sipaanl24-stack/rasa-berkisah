<div class="modal-bg" id="modalTambah">
    <div class="modal-card">
<div class="modal-header-custom">
    <h2>Tambah Menu</h2>
    <div class="modal-action">
        <button class="close-btn" onclick="closeTambah()"> &times; </button>
    </div>
</div>
        <form action="/menu/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_makanan" class="form-control">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option>Makanan Berat</option>
                    <option>Makanan Ringan</option>
                    <option>Minuman</option>
                    <option>Snack</option>
                </select>
            </div>
            <div class="form-group">
                <label>Profit (%)</label>
                <input type="number" name="profit" class="form-control">
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="form-group">
                <label>Bahan</label>
                <div id="bahanTambah"></div>
            </div>

            <button type="button" class="btn btn-secondary" onclick="tambahBahanTambah()"> + Tambah Bahan </button>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Simpan </button>
            </div>
        </form>
    </div>
</div>