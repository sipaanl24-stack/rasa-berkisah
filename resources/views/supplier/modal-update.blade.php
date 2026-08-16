<div class="modal-overlay" id="updateModal">
    <div class="modal-card">
        <button class="close-modal"> &times; </button>
        <h3>Update Permintaan</h3>
        <form id="updateForm" method="POST">
            @csrf
            <div class="table-wrapper">
                <table class="barang-modal-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="modalBarangBody">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="modal-keterangan-row">
                                <strong>Keterangan :</strong>
                                <span id="modalKeterangan">-</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value=""> Pilih Status </option>
                    <option value="diterima"> Disetujui </option>
                    <option value="ditolak"> Ditolak </option>
                </select>
            </div>
            <div class="form-group">
                <label>Catatan Supplier</label>
                <textarea name="keterangan_penolakan" rows="4" placeholder="Tambahkan catatan..."></textarea>
            </div>
            <button type="submit" class="save-btn">  Simpan Perubahan
            </button>
        </form>
    </div>
</div>