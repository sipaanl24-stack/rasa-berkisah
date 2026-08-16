let editing = false;
/*
|--------------------------------------------------------------------------
| OPEN TABLE
|--------------------------------------------------------------------------
*/

function openTable(card) {
    if (editing) {
        return;
    }
    const url = card.dataset.url || `/transaction/${card.dataset.id}`;
    if (url) {
        window.location.href = url;
    }
}

window.openTable = openTable;
document.addEventListener('DOMContentLoaded', function () {
    /* |--------------------------------------------------------------------------
    | FILTER AREA
    |-------------------------------------------------------------------------- */

    document.querySelectorAll('.pos-area-btn')
    .forEach(function(button){
        button.addEventListener('click', function(){
            document.querySelectorAll('.pos-area-btn')
            .forEach(function(btn){
                btn.classList.remove('active');
            });

            this.classList.add('active');
            const area = this.dataset.area;
            document.querySelectorAll('.pos-table-card')
            .forEach(function(card){
                if(area === 'all'){
                    card.style.display = '';
                }else{
                    card.style.display =
                    card.dataset.area === area
                    ? ''
                    : 'none';
                }
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | MODE EDIT LAYOUT
    |--------------------------------------------------------------------------
    */

    const btnLayout = document.getElementById('btnEditLayout');
    if(btnLayout){
        btnLayout.addEventListener('click', function(){
            if(editing){
                saveLayoutPositions();
                return;
            }

            editing = true;
            document.body.classList.add(
                'pos-editing'
            );
            this.innerHTML = 'Selesai Edit';
        });
    }

    /* |--------------------------------------------------------------------------
    | EDIT MEJA
    |-------------------------------------------------------------------------- */

    document.querySelectorAll('.pos-edit-btn') .forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.stopPropagation();
            const card = this.closest('.pos-table-card');
            if(!card) return;
            document.getElementById('edit_nama').value = card.dataset.nama;
            document.getElementById('edit_kapasitas').value = card.dataset.kapasitas;
            document.getElementById('edit_area').value = card.dataset.area;
            document.getElementById('edit_bentuk').value = card.dataset.bentuk;
            document.getElementById('formEditMeja').action = '/pos/meja/' + card.dataset.id;

            new bootstrap.Modal( document.getElementById('modalEditMeja') ).show();
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE MEJA
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.pos-delete-btn') .forEach(function(btn){
        btn.addEventListener('click', function(e){ e.stopPropagation();
            if(!confirm('Hapus meja ini?')){
                return;
            }

            document.getElementById('formDeleteMeja').action = '/pos/meja/' + this.closest('.pos-table-card').dataset.id;
            document.getElementById('formDeleteMeja') .submit();
        });
    });

    /*
    |--------------------------------------------------------------------------
    | CLICK TABLE
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.pos-table-card') .forEach(function(card){
        card.style.zIndex = 10;
        card.addEventListener('click', function(event){
            if(editing){
                return;
            }

            if(event.target.closest('.pos-layout-action')){
                return;
            }
            openTable(card);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | CLEANUP BOOTSTRAP MODAL BACKDROP
    |--------------------------------------------------------------------------
    */

    function cleanupModalBackdrop(){
        document.querySelectorAll('.modal-backdrop') .forEach(function(el){
            el.remove();
        });

        document.body.classList.remove(
            'modal-open'
        );
    }

    cleanupModalBackdrop();
    document.querySelectorAll('.modal') .forEach(function(modal){
        modal.addEventListener(
            'hidden.bs.modal',
            cleanupModalBackdrop
        );
    });

    /*
    |--------------------------------------------------------------------------
    | DRAG LAYOUT MEJA
    |--------------------------------------------------------------------------
    */

    let selectedTable = null;
    let offsetTableX = 0;
    let offsetTableY = 0;

    document.querySelectorAll('.pos-table-card') .forEach(function(table){
        table.addEventListener( 'mousedown',
            function(event){
                if (!editing) {
                    return;
                }
                if (event.target.closest('.pos-layout-action')) {
                    return;
                }
                selectedTable = this;
                const rect = this.getBoundingClientRect();
                offsetTableX = event.clientX - rect.left;
                offsetTableY = event.clientY - rect.top;
                this.style.zIndex = 100;
                this.classList.add('dragging');
                event.preventDefault();
                event.stopPropagation();
            }
        );
    });

    document.addEventListener( 'mousemove',
        function(event){
            if(!selectedTable){
                return;
            }

            const canvas = document.getElementById( 'posFloorLayout'
            );

            if(!canvas){
                return;
            }
            const canvasRect = canvas.getBoundingClientRect();
            let x = event.clientX -  canvasRect.left - offsetTableX;
            let y = event.clientY - canvasRect.top -  offsetTableY;
            const maxX =  canvas.clientWidth - selectedTable.offsetWidth;
            const maxY = canvas.clientHeight - selectedTable.offsetHeight;

            x = Math.max(
                0,
                Math.min(x,maxX)
            );



            y = Math.max(
                0,
                Math.min(y,maxY)
            );



            selectedTable.style.left =
            `${x}px`;



            selectedTable.style.top =
            `${y}px`;



        }
    );





    document.addEventListener(
        'mouseup',
        function(){

            if(selectedTable){
                selectedTable.style.zIndex = '';
                selectedTable.classList.remove('dragging');
                selectedTable = null;
            }

        }
    );

    function saveLayoutPositions(){
        const positions = Array.from(
            document.querySelectorAll('.pos-table-card')
        ).map(function(card){
            return {
                id: card.dataset.id,
                x: parseInt(card.style.left, 10) || 0,
                y: parseInt(card.style.top, 10) || 0
            };
        });

        if(!positions.length){
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]');

        if(!token){
            alert('CSRF token tidak ditemukan.');
            return;
        }

        fetch('/pos/layout/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token.content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ positions: positions })
        })
        .then(function(response){
            if(!response.ok){
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(data){
            if(data.success){
                alert('Posisi meja berhasil disimpan.');
                editing = false;
                document.body.classList.remove('pos-editing');
                if(btnLayout){
                    btnLayout.innerHTML = 'Edit Layout';
                }
            } else {
                throw new Error('Save failed');
            }
        })
        .catch(function(error){
            console.error(error);
            alert('Gagal menyimpan layout meja.');
        });
    }

});