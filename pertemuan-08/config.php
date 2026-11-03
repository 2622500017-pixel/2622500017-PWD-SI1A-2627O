<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

/* ==========================================================
   BAGIAN 1: Variabel dan konstanta
   ========================================================== */
const NAMA_TOKO = "HappyPaws";
const TAGLINE   = "Pet Shop & Care";

$alamat      = "Jl. Basuki Rahmat Ujung No.II, Pangkalpinang";
$telepon     = "0853-7936-6114";
$emailToko   = "happypaws@gmail.com";
$jamBuka     = 8;
$jamTutup    = 20;
$tahunBerdiri = 2003;
$githubRepo  = "https://github.com/2622500017-pixel/2622500017-PWD-SI1A-2627O";
$namaPengembang = "Revand";
$nim         = "2622500017";

/* ==========================================================
   BAGIAN 2: Operator dan percabangan
   ========================================================== */
$jamSekarang = (int) date('H');
$tokoBuka    = ($jamSekarang >= $jamBuka && $jamSekarang < $jamTutup);
$statusToko  = $tokoBuka ? "Buka sekarang" : "Sedang tutup";

if ($jamSekarang < 11) {
  $sapaan = "Selamat pagi";
} elseif ($jamSekarang < 15) {
  $sapaan = "Selamat siang";
} elseif ($jamSekarang < 18) {
  $sapaan = "Selamat sore";
} else {
  $sapaan = "Selamat malam";
}

/* ==========================================================
   BAGIAN 3: Data untuk ditampilkan dan divalidasi
   ========================================================== */
$layanan = [
  "Makanan & Aksesori",
  "Grooming",
  "Penitipan Hewan",
  "Konsultasi Kesehatan",
];

$hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

$jenisHewan     = ["Anjing", "Kucing", "Kelinci", "Burung", "Lainnya"];
$pilihanLayanan = ["Grooming", "Penitipan", "Konsultasi", "Makanan & Aksesori"];
$jenisPesanOk   = ["pertanyaan" => "Pertanyaan", "saran" => "Saran"];

function e($teks) {
  return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

/* ==========================================================
   BAGIAN 4: Proses form (POST -> validasi -> redirect)
   ========================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $layananDipilih = $_POST['layanan'] ?? [];
  if (!is_array($layananDipilih)) {
    $layananDipilih = [];
  }

  $data = [
    'nama'        => trim((string) ($_POST['nama'] ?? '')),
    'email'       => trim((string) ($_POST['email'] ?? '')),
    'jumlah'      => trim((string) ($_POST['jumlah'] ?? '')),
    'tanggal'     => trim((string) ($_POST['tanggal'] ?? '')),
    'jenis_pesan' => trim((string) ($_POST['jenis_pesan'] ?? '')),
    'hewan'       => trim((string) ($_POST['hewan'] ?? '')),
    'pesan'       => trim((string) ($_POST['pesan'] ?? '')),
    'layanan'     => array_values(array_filter($layananDipilih, 'is_string')),
  ];

  $galat = [];

  if ($data['nama'] === '') {
    $galat[] = 'Nama lengkap wajib diisi.';
  } elseif (mb_strlen($data['nama']) < 3 || mb_strlen($data['nama']) > 50) {
    $galat[] = 'Nama harus 3 sampai 50 karakter.';
  }

  if ($data['email'] === '') {
    $galat[] = 'Email wajib diisi.';
  } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
    $galat[] = 'Format email tidak valid.';
  }

  if ($data['jumlah'] === '') {
    $galat[] = 'Jumlah hewan wajib diisi.';
  } else {
    $jumlah = filter_var($data['jumlah'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]]);
    if ($jumlah === false) {
      $galat[] = 'Jumlah hewan harus bilangan bulat antara 1 dan 10.';
    }
  }

  if ($data['tanggal'] === '') {
    $galat[] = 'Tanggal kunjungan wajib diisi.';
  } else {
    $tgl = DateTime::createFromFormat('Y-m-d', $data['tanggal']);
    if ($tgl === false || $tgl->format('Y-m-d') !== $data['tanggal']) {
      $galat[] = 'Format tanggal kunjungan tidak valid.';
    }
  }

  if ($data['jenis_pesan'] === '') {
    $galat[] = 'Jenis pesan wajib dipilih.';
  } elseif (!array_key_exists($data['jenis_pesan'], $jenisPesanOk)) {
    $galat[] = 'Jenis pesan tidak valid.';
  }

  if (count($data['layanan']) === 0) {
    $galat[] = 'Pilih minimal satu layanan yang diminati.';
  } else {
    foreach ($data['layanan'] as $item) {
      if (!in_array($item, $pilihanLayanan, true)) {
        $galat[] = 'Pilihan layanan tidak valid.';
        break;
      }
    }
  }

  if ($data['hewan'] === '') {
    $galat[] = 'Jenis hewan wajib dipilih.';
  } elseif (!in_array($data['hewan'], $jenisHewan, true)) {
    $galat[] = 'Jenis hewan tidak valid.';
  }

  if ($data['pesan'] === '') {
    $galat[] = 'Pesan wajib diisi.';
  } elseif (mb_strlen($data['pesan']) > 300) {
    $galat[] = 'Pesan maksimal 300 karakter.';
  }

  if (count($galat) === 0) {
    $_SESSION['terima'] = $data;
  } else {
    $_SESSION['galat'] = $galat;
    $_SESSION['data']  = $data;
  }

  header('Location: index.php#kontak');
  exit;
}

// Ambil data sekali pakai (flash) dari session, lalu hapus
$galat  = $_SESSION['galat'] ?? [];
$terima = $_SESSION['terima'] ?? [];
$data   = $_SESSION['data'] ?? [
  'nama' => '', 'email' => '', 'jumlah' => '', 'tanggal' => date('Y-m-d'),
  'jenis_pesan' => '', 'hewan' => '', 'pesan' => '', 'layanan' => [],
];
unset($_SESSION['galat'], $_SESSION['terima'], $_SESSION['data']);
?>