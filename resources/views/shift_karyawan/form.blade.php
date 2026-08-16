<div class="modal fade shift-karyawan-modal" id="modalTambahShift" tabindex="-1" aria-labelledby="modalTambahShiftLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered shift-karyawan-modal-dialog">
        <div class="modal-content shift-karyawan-modal-content">
            <form action="{{ route('shift_karyawan.store') }}" method="POST" class="shift-karyawan-form">
                @csrf
                <!-- Header -->
                <div class="modal-header shift-karyawan-modal-header">
                    <div>
                        <h4 class="modal-title fw-bold mb-1" id="modalTambahShiftLabel">
                            <i class="bi bi-calendar-plus me-2"></i>
                            Tambah Jadwal Shift
                        </h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>

                <!-- Body -->
                <div class="modal-body shift-karyawan-modal-body">
                    <div class="row g-4">
                        <!-- Karyawan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold"> Karyawan </label>
                            <select name="karyawan_id" class="form-select" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach($karyawan as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_karyawan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Shift -->
                        <div class="col-12">
                            <label class="form-label fw-semibold"> Shift </label>
                            <select name="shift" class="form-select" required>
                                <option value="1">Shift Pagi</option>
                                <option value="2">Shift Siang</option>
                                <option value="3">Shift Malam</option>
                                <option value="OFF">OFF</option>
                            </select>
                        </div>
                        <!-- Rentang -->
                        <div class="col-12">
                            <label class="form-label fw-semibold"> Rentang Jadwal  </label>
                            <div class="shift-karyawan-date-wrapper">
                                <i class="bi bi-calendar3"></i>
                                <input type="text" id="rentang_tanggal" class="form-control shift-karyawan-date-input" placeholder="Pilih rentang tanggal" autocomplete="off">
                            </div>
                            <input type="hidden" id="tanggal_mulai" name="tanggal_mulai">
                            <input type="hidden" id="tanggal_selesai" name="tanggal_selesai">
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer shift-karyawan-modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>