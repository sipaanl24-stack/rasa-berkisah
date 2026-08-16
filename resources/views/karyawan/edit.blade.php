<div class="modal-bg" id="modalEdit">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Edit Karyawan</h3>
            <button class="close-btn" onclick="closeEdit()"> × </button>
        </div>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div>
                    <label>Kode Karyawan</label>
                    <input type="text" name="kode_karyawan" id="edit_kode" readonly>
                </div>

                <div>
                    <label>Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" id="edit_nama" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" required>
                </div>

                <div>
                    <label>Role</label>
                    <select name="role" id="edit_role">
                        <option value="admin">Admin</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status" id="edit_status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div>
                    <label>Kontak</label>
                    <input type="text" name="kontak" id="edit_kontak" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary"> Update </button>
                <button type="button" class="btn btn-secondary" onclick="closeEdit()"> Tutup </button>
            </div>
        </form>
    </div>
</div>