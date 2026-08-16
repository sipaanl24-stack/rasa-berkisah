<div class="card-form" id="formRequest">
    <div class="card-header">
        <h3>Tambah Request</h3>
     <button type="button" class="close-btn" onclick="closeForm()"> &times; </button>
    </div>

    <form action="{{ route('request.store') }}" method="POST">
        @csrf
        <table class="barang-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="barangBody">
                <tr class="barang-row">
                    <td>
                        <input type="text" name="nama_bahan[]" required>
                    </td>

                    <td>
                        <select name="kategori[]" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item }}">
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="number" name="sisa_stock[]" required>
                    </td>

                    <td>
                        <select name="satuan[]" required>
                            <option value="Kg">Kg</option>
                            <option value="Gram">Gram</option>
                            <option value="Bungkus">Bungkus</option>
                            <option value="Liter">Liter</option>
                            <option value="Botol">Botol</option>
                            <option value="Pcs">Pcs</option>
                        </select>
                    </td>

                    <td>
                        <button type="button" class="btn-hapus" onclick="hapusBaris(this)"> 🗑 </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn-add-row" onclick="tambahBaris()"> + Tambah Barang </button>
        <div class="form-group">
            <h5>Tambah Catatan</h5>
            <textarea name="keterangan" placeholder="Keterangan request (berlaku untuk semua barang)"> </textarea>
        </div>
        <button type="submit"> Kirim Request </button>
    </form>
</div>