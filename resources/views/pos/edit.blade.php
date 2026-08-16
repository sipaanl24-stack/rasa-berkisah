<div class="modal fade" id="modalEditMeja" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEditMeja" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5>Edit Meja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">
                <div class="mb-3">
                    <label>Nama Meja</label>
                    <input type="text" id="edit_nama" name="nama_meja" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="number" id="edit_kapasitas" name="kapasitas" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Area</label>
                    <select id="edit_area" name="area" class="form-control">
                        <option>Indoor</option>
                        <option>Outdoor</option>
                        <option>VIP</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Bentuk</label>
                    <select id="edit_bentuk" name="bentuk" class="form-control">
                        <option value="kotak">Kotak</option>
                        <option value="bulat">Bulat</option>
                        <option value="persegi">Persegi Panjang</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary"> Update </button>
            </div>
        </form>
    </div>
</div>