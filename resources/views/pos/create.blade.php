<div class="modal fade" id="modalTambahMeja" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form action="{{ route('pos.meja.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Meja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Area Meja</label>
                    <select name="area" class="form-select" required>
                        <option value="">-- Pilih Area --</option>
                        <option value="Indoor">Indoor</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Batal </button>
                <button type="submit" class="btn btn-primary"> Tambah </button>
            </div>
        </form>
    </div>
</div>