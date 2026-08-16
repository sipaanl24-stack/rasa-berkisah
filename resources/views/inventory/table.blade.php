<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([ 'sort' => 'kode', 'direction' => ($sort == 'kode' && $direction == 'asc') ? 'desc' : 'asc' ]) }}" class="sort-link">
                        Kode
                        @if($sort == 'kode')
                            <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([ 'sort' => 'nama_bahan', 'direction' => ($sort == 'nama_bahan' && $direction == 'asc') ? 'desc' : 'asc' ]) }}" class="sort-link">
                        Nama Bahan
                        @if($sort == 'nama_bahan')
                            <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </a>
                </th>

                <th>Kategori</th>
                <th>Stock</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Masuk</th>
                <th>Expired</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
            <tr>

                <td>{{ $d->kode }}</td>
                <td>{{ $d->nama_bahan }}</td>
                <td>{{ $d->kategori }}</td>
                <td>{{ $d->stock }}</td>
                <td>{{ $d->satuan }}</td>
                <td>Rp {{ number_format($d->harga) }}</td>
                <td>{{ $d->masuk }}</td>
                <td>{{ $d->expired }}</td>
                <td>
                    <button class="btn edit-btn" onclick="openEditModal(
                            '{{ $d->barang_id }}',
                            '{{ $d->kode }}',
                            '{{ $d->nama_bahan }}',
                            '{{ $d->kategori }}',
                            '{{ $d->stock }}',
                            '{{ $d->satuan }}',
                            '{{ $d->harga }}',
                            '{{ $d->masuk }}',
                            '{{ $d->expired }}'
                        )"> 
                        Edit 
                    </button> 
                </td> 
            </tr> 
            @empty 
            <tr>
                <td colspan="9" style="text-align:center;padding:40px;">
                    Data tidak ditemukan.
                </td>
            </tr> 
            @endforelse 
        </tbody> 
    </table>

    <div class="table-footer"> 
        <div class="table-info">
            Menampilkan
            <strong>{{ $data->lastItem() ?? 0 }}</strong>
            dari
            <strong>{{ $data->total() }}</strong>
            bahan
        </div>

        <div class="custom-pagination"> 
            @if($data->currentPage() > 1) 
                <a href="{{ request()->fullUrlWithQuery(['page' => $data->currentPage()-1]) }}">
                    <i class="fas fa-chevron-left"></i>
                </a> 
            @endif

            @for($i = 1; $i <= $data->lastPage(); $i++) 
                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="{{ $data->currentPage() == $i ? 'active' : '' }}"> 
                    {{ $i }} 
                </a> 
            @endfor

            @if($data->hasMorePages()) 
                <a href="{{ request()->fullUrlWithQuery(['page' => $data->currentPage()+1]) }}">
                    <i class="fas fa-chevron-right"></i>
                </a> 
            @endif 
        </div> 
    </div> 
</div>