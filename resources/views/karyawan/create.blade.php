<div class="modal-bg" id="modalTambah">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Karyawan</h3>
            <button class="close-btn" onclick="closeTambah()"> × </button>
        </div>

        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div>
                    <label>Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div>
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div>
                    <label>Kontak</label>
                    <input type="text" name="kontak" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary"> Simpan </button>
                <button type="button" class="btn btn-secondary" onclick="closeTambah()"> Tutup </button>
            </div>
        </form>
    </div>
</div>