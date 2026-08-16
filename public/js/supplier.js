const modal = document.getElementById("updateModal");
const form = document.getElementById("updateForm");

// dropdown detail request
function toggleDetail(kode){
    const row = document.getElementById("detail" + kode);

    if(row.style.display === "table-row"){
        row.style.display = "none";
    }else{
        row.style.display = "table-row";
    }
}

// tombol update
document.querySelectorAll(".update-btn").forEach(btn=>{

    btn.addEventListener("click",function(){

        form.action = "/suplai/update/" + this.dataset.id;

        let nama = this.dataset.nama.split("|");
        let kategori = this.dataset.kategori.split("|");
        let stock = this.dataset.stock.split("|");
        let satuan = this.dataset.satuan.split("|");

        let html = "";

        for(let i=0;i<nama.length;i++){

            html += `
                <tr>
                    <td>${nama[i]}</td>
                    <td>${kategori[i]}</td>
                    <td>${stock[i]} ${satuan[i]}</td>
                </tr>
            `;

        }

        document.getElementById("modalBarangBody").innerHTML = html;
        document.getElementById("modalKeterangan").textContent = this.dataset.keterangan;

        modal.classList.add("show");

    });

});

// tutup modal
document.querySelector(".close-modal").onclick=function(){

    modal.classList.remove("show");

}

modal.onclick=function(e){

    if(e.target===modal){
        modal.classList.remove("show");
    }

}

const filterTanggal = document.getElementById('filterTanggal');

filterTanggal.addEventListener('change', function () {

    let url = new URL(window.location.href);

    if (this.value) {
        url.searchParams.set('filter', this.value);
    } else {
        url.searchParams.delete('filter');
    }

    url.searchParams.delete('page');

    window.location.href = url.toString();
});

window.addEventListener('pageshow', function () {
    const navigation = performance.getEntriesByType('navigation')[0];

    if (navigation && navigation.type === 'reload') {
        window.location.href = window.location.pathname;
    }
});