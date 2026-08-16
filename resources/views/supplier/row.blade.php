@php
    $first = $items->first();
    $statusClass = match ($first->status) {
        'pending' => 'status-baru',
        'diterima' => 'status-diterima',
        default => 'status-ditolak'
    };
    $statusText = match ($first->status) {
        'pending' => 'Baru',
        'diterima' => 'Disetujui',
        default => 'Ditolak'
    };
@endphp

<tr>
    <td> <button type="button" class="kode-btn" onclick="toggleDetail('{{ $kode }}')"> {{ $kode }} </button> </td>
    <td> {{ \Carbon\Carbon::parse($first->tanggal_kirim)->format('d/m/Y') }} </td>
    <td>
        <span class="{{ $statusClass }}">
            {{ $statusText }}
        </span>
    </td>
    <td>
        @if($first->status == 'pending')
            <button type="button" class="update-btn"
                data-id="{{ $first->id }}"
                data-kode="{{ $kode }}"
                data-nama="{{ $items->pluck('nama_bahan')->implode('|') }}"
                data-kategori="{{ $items->pluck('kategori')->implode('|') }}"
                data-stock="{{ $items->pluck('sisa_stock')->implode('|') }}"
                data-satuan="{{ $items->pluck('satuan')->implode('|') }}"
                data-keterangan="{{ $first->keterangan }}">
                Update
            </button>
        @else
            <span class="action-done"> ✓ Selesai </span>
        @endif
    </td>
</tr>

<tr id="detail{{ $kode }}" class="detail-row">
    <td colspan="4">
        <table class="detail-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->nama_bahan }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->sisa_stock }} {{ $item->satuan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="detail-keterangan">
            <span class="label">Keterangan :</span>
            <span>{{ $first->keterangan }}</span>
        </div>
    </td>
</tr>