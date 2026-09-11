<div class="shift-karyawan-form-card-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <form method="GET" action="/shift_karyawan"
              class="shift-karyawan-filter d-flex ms-auto gap-2 flex-wrap">

            <select name="bulan" class="form-select" style="width:180px;">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" class="form-select" style="width:120px;">
                @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-filter me-1"></i>
                Tampilkan
            </button>

            <a href="{{ route('shift_karyawan.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="btn btn-primary">
                <i class="bi bi-download me-1"></i>
                Download PDF
            </a>

            <button type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahShift">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Shift
            </button>

        </form>

    </div>
</div>