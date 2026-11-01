# Pertemuan-07 P7 - Pemrosesan Formulir dengan PHP, Validasi Sisi Peladen, dan PRG

## Deskripsi

Dokumentasi pengembangan halaman Profil Mahasiswa pada P7. Artefak P6 digunakan sebagai baseline, lalu dikembangkan agar formulir Kontak dapat mengirim dan memproses data menggunakan PHP: metode GET dan POST, validasi sisi peladen, pengamanan keluaran HTML dengan htmlspecialchars(), penggunaan session, dan pola Post-Redirect-Get (PRG). Penyimpanan data ke basis data tidak termasuk dalam P7.

## Cara Menjalankan

1. Buka Laragon, klik *Start All*, dan pastikan Apache berjalan.
2. Pastikan folder proyek berada di dalam document root Laragon (C:\laragon\www\).
3. Buka halaman utama: [isi URL lokal yang kamu gunakan]/pertemuan-07/
4. Buka demonstrasi GET: [isi URL lokal yang kamu gunakan]/pertemuan-07/indexGet.php

## Struktur Berkas

- index.php: halaman utama, formulir POST, validasi PHP, session, dan PRG
- indexGet.php: artefak demonstrasi formulir GET (pembanding)
- script.js: navigasi dan validasi sisi klien
- style.css: tampilan halaman
- img/foto-profil.jpg: aset gambar profil

## Fitur dan Pengembangan

- *Baseline P6*: Artefak P6 (index.php, style.css, script.js, aset gambar) disalin ke pertemuan-07/ tanpa mengubah folder P6.
- *Penerimaan GET ($_GET)*: PHP membaca parameter nama dari URL dan menampilkannya dengan htmlspecialchars().
- *Pengiriman formulir GET*: Menambahkan contactForm.submit(); pada script.js setelah validasi JavaScript berhasil, sehingga formulir benar-benar terkirim.
- *Demonstrasi GET (indexGet.php)*: Salinan index.php disimpan sebagai pembanding dengan action="indexGet.php" dan method="get".
- *Formulir utama POST*: Atribut method pada index.php diubah menjadi post.
- *Penerimaan POST ($_POST)*: Membaca seluruh input formulir. Checkbox minat diubah menjadi name="minat[]" agar diterima sebagai larik, dan selector JavaScript disesuaikan agar mendukung minat dan minat[].
- *Validasi sisi peladen*: Pemeriksaan kelengkapan, format email dan semester (1 sampai 14), serta kesesuaian nilai pilihan (jenis pesan, program studi, minat) dengan daftar yang diizinkan.
- *Normalisasi*: trim((string) ...) diterapkan sebelum blok validasi.
- *Pengamanan keluaran*: Seluruh data yang ditampilkan kembali dibungkus htmlspecialchars(), dan pesan memakai nl2br() setelah diamankan.
- *Session dan PRG*: session_start(), penyimpanan hasil ke $_SESSION, header('Location: index.php') dan exit, lalu pengambilan data dari session. Pesan kesalahan dihapus dengan unset() setelah ditampilkan.

## Pengujian

Isi bagian "Hasil aktual" hanya dengan hasil yang benar-benar kamu amati. Jangan mencatat pengujian yang belum dijalankan.

### 1. Baseline P7
- Langkah: buka halaman P7 melalui localhost dan bandingkan dengan P6.
- Hasil aktual: [isi setelah diuji]

### 2. Parameter GET (?nama=Andi, ?nama=Budi Anduk, tanpa parameter)
- Langkah: akses URL dengan parameter nama, ganti nilainya, lalu akses tanpa parameter.
- Hasil aktual: [isi setelah diuji]

### 3. Pengiriman formulir GET (indexGet.php)
- Langkah: isi seluruh kolom dengan data valid, klik Kirim, amati parameter pada URL. Ulangi dengan satu kolom kosong.
- Hasil aktual: [isi setelah diuji]

### 4. Formulir POST (index.php)
- Langkah: lihat sumber halaman (CTRL+U) dan pastikan method="post", kirim formulir dan pastikan nilai tidak muncul di URL.
- Hasil aktual: [isi setelah diuji]

### 5. Checkbox minat[] dan validasi JavaScript
- Langkah: uji dengan dua topik, satu topik, dan tanpa topik, pada index.php dan indexGet.php.
- Hasil aktual: [isi setelah diuji]

### 6. Validasi sisi peladen
- Langkah: nonaktifkan sementara script.js, kirim formulir kosong, kirim dengan email tidak valid, dan kirim tanpa minat. Aktifkan kembali script.js setelahnya.
- Hasil aktual: [isi setelah diuji]

### 7. Pengamanan keluaran HTML
- Langkah: isi pesan dengan <b>Mahasiswa</b> dan pastikan tampil sebagai teks biasa.
- Hasil aktual: [isi setelah diuji]

### 8. Session dan PRG
- Langkah: kirim data valid, pastikan bagian Data yang Diterima Peladen tampil, lalu tekan CTRL+SHIFT+R dan pastikan tidak ada permintaan kirim ulang formulir.
- Hasil aktual: [isi setelah diuji]

## Riwayat Pengembangan

Isi ringkasan hasil pengujian sesuai commit yang benar-benar dilakukan.

- menyalin artefak pertemuan-06 ke pertemuan-07 untuk digunakan sebagai baseline: [ringkasan dan hasil]
- menguji [URL] dengan hasil sama dengan pertemuan-06: [ringkasan dan hasil]
- mempelajari penggunaan parameter GET: [ringkasan dan hasil]
- mempraktikkan pengiriman formulir GET: [ringkasan dan hasil]
- menyimpan demonstrasi formulir GET: [ringkasan dan hasil]
- mengubah formulir utama menjadi POST: [ringkasan dan hasil]
- menerima data formulir menggunakan POST: [ringkasan dan hasil]
- menyesuaikan pembacaan input dan validasi formulir: [ringkasan dan hasil]
- menampilkan pesan kesalahan validasi PHP: [ringkasan dan hasil]
- mengamankan keluaran data formulir: [ringkasan dan hasil]
- menerapkan session dan pola PRG: [ringkasan dan hasil]