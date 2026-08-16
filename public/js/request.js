function openForm() {
    document.getElementById('formRequest').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function closeForm() {
    document.getElementById('formRequest').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function addRow() {
    const tbody = document.getElementById('barangBody');

    const row = document.createElement('tr');
    row.classList.add('barang-row');

    row.innerHTML = `
        <td>
            <select name="kategori[]" required>
                <option value="">-- Pilih --</option>
                ${window.kategoriOptions || ''}
            </select>
        </td>

        <td>
            <input type="text" name="nama_bahan[]" required>
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
            <button type="button" onclick="removeRow(this)">Hapus</button>
        </td>
    `;

    tbody.appendChild(row);
}

function removeRow(btn) {
    const row = btn.closest('tr');

    const tbody = document.getElementById('barangBody');

    if (tbody.rows.length > 1) {
        row.remove();
    }
}

function tambahBaris(){

    let row = document.querySelector('.barang-row').cloneNode(true);

    row.querySelectorAll('input').forEach(function(input){
        input.value = '';
    });

    row.querySelectorAll('select').forEach(function(select){
        select.selectedIndex = 0;
    });

    document
        .getElementById('barangBody')
        .appendChild(row);

}

function hapusBaris(btn){

    let rows = document.querySelectorAll('.barang-row');

    if(rows.length > 1){

        btn.closest('tr').remove();

    }

}

function toggleDetail(kode){

    let row = document.getElementById('detail'+kode);

    if(row.style.display === 'table-row'){

        row.style.display = 'none';

    }else{

        row.style.display = 'table-row';

    }

}

document.addEventListener("DOMContentLoaded", function () {

    const tabs = document.querySelectorAll('.request-tabs .nav-link');

    // Saat tab diklik, simpan tab aktif
    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('request-active-tab', e.target.dataset.bsTarget);
        });
    });

    // Buka kembali tab terakhir
    const activeTab = localStorage.getItem('request-active-tab');

    if (activeTab) {
        const trigger = document.querySelector(
            `.request-tabs .nav-link[data-bs-target="${activeTab}"]`
        );

        if (trigger) {
            new bootstrap.Tab(trigger).show();
        }
    }

});