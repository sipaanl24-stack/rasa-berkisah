<div class="table-card">
    <table>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>

        @foreach($karyawan as $item)

        <tr>
            <td>{{ $item->kode_karyawan }}</td>
            <td>{{ $item->nama_karyawan }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ ucfirst($item->role) }}</td>

            <td>
                <span class="status-badge {{ $item->status }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>

            <td>{{ $item->kontak }}</td>
            <td>
                <div class="action">
                    <button type="button" class="btn btn-warning" onclick="editData(
                            '{{ $item->id }}',
                            '{{ $item->kode_karyawan }}',
                            '{{ $item->nama_karyawan }}',
                            '{{ $item->email }}',
                            '{{ $item->role }}',
                            '{{ $item->status }}',
                            '{{ $item->kontak }}'
                        )">
                        Edit
                    </button>

                    <form action="{{ route('karyawan.delete',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus data?')"> Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
</div>