// =========================
// MODAL TAMBAH
// =========================

function openTambah() {
    document.getElementById('modalTambah').style.display = 'flex';
}

function closeTambah() {
    document.getElementById('modalTambah').style.display = 'none';
}


// =========================
// MODAL DETAIL
// =========================

function openDetail(id) {
    document.getElementById('detail' + id).style.display = 'flex';
}

function closeDetail(id) {
    document.getElementById('detail' + id).style.display = 'none';
}


// =========================
// MODAL EDIT
// =========================

function openEdit(id) {
    document.getElementById('edit' + id).style.display = 'flex';
}

function closeEdit(id) {
    document.getElementById('edit' + id).style.display = 'none';
}


// =========================
// TAB DETAIL
// =========================

function showDetail(id) {

    document.getElementById('detailContent' + id)
        .classList.add('active');

    document.getElementById('resepContent' + id)
        .classList.remove('active');

    document.getElementById('detailBtn' + id)
        .classList.add('active');

    document.getElementById('resepBtn' + id)
        .classList.remove('active');
}

function showResep(id) {

    document.getElementById('resepContent' + id)
        .classList.add('active');

    document.getElementById('detailContent' + id)
        .classList.remove('active');

    document.getElementById('resepBtn' + id)
        .classList.add('active');

    document.getElementById('detailBtn' + id)
        .classList.remove('active');
}



// =========================
// OPTION BARANG
// =========================

function getBarangOptions(selected = null) {

    let option = '';

    daftarBarang.forEach(function (barang) {

        option += `
            <option value="${barang.barang_id}"
                ${selected == barang.barang_id ? 'selected' : ''}>
                ${barang.nama_bahan}
            </option>
        `;

    });

    return option;

}



// =========================
// TEMPLATE BAHAN
// =========================

function bahanTemplate(selected = null, jumlah = '') {

    return `
        <div class="bahan-box">

            <button
                type="button"
                class="hapus-bahan"
                onclick="hapusBahan(this)">
                ×
            </button>

            <div class="row">

                <div class="col-md-6">

                    <select
                        name="barang_id[]"
                        class="form-control">

                        ${getBarangOptions(selected)}

                    </select>

                </div>

                <div class="col-md-4">

                    <input
                        type="number"
                        name="jumlah_bahan[]"
                        class="form-control"
                        value="${jumlah}"
                        placeholder="Jumlah">

                </div>

            </div>

        </div>
    `;

}



// =========================
// TAMBAH BAHAN
// =========================

function tambahBahanTambah() {

    document
        .getElementById('bahanTambah')
        .insertAdjacentHTML(
            'beforeend',
            bahanTemplate()
        );

}

function tambahBahanEdit(id) {

    document
        .getElementById('bahanEdit' + id)
        .insertAdjacentHTML(
            'beforeend',
            bahanTemplate()
        );

}



// =========================
// DELETE
// =========================

function openDeleteModal(id)
{
    document.getElementById('modalDelete').style.display = 'flex';

    document.getElementById('deleteForm').action =
        '/menu/delete/' + id;
}

function closeDeleteModal() {

    document.getElementById('modalDelete')
        .style.display = 'none';

}



// =========================
// CLOSE MODAL
// =========================

window.onclick = function (event) {

    document.querySelectorAll('.modal-bg')
        .forEach(function (modal) {

            if (event.target === modal) {

                modal.style.display = 'none';

            }

        });

};



// =========================
// HAPUS BAHAN
// =========================

function hapusBahan(button) {

    button.closest('.bahan-box').remove();

}

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".category-btn");
    const cards = document.querySelectorAll(".menu-card");

    buttons.forEach(btn => {
        btn.addEventListener("click", function () {

            // aktif button
            buttons.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            const kategori = this.dataset.kategori;

            cards.forEach(card => {
                const itemKategori = card.dataset.kategori;

                if (kategori === "all" || itemKategori === kategori) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
});