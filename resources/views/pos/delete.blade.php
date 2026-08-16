<div class="modal fade" id="modalDeleteMeja" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form id="formDeleteMeja" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-body text-center">
                <h5>Hapus meja?</h5>
                <p>Data tidak dapat dikembalikan.</p>
                <button class="btn btn-danger"> Hapus </button>
            </div>
        </form>
    </div>
</div>