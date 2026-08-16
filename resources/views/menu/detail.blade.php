<div class="modal-bg" id="detail{{ $m->menu_id }}">
    <div class="modal-card">

        {{-- Header Modal --}}
        <div class="modal-header-custom">

            <h2>Detail Menu</h2>

            <div class="modal-action">

                <button
                    class="edit-icon"
                    onclick="openEdit({{ $m->menu_id }})">

                    <i class="fas fa-pen"></i>

                </button>

                <button
                    class="close-btn"
                    onclick="closeDetail({{ $m->menu_id }})">

                    &times;

                </button>

            </div>

        </div>

        {{-- Informasi Menu --}}
        <div class="top-detail">

            @if($m->gambar)
                <img src="{{ asset('gambar/'.$m->gambar) }}">
            @else
                <img src="https://via.placeholder.com/400x300">
            @endif

            <div>

                <div class="detail-title">
                    {{ $m->nama_makanan }}
                </div>

                <div class="detail-sub">
                    {{ $m->kategori }}
                </div>

                <div class="menu-price">
                    Rp {{ number_format($m->harga) }}
                </div>

            </div>

        </div>

        {{-- Tab --}}
        <div class="tab-menu">

            <button
                class="tab-btn active"
                id="detailBtn{{ $m->menu_id }}"
                onclick="showDetail({{ $m->menu_id }})">

                Detail

            </button>

            <button
                class="tab-btn"
                id="resepBtn{{ $m->menu_id }}"
                onclick="showResep({{ $m->menu_id }})">

                Resep

            </button>

        </div>

        {{-- Detail --}}
        <div
            class="tab-content active"
            id="detailContent{{ $m->menu_id }}">

            <div class="detail-box">
                <b>Kategori :</b>
                {{ $m->kategori }}
            </div>

            <div class="detail-box">
                <b>HPP :</b>
                Rp {{ number_format($m->hpp) }}
            </div>

            <div class="detail-box">
                <b>Profit :</b>
                {{ $m->profit }}%
            </div>

            <div class="detail-box">
                <b>Harga Jual :</b>
                Rp {{ number_format($m->harga) }}
            </div>

        </div>

        {{-- Resep --}}
        <div
            class="tab-content"
            id="resepContent{{ $m->menu_id }}">

            @php
                $totalHpp = 0;
            @endphp

            @foreach($m->bahan as $b)

                @php
                    $hargaPerSatuan =
                        $b->barang->harga /
                        $b->barang->stock;

                    $totalHarga =
                        $hargaPerSatuan *
                        $b->jumlah_bahan;

                    $totalHpp += $totalHarga;
                @endphp

                <div class="resep-item">

                    <div>

                        <b>{{ $b->barang->nama_bahan }}</b>

                        <br>

                        <small>

                            {{ $b->jumlah_bahan }}
                            {{ $b->barang->satuan }}

                        </small>

                    </div>

                    <div>

                        Rp {{ number_format($totalHarga) }}

                    </div>

                </div>

            @endforeach

           <div class="total-hpp">

            <span>Total HPP</span>

            <span>
                Rp {{ number_format($totalHpp) }}
            </span>

        </div>

        </div>

    </div>
</div>