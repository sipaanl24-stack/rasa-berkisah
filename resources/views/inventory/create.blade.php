<div id="modalTambah" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Barang</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <form action="{{ url('/inventory/store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group full">
                    <label>Nama Bahan</label>
                    <input type="text" name="nama_bahan" placeholder="Masukkan nama bahan" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
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
                    <input type="number" name="stock" placeholder="Masukkan stock" required>
                </div>

                <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" required>
                        <option value="">-- Pilih Satuan --</option>
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
                    <input type="number" name="harga" placeholder="Masukkan harga" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="masuk" required>
                </div>

                <!-- <div class="form-group">
                    <label>Tanggal Expired</label>
                    <input type="date" name="expired" required>
                </div> -->
            </div>

            <button type="submit" class="btn submit-btn">
                Simpan Data
            </button>
        </form>
    </div>
</div>