<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Kode Request</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan Supplier</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dataHistory as $items)
                @php
                    $first = $items->first();
                @endphp
                <tr>
                    <td>
                        <button type="button" class="kode-btn" onclick="toggleDetail('{{ $first->kode_request }}')"> {{ $first->kode_request }} </button>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($first->tanggal_kirim)->format('d M Y') }}
                    </td>
                    <td>
                        @if($first->status == 'diterima')
                            <span class="status-diterima"> Diterima </span>
                        @else
                            <span class="status-ditolak"> Ditolak </span>
                        @endif
                    </td>
                    <td>
                        @if($first->status == 'diterima')
                            <div class="ket-box ket-diterima">
                                {{ $first->keterangan_penolakan ?: 'Request diterima supplier.' }}
                            </div>
                        @else
                            <div class="ket-box ket-ditolak">
                                {{ $first->keterangan_penolakan ?: '-' }}
                            </div>
                        @endif
                    </td>
                </tr>
                <tr id="detail{{ $first->kode_request }}" class="detail-row" style="display:none;">
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
                                        <td>
                                            {{ $item->nama_bahan }}
                                        </td>
                                        <td>
                                            {{ $item->kategori }}
                                        </td>
                                        <td>
                                            {{ $item->sisa_stock }}
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @empty
                <tr>
                <td colspan="4" class="empty-data">
                    Belum ada riwayat request.
                </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer">
        <div class="pagination-wrapper">
            {{ $requestHistory->onEachSide(1)->links() }}
        </div>
    </div>
</div>