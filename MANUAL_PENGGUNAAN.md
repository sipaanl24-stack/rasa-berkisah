# Manual Book Aplikasi POS & Restoran (Versi Gak Formal)

Ini bukan buku panduan kaku kayak kantor, tapi catatan sederhana biar kalian gampang pakai aplikasi ini tanpa bingung.

## 1. Awal Mulai Pakai

### Login
1. Buka aplikasi di browser.
2. Masuk ke halaman login.
3. Isi email dan password sesuai akun masing-masing.
4. Klik masuk.

Kalau akun aktif dan password benar, aplikasi akan otomatis mengarahkan ke halaman sesuai role:
- Admin -> Dashboard
- Kasir -> Halaman transaksi
- Kitchen -> Halaman pesanan

Kalau login gagal, biasanya karena:
- email salah
- password salah
- akun sudah tidak aktif

---

## 2. Role yang Ada di Aplikasi

### A. Admin
Biasanya admin ini yang ngatur semua hal penting. Kalau kamu jadi admin, tugasmu biasanya:
- lihat dashboard
- cek stok bahan
- tambah/edit menu
- kelola data karyawan
- atur jadwal kerja
- cek kehadiran
- lihat jurnal keuangan
- approve request bahan

### B. Kasir
Kasir itu yang paling sering ketemu pelanggan. Tugas utamanya:
- buat transaksi baru
- pilih meja
- masukkan menu pesanan
- bayar pelanggan
- cek pesanan yang ditangguhkan

### C. Kitchen
Kitchen fokus ke pesanan yang masuk dan bahan yang dibutuhkan. Tugasnya:
- lihat pesanan
- cek request bahan
- siapkan kebutuhan stok dapur

---

## 3. Cara Pakai Admin

### Dashboard
Setelah login sebagai admin, halaman pertama biasanya dashboard.

Di sini kamu bisa lihat:
- total penjualan
- laba
- produk paling laris
- grafik penjualan
- stok yang mulai menipis
- statistik kehadiran

Kalau mau ganti rentang data, biasanya ada filter seperti:
- Hari ini
- Minggu ini
- Bulan ini
- Tahun ini
- Semua data

---

### Mengelola Stok Bahan
Menu stok bahan bisa dipakai buat:
- menambah barang baru
- melihat stok yang ada
- update barang
- hapus barang yang sudah tidak dipakai

Langkahnya:
1. Masuk ke menu stok / inventory.
2. Klik tombol tambah atau edit sesuai kebutuhan.
3. Isi data barang seperti nama, kategori, stok, satuan, dan harga.
4. Simpan.

Tips penting:
- Jangan biarkan stok bahan kosong terlalu lama.
- Cek stok rutin supaya nanti tidak kehabisan saat jam ramai.

---

### Mengelola Menu Makanan
Untuk menu makanan dan minuman:
1. Masuk ke menu menu.
2. Tambahkan item baru atau ubah item lama.
3. Isi nama menu, kategori, harga jual, dan komponen pembuatannya.
4. Simpan.

Tujuan fitur ini supaya:
- harga jual konsisten
- menu gampang dicari kasir
- resep dan stok tetap terkontrol

---

### Kelola Data Karyawan
Buat admin bisa:
- tambah karyawan baru
- lihat daftar karyawan
- update data karyawan
- hapus data yang tidak aktif

Biasanya data yang diisi:
- nama
- email
- password
- role
- status

Role biasanya terbagi jadi:
- admin
- kasir
- kitchen

---

### Jadwal Kerja Karyawan
Fitur jadwal kerja berguna buat atur shift masing-masing karyawan.

Cara biasa:
1. Masuk ke menu jadwal karyawan.
2. Pilih nama karyawan.
3. Tentukan tanggal dan shift.
4. Simpan.

Shift biasanya terbagi jadi:
- shift 1
- shift 2

Kalau shift sudah diatur, saat karyawan login, sistem akan otomatis mencatat kehadiran sesuai jadwal.

---

### Kehadiran Karyawan
Untuk cek kehadiran:
1. Masuk ke menu kehadiran.
2. Lihat daftar hadir karyawan.
3. Kalau perlu, cek rekap per periode.

Sistem biasanya otomatis mencatat:
- tanggal
- jam masuk
- jam keluar
- status hadir / terlambat

Kalau karyawan logout, jam keluar akan terisi otomatis.

---

### Request Bahan / Permintaan Stok
Kalau kitchen atau bagian operasional butuh bahan tambahan, mereka biasanya mengirim request.

Alur umumnya:
1. Masuk ke request.
2. Isi nama bahan yang dibutuhkan.
3. Pilih kategori.
4. Tulis sisa stock saat ini.
5. Masukkan satuan dan keterangan.
6. Kirim request.

Admin nanti bisa cek request yang masih pending atau yang sudah diproses.

---

### Supplier / Suplai
Menu suplai biasanya dipakai buat melihat status barang atau data pemasok.

Admin bisa:
- cek daftar suplai
- update status pengiriman / persetujuan

Biasanya ini yang bikin proses bahan masuk lebih rapi.

---

### Jurnal Keuangan
Fitur jurnal berguna buat melihat catatan transaksi dan pemasukan.

Bisa dipakai untuk:
- mengecek transaksi yang sudah dibayar
- melihat status kas penjualan
- memonitor laporan keuangan

---

## 4. Cara Pakai Kasir

### Masuk ke Halaman Transaksi
Setelah login sebagai kasir, biasanya langsung masuk ke menu transaksi.

Di sini kamu akan melihat:
- daftar menu yang tersedia
- tombol pilih menu
- meja pelanggan
- total pembayaran
- status transaksi

---

### Membuat Transaksi Baru
1. Pilih meja pelanggan.
2. Klik menu yang dipesan.
3. Masukkan jumlah item sesuai kebutuhan.
4. Isi nama pelanggan bila perlu.
5. Pilih status transaksi:
   - pending = pesanan ditahan / belum bayar
   - paid = transaksi sudah dibayar
6. Klik simpan.

Kalau statusnya paid, sistem akan minta nominal uang yang dibayarkan.

---

### Bayar Pesanan
Saat pelanggan bayar:
1. Masukkan nominal uang yang diberikan.
2. Sistem akan menghitung total dan kembalian.
3. Jika nominal cukup, transaksi akan selesai.

Kalau nominal kurang dari total harga, aplikasi akan menolak dan minta nominal yang benar.

---

### Pesanan Ditangguhkan (On Hold)
Kadang pelanggan belum selesai memilih atau mau lanjut nanti.

Fitur on hold berguna untuk:
- menyimpan pesanan sementara
- melanjutkan transaksi lain waktu
- tidak kehilangan data pesanan

Cara umum:
1. Simpan transaksi dengan status pending.
2. Nanti bisa dibuka kembali dari daftar ditangguhkan.
3. Setelah selesai, lanjutkan checkout.

---

### Mengatur Meja
Menu POS atau meja berguna buat:
- melihat semua meja aktif
- mengelola layout meja
- mengubah posisi meja
- menambahkan meja baru

Kalau meja baru dibuat, sistem otomatis membuat kode meja sesuai area.

---

## 5. Cara Pakai Kitchen

Setelah login sebagai kitchen, biasanya yang dilihat adalah daftar pesanan yang masuk.

Fungsi kitchen:
- lihat pesanan yang harus diproses
- cek kebutuhan bahan
- mengirim request bahan bila stok mulai kurang

Jadi kitchen itu semacam "otak dapur" untuk memastikan pesanan siap dan bahan cukup.

---

## 6. Kalau Mau Cek Status Bahan
Bahan bisa mulai habis kalau:
- stok sudah sedikit
- permintaan sering naik
- banyak pesanan dalam satu waktu

Admin atau kitchen bisa cek stok dan request bahan, lalu ajukan pembelian / pengisian ulang.

---

## 7. Tips Pakai Aplikasi Supaya Gak Ribet

### Tips yang berguna
- Login pakai akun sesuai role, jangan asal pakai akun admin buat kasir.
- Cek stok sebelum jam ramai agar tidak kehabisan bahan.
- Jangan lupa simpan pesanan sebelum pelanggan pergi.
- Kalau ada request bahan, kirim secepatnya agar tidak tertunda.
- Cek dashboard setiap hari biar paham performa toko.
- Pastikan meja yang dipakai benar sebelum transaksi selesai.

### Kalau error atau bingung
Coba cek hal berikut:
- apakah akun aktif?
- apakah meja sudah dipilih?
- apakah menu sudah ditambahkan?
- apakah pembayaran sesuai nominal total?
- apakah status transaksi belum terlanjur salah?

---

## 8. Alur Kerja yang Umum Dipakai

### Kalau hari normal
1. Admin cek dashboard dan stok bahan.
2. Kitchen cek pesanan dan request bahan.
3. Kasir buka menu transaksi.
4. Pelanggan duduk di meja.
5. Kasir input menu.
6. Bayar saat pesanan selesai.
7. Admin cek laporan penjualan di akhir hari.

---

## 9. Penutup

Aplikasi ini sebenarnya dibuat supaya kerja jadi lebih rapi, cepat, dan mudah diawasi. Yang penting, pahami peran masing-masing:
- Admin = pengatur utama
- Kasir = orang yang handle transaksi
- Kitchen = yang jaga proses pesanan dan bahan

Kalau dipakai dengan benar, kerja harian bakal jauh lebih tertata dan nggak bikin pusing.

Kalau ada yang masih bingung, cukup buka lagi menu sesuai role masing-masing, lalu ikuti langkah-langkah di atas. Intinya: jangan takut mencoba, karena aplikasi ini dibuat untuk mempermudah kerja, bukan bikin ribet.
