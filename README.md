# Aplikasi Manajemen Stok Toko Daging

## Konsep Aplikasi Manajemen Stok Toko Daging (Laravel)
- Ahmad Firdiansyah - 059
- Agung Satya Irawan - 007
- Bagus Abdul Wahhab - 073
- Mita Mimul Qorimah - 024
- Rizky Andini - 010
- Wahyu Ardianto - 321
## Ringkasan Umum
Aplikasi ini adalah sistem informasi berbasis web yang dirancang khusus untuk memudahkan pemilik atau pengelola toko daging di pasar dalam mengelola inventaris (stok) barang secara digital. Tujuannya adalah untuk menggantikan pencatatan manual, meningkatkan akurasi data, mempercepat proses transaksi, dan menyediakan laporan yang berguna untuk pengambilan keputusan.
Aplikasi ini akan dibangun sebagai aplikasi full-stack menggunakan framework Laravel, yang akan menangani semua logika bisnis di sisi backend dan juga dapat menyajikan tampilan antarmuka (frontend) yang responsif dan mudah digunakan.

## Alur Kerja Aplikasi (Application Workflow)
Berikut adalah alur kerja umum pengguna dari awal hingga akhir dalam menggunakan aplikasi ini sehari-hari:
1.	Login Pengguna:
	Setiap pengguna (pemilik atau kasir) masuk ke dalam sistem menggunakan akun mereka. Akan ada level akses yang berbeda (misalnya: Admin/Pemilik bisa melihat semua data, sedangkan Kasir hanya bisa melakukan penjualan).
2.	Kelola Data Master (Setup Awal):
	Sebelum memulai, pengguna (Admin) perlu memasukkan data-data dasar seperti:
	Data Produk: Menambahkan jenis-jenis daging yang dijual (mis., Daging Sapi Sirloin, Daging Ayam Paha, Tulang Iga), beserta satuan (Kg, Gram, Pcs), harga beli, dan harga jual.
	Data Supplier: Menambahkan informasi pemasok daging.
3.	Pencatatan Stok Masuk (Pembelian):
	Ketika daging baru datang dari supplier, staf akan masuk ke menu "Stok Masuk".
	Mereka akan memilih produk, memasukkan jumlah (mis., 20 Kg), memilih supplier, dan mencatat harga beli.
	Sistem secara otomatis akan menambahkan jumlah stok untuk produk tersebut di database.
4.	Pencatatan Penjualan (Stok Keluar):
	Ini adalah aktivitas harian utama. Di halaman kasir (POS - Point of Sale), staf akan:
	Memilih produk yang dibeli pelanggan.
	Memasukkan jumlah yang terjual (mis., 1.5 Kg).
	Sistem akan otomatis menghitung total harga.
	Setelah transaksi selesai, sistem akan secara otomatis mengurangi jumlah stok produk yang terjual.
5.	Pemantauan Stok Real-time:
	Pemilik toko dapat kapan saja membuka Dashboard untuk melihat sisa stok setiap jenis daging secara real-time tanpa harus mengecek fisik. Sistem akan menampilkan produk mana yang stoknya menipis.
6.	Melihat Laporan:
	Di akhir hari atau periode tertentu, pemilik dapat mengakses menu "Laporan" untuk melihat:
	Laporan Penjualan Harian/Mingguan/Bulanan.
	Laporan Laba/Rugi sederhana (berdasarkan selisih harga jual dan beli).
	Laporan Stok Masuk dan Keluar.

## Fitur-Fitur Utama
Fitur-fitur ini akan menjadi pilar utama dari aplikasi Anda:
1. Dashboard Utama
•	Tampilan ringkasan informasi terpenting setelah login.
•	Menampilkan metrik kunci: jumlah total stok, produk terlaris, ringkasan penjualan hari ini, dan notifikasi stok yang hampir habis.
2. Manajemen Produk
•	CRUD (Create, Read, Update, Delete) untuk semua produk daging.
•	Atribut produk: Nama Produk, Kode SKU (opsional), Satuan (Kg, Pcs), Harga Beli, Harga Jual.
3. Manajemen Supplier
•	CRUD untuk data supplier.
•	Atribut: Nama Supplier, Kontak (No. Telepon), Alamat.
4. Manajemen Stok
•	Stok Masuk (Pembelian): Modul untuk mencatat penerimaan barang dari supplier.
•	Stok Keluar (Penjualan): Terintegrasi dengan sistem kasir.
•	Penyesuaian Stok (Stock Opname): Fitur untuk menyesuaikan jumlah stok jika ada perbedaan antara data sistem dan stok fisik (misalnya karena rusak, hilang, atau penyusutan).
5. Sistem Kasir (Point of Sale - POS)
•	Antarmuka yang sederhana dan cepat untuk mencatat transaksi penjualan.
•	Pencarian produk yang mudah.
•	Perhitungan total harga otomatis.
•	Pencatatan riwayat transaksi.
6. Laporan & Analitik
•	Laporan Penjualan: Dapat difilter berdasarkan rentang tanggal.
•	Laporan Stok: Menampilkan riwayat pergerakan stok untuk setiap produk.
•	Laporan Profitabilitas: Menghitung keuntungan kotor per produk atau per periode.
7. Manajemen Pengguna
•	Sistem hak akses (Roles & Permissions).
•	Admin/Pemilik: Akses penuh ke semua fitur.
•	Kasir/Staf: Akses terbatas hanya pada modul penjualan dan pencatatan stok masuk.

## Teknologi
•	Backend: Laravel
•	Frontend: Laravel Blade
•	Database: MySQL
