        function openTambah()
        {
            document.getElementById('modalTambah').style.display='flex';
        }

        function closeTambah()
        {
            document.getElementById('modalTambah').style.display='none';
        }

        function editData(id, kode, nama, email, role, status, kontak)
        {
            document.getElementById('modalEdit').style.display='flex';

            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_kontak').value = kontak;

            document.getElementById('formEdit').action =
            "/karyawan/update/" + id;
        }

        function closeEdit()
        {
            document.getElementById('modalEdit').style.display='none';
        }