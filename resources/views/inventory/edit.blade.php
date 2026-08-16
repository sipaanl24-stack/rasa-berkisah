<div id="modalEdit" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Barang</h3>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>

        <form id="formEdit" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" id="edit_kode" readonly>
                </div>

                <div class="form-group">
                    <label>Nama Bahan</label>
                    <input
                        type="text"
                        name="nama_bahan"
                        id="edit_nama"
                        required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select
                        name="kategori"
                        id="edit_kategori"
                        required>
                        <option value="Daging">Daging</option>
                        <option value="Rempah">Rempah</option>
                        <option value="Bakeri">Bakeri</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Sayur">Sayur</option>
                        <option value="Ikan">Ikan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stock</label>
                    <input
                        type="number"
                        name="stock"
                        id="edit_stock"
                        required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <select
                        name="satuan"
                        id="edit_satuan"
                        required>
                        <option value="Kg">Kg</option>
                        <option value="Gram">Gram</option>
                        <option value="Bungkus">Bungkus</option>
                        <option value="Liter">Liter</option>
                        <option value="Botol">Botol</option>
                        <option value="Pcs">Pcs</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input
                        type="number"
                        name="harga"
                        id="edit_harga"
                        required>
                </div>

                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input
                        type="date"
                        name="masuk"
                        id="edit_masuk"
                        required>
                </div>

                <div class="form-group">
                    <label>Tanggal Expired</label>
                    <input
                        type="date"
                        name="expired"
                        id="edit_expired"
                        required>
                </div>
            </div>

            <button type="submit" class="btn submit-btn">
                Update Data
            </button>
        </form>
    </div>
</div>