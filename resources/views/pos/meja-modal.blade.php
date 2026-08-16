<div class="pos-table-modal" id="posTableModal">
    <div class="pos-table-modal-content">
        <div class="pos-table-modal-header">
            <h3 id="posTableModalTitle"> Tambah Meja </h3>
            <button type="button" onclick="closePosTableModal()"> × </button>
        </div>
        <form id="posTableForm" method="POST" action="{{ route('pos.meja.store') }}">
            @csrf
            <div id="posTableMethod"></div>
            <div class="pos-table-form-group">
                <label>Kode Meja</label>
                <input type="text" name="kode_meja" id="posKodeMeja" required>
            </div>
            <div class="pos-table-form-group">
                <label>Nama Meja</label>
                <input type="text" name="nama_meja" id="posNamaMeja" required>
            </div>

            <div class="pos-table-form-group">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" id="posKapasitas" min="1" required>
            </div>

            <div class="pos-table-form-group">
                <label>Area</label>
                <select name="area" id="posArea" required>
                    <option value="Indoor"> Indoor </option>
                    <option value="Outdoor"> Outdoor </option>
                    <option value="VIP">VIP</option>
                </select>
            </div>

            <div class="pos-table-form-group">
                <label>Bentuk</label>
                <select name="bentuk" id="posBentuk" required>
                    <option value="square"> Persegi </option>
                    <option value="round"> Bulat </option>
                    <option value="rectangle"> Persegi Panjang </option>
                </select>
            </div>
            <button type="submit" class="pos-table-submit-btn"> Simpan </button>
        </form>
    </div>
</div>