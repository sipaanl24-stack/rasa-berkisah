const transaksi = window.transactionData.detail || [];
const oldTransaksi = window.transactionData.oldDetail || [];
function tambahMenu(id, nama, harga)
{
    const empty = document.querySelector('.empty-cart');
    if (empty) {
        empty.remove();
    }
    const row = document.querySelector(
        `.transaksi-item[data-id="${id}"]`
    );

    // Jika menu sudah ada
    if (row)
    {
        const qtyInput = row.querySelector('.qty');
        qtyInput.value = parseInt(qtyInput.value) + 1;
        hitungTotal();
        updateButton(id, parseInt(qtyInput.value));
        return;
    }

    const html = `
        <div class="transaksi-item" data-id="${id}">
            <div class="item-info">
                <div class="item-nama"> ${nama} </div>
                <small> Rp ${harga.toLocaleString('id-ID')} </small>
                <input type="hidden" name="menu_id[]" value="${id}">
                <input type="hidden" name="harga[]" value="${harga}">
            </div>
            <input type="number" class="qty" name="qty[]" value="1" min="1">
            <div class="subtotal"> Rp ${harga.toLocaleString('id-ID')} </div>
            <button type="button" class="btn-hapus"> ✕ </button>
        </div> `;

    document
        .getElementById('tbody')
        .insertAdjacentHTML('beforeend', html);
    const newRow = document.querySelector(
        `.transaksi-item[data-id="${id}"]`
    );

    newRow
        .querySelector('.qty')
        .addEventListener('input', hitungTotal);
    newRow
        .querySelector('.btn-hapus')
        .addEventListener('click', function () {
            hapusItem(this);
        });
    hitungTotal();
    updateButton(id, 1);
}

function hapusItem(button)
{
    const row = button.closest('.transaksi-item');
    const menuId = row.dataset.id;
    row.remove();
    updateButton(menuId, 0);
    if(document.querySelectorAll('.transaksi-item').length === 0){
        document.getElementById('tbody').innerHTML = `
            <div class="empty-cart"> Belum ada menu dipilih </div> `;
    }
    hitungTotal();
}

function hitungTotal()
{
    let total = 0;
    document
        .querySelectorAll('.transaksi-item')
        .forEach(function (row) {
            const harga = parseInt( row.querySelector( 'input[name="harga[]"]' ).value ) || 0;
            const qty = parseInt( row.querySelector('.qty').value ) || 0;
            const subtotal = harga * qty;
            row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            total += subtotal;
        });

    document.getElementById('total').textContent = total.toLocaleString('id-ID');
    const bayar = parseInt( document.getElementById('bayar').value ) || 0;
    document.getElementById('kembalian').textContent = (bayar - total).toLocaleString('id-ID');
}

document
    .getElementById('bayar')
    .addEventListener('input', hitungTotal);
window.addEventListener('load', function () {
    const detail = oldTransaksi.length ? oldTransaksi : transaksi;

    if (!detail.length)
    {
        return;
    }

    detail.forEach(function (item) {
        if (!item.menu)
        {
            return;
        }
        tambahMenu(
            item.menu_id,
            item.menu.nama_makanan,
            item.harga
        );
        const row = document.querySelector( `.transaksi-item[data-id="${item.menu_id}"]`
        );
        if (row)
        {
            row.querySelector('.qty').value =
                item.qty;
        }
    });

    document
        .querySelectorAll('.qty')
        .forEach(function (input) {
            input.addEventListener(
                'input',
                hitungTotal
            );
        });
    hitungTotal();
});

function updateButton(menuId, qty){
    const btn = document.getElementById(`btn-menu-${menuId}`);
    if(!btn) return;
    if(qty > 0){
        btn.innerHTML = `Add More (${qty})`;
    }else{
        btn.innerHTML = `+ Tambah`;
    }
}

