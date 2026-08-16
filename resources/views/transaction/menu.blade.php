<div class="menu-section">
    <div class="menu-grid">
        @foreach($menu as $m)
            <div class="card-menu">
                <img src="{{ asset('gambar/'.$m->gambar) }}" alt="{{ $m->nama_makanan }}">
                <div class="card-body">
                    <div class="nama-menu"> {{ $m->nama_makanan }} </div>
                    <div class="harga-menu"> Rp {{ number_format($m->harga,0,',','.') }} </div>
                    <button
                        type="button"
                        class="btn-tambah"
                        id="btn-menu-{{ $m->menu_id }}"
                        onclick="tambahMenu({{ $m->menu_id }}, '{{ $m->nama_makanan }}', {{ $m->harga }})">
                        + Add
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>