<div class="modal-bg" id="edit{{ $m->menu_id }}">
    <div class="modal-card">
<div class="modal-header-custom">
    <h2>Edit Menu</h2>
    <div class="modal-action">
        <button class="close-btn" onclick="closeEdit({{ $m->menu_id }})"> &times; </button>
    </div>
</div>
        <form action="/menu/update/{{ $m->menu_id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Makanan</label>
                <input type="text" name="nama_makanan" class="form-control" value="{{ $m->nama_makanan }}">
            </div>
            <div class="form-group">
                <label>Profit</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" name="profit" class="form-control" value="{{ $m->profit }}">
                    </div>
                    <div class="col-md-4" style="display:flex;align-items:center;"> % </div>
                </div>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="Makanan Berat" {{ $m->kategori == 'Makanan Berat' ? 'selected' : '' }}> Makanan Berat </option>
                    <option value="Makanan Ringan" {{ $m->kategori == 'Makanan Ringan' ? 'selected' : '' }}> Makanan Ringan </option>
                    <option value="Minuman" {{ $m->kategori == 'Minuman' ? 'selected' : '' }}> Minuman </option>
                    <option value="Snack" {{ $m->kategori == 'Snack' ? 'selected' : '' }}> Snack </option>
                </select>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="form-group">
                <label>Bahan</label>
                <div id="bahanEdit{{ $m->menu_id }}">
                    @foreach($m->bahan as $bahan)
                        <div class="bahan-box">
                            <button type="button" class="hapus-bahan" onclick="hapusBahan(this)"> × </button>
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="barang_id[]" class="form-control">
                                        @foreach($barang as $b)
                                            <option value="{{ $b->barang_id }}"
                                                {{ $bahan->barang_id == $b->barang_id ? 'selected' : '' }}>
                                                {{ $b->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="jumlah_bahan[]" class="form-control" value="{{ $bahan->jumlah_bahan }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="tambahBahanEdit({{ $m->menu_id }})"> + Tambah Bahan </button>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Update </button>
            </div>
        </form>
    </div>
</div>