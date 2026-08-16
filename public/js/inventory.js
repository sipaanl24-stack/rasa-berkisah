// ==========================
// MODAL TAMBAH
// ==========================

const modalTambah = document.getElementById('modalTambah');
function openModal(){
    modalTambah.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(){
    modalTambah.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// ==========================
// MODAL EDIT
// ==========================

function openEditModal(
    id,
    kode,
    nama,
    kategori,
    stock,
    satuan,
    harga,
    masuk,
    expired
){
    document.getElementById('modalEdit').style.display = 'block';
    document.getElementById('formEdit').action = '/inventory/update/' + id;
    document.getElementById('edit_kode').value = kode;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('edit_satuan').value = satuan;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_masuk').value = masuk;
    document.getElementById('edit_expired').value = expired;
    document.body.style.overflow = 'hidden';
}

function closeEditModal(){
    document.getElementById('modalEdit').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// ==========================
// TUTUP MODAL SAAT KLIK DI LUAR
// ==========================

window.onclick = function(event){
    if(event.target == modalTambah){
        closeModal();
    }
    if(event.target == document.getElementById('modalEdit')){
        closeEditModal();
    }
};

// ==========================
// TUTUP MODAL DENGAN ESC
// ==========================

document.addEventListener('keydown', function(e){
    if(e.key === "Escape"){
        closeModal();
        closeEditModal();
    }
});

const searchInput = document.getElementById("searchInventory");
if (searchInput) {
    let timer;
    searchInput.addEventListener("input", function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            document.getElementById("filterForm").submit();
        }, 400);
    });
}

const dateRange = document.getElementById("dateRange");
const calendarBtn = document.getElementById("calendarBtn");

if (dateRange) {
    const fp = flatpickr(dateRange, {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "id",
        onOpen: function() {
            // jika memakai kalender, dropdown kembali ke Semua
            document.getElementById("quickFilter").value = "all";
        },

        onClose: function(selectedDates, dateStr) {
            if (dateStr !== "") {
                document.getElementById("filterForm").submit();
            }
        }
    });

    calendarBtn.addEventListener("click", function () {
        fp.open();
    });
}

const quickFilter = document.getElementById("quickFilter");
if (quickFilter) {
    quickFilter.addEventListener("change", function () {
        // hapus kalender jika memakai dropdown
        document.getElementById("dateRange").value = "";
        document.getElementById("filterForm").submit();
    });
}

// ==========================
// RESET FILTER SAAT REFRESH
// ==========================
window.addEventListener("load", function () {
    const navigation = performance.getEntriesByType("navigation");
    if (navigation.length && navigation[0].type === "reload") {
        window.location.href = window.location.pathname;
    }
});