document.addEventListener("DOMContentLoaded", function () {

    /*
     * ==========================================
     * LITEPICKER TAMBAH SHIFT
     * ==========================================
     */

    const rentangTanggal = document.getElementById("rentang_tanggal");

    if (rentangTanggal) {

        new Litepicker({

            element: rentangTanggal,

            singleMode: false,

            format: "YYYY-MM-DD",

            numberOfMonths: 1,

            numberOfColumns: 1,

            autoApply: true,

            setup: (picker) => {

                picker.on("selected", (start, end) => {

                    document.getElementById("tanggal_mulai").value =
                        start.format("YYYY-MM-DD");

                    document.getElementById("tanggal_selesai").value =
                        end.format("YYYY-MM-DD");

                });

            }

        });

    }


    /*
     * ==========================================
     * EDIT SHIFT
     * ==========================================
     */

    const modalEdit = document.getElementById("modalEditShift");

    if (modalEdit) {

        let editPicker = new Litepicker({

            element: document.getElementById("edit_rentang_tanggal"),

            singleMode: false,

            format: "YYYY-MM-DD",

            numberOfMonths: 1,

            numberOfColumns: 1,

            autoApply: true,

            setup: (picker) => {

                picker.on("selected", (start, end) => {

                    document.getElementById("edit_tanggal_mulai").value =
                        start.format("YYYY-MM-DD");

                    document.getElementById("edit_tanggal_selesai").value =
                        end.format("YYYY-MM-DD");

                });

            }

        });


        modalEdit.addEventListener("show.bs.modal", function (event) {

            const button = event.relatedTarget;

            const karyawanId =
                button.getAttribute("data-karyawan-id");

            const karyawan =
                button.getAttribute("data-karyawan");

            const shift =
                button.getAttribute("data-shift");

            const tanggalDipilih =
                button.getAttribute("data-tanggal");


            /*
             * Cari semua tombol shift milik
             * karyawan dan shift yang sama.
             */

            const semuaTombol =
                document.querySelectorAll(".shift-edit-btn");

            let tanggalJadwal = [];

            semuaTombol.forEach(function (btn) {

                const btnKaryawanId =
                    btn.getAttribute("data-karyawan-id");

                const btnShift =
                    btn.getAttribute("data-shift");

                const btnTanggal =
                    btn.getAttribute("data-tanggal");

                if (
                    btnKaryawanId === karyawanId &&
                    btnShift === shift
                ) {

                    tanggalJadwal.push(btnTanggal);

                }

            });


            /*
             * Urutkan tanggal.
             */

            tanggalJadwal.sort();


            /*
             * Cari rentang yang mengandung
             * tanggal yang diklik.
             */

            let indexDipilih =
                tanggalJadwal.indexOf(tanggalDipilih);

            let tanggalMulai = tanggalDipilih;
            let tanggalSelesai = tanggalDipilih;


            /*
             * Cari tanggal sebelum.
             */

            for (let i = indexDipilih - 1; i >= 0; i--) {

                const tanggalSekarang =
                    new Date(tanggalJadwal[i]);

                const tanggalBerikutnya =
                    new Date(tanggalJadwal[i + 1]);

                const selisih =
                    (tanggalBerikutnya - tanggalSekarang)
                    / (1000 * 60 * 60 * 24);

                if (selisih === 1) {

                    tanggalMulai =
                        tanggalJadwal[i];

                } else {

                    break;

                }

            }


            /*
             * Cari tanggal sesudah.
             */

            for (let i = indexDipilih; i < tanggalJadwal.length - 1; i++) {

                const tanggalSekarang =
                    new Date(tanggalJadwal[i]);

                const tanggalBerikutnya =
                    new Date(tanggalJadwal[i + 1]);

                const selisih =
                    (tanggalBerikutnya - tanggalSekarang)
                    / (1000 * 60 * 60 * 24);

                if (selisih === 1) {

                    tanggalSelesai =
                        tanggalJadwal[i + 1];

                } else {

                    break;

                }

            }


            /*
             * Isi data modal.
             */

            document.getElementById("edit_karyawan_id").value =
                karyawanId;

            document.getElementById("edit_karyawan").value =
                karyawan;

            document.getElementById("edit_shift").value =
                shift;


            /*
             * Simpan rentang lama.
             */

            document.getElementById("tanggal_mulai_lama").value =
                tanggalMulai;

            document.getElementById("tanggal_selesai_lama").value =
                tanggalSelesai;


            /*
             * Isi rentang baru dengan
             * rentang lama.
             */

            document.getElementById("edit_tanggal_mulai").value =
                tanggalMulai;

            document.getElementById("edit_tanggal_selesai").value =
                tanggalSelesai;

            document.getElementById("edit_rentang_tanggal").value =
                `${tanggalMulai} - ${tanggalSelesai}`;


            /*
             * Set tanggal Litepicker.
             */

            editPicker.setDateRange(
                tanggalMulai,
                tanggalSelesai
            );

        });

    }

});