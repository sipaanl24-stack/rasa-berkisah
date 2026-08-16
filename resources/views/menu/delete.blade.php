<div class="modal-bg" id="modalDelete">
    <div class="modal-card delete-card">

        <div class="delete-warning">
            <i class="fas fa-triangle-exclamation"></i>
        </div>

        <h3>Hapus Data?</h3>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <p>
                Apakah Anda yakin ingin menghapus data ini?<br><br>
                <strong>Data yang telah dihapus tidak dapat dikembalikan.</strong>
            </p>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                    Cancel
                </button>

                <button type="submit" class="btn btn-danger">
                    Hapus
                </button>
            </div>

        </form>
    </div>
</div>