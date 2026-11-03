<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

/* ==========================================================
   BAGIAN 1: Variabel dan konstanta
   ========================================================== */
const NAMA_TOKO = "HappyPaws";
const TAGLINE   = "Pet Shop & Care";

$alamat      = "Jl. Contoh No. 12, Kota Anda";
$telepon     = "0812-3456-7890";
$emailToko   = "halo@happypaws.test";
$jamBuka     = 8;
$jamTutup    = 20;
$tahunBerdiri = 2026;
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
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e(NAMA_TOKO) ?> - <?= e(TAGLINE) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- ================= HEADER ================= -->
  <header id="siteHeader">
    <div class="header-top">
      <h1><?= e(NAMA_TOKO) ?> Pet Shop</h1>

      <button class="nav-toggle" id="navToggle" type="button"
              aria-label="Buka navigasi" aria-controls="navMenu" aria-expanded="false">
        &#9776;
      </button>
    </div>

    <nav>
      <ul id="navMenu">
        <li><a href="#beranda" class="nav-link">Beranda</a></li>
        <li><a href="#tentang" class="nav-link">Tentang</a></li>
        <li><a href="#kontak" class="nav-link">Kontak</a></li>
      </ul>
    </nav>
  </header>

  <main>

    <!-- ================= BERANDA ================= -->
    <section id="beranda">
      <h2>Selamat Datang</h2>
      <p>
        <?= e($sapaan) ?>! Kami <strong><?= e(NAMA_TOKO) ?></strong>, <?= e(strtolower(TAGLINE)) ?>
        untuk sahabat berbulu Anda. Temukan makanan, aksesori, grooming, dan penitipan
        dalam satu tempat, karena setiap ekor berhak bahagia.
      </p>
      <p class="status-toko <?= $tokoBuka ? 'buka' : 'tutup' ?>">
        <?= e($statusToko) ?> &middot; jam <?= sprintf('%02d.00', $jamBuka) ?> - <?= sprintf('%02d.00', $jamTutup) ?>
      </p>

      <img src="logo-happypaws.png" alt="Logo <?= e(NAMA_TOKO) ?>" width="320">
    </section>

    <!-- ================= TENTANG ================= -->
    <section id="tentang">
      <h2>Tentang Kami</h2>

      <article>
        <h3>Profil Singkat</h3>
        <p>Nama toko: <?= e(NAMA_TOKO) ?></p>
        <p>Jenis usaha: <?= e(TAGLINE) ?></p>
        <p>Alamat: <?= e($alamat) ?></p>
        <p>Telepon: <?= e($telepon) ?></p>
        <p>Email: <?= e($emailToko) ?></p>
        <p>Status toko: <?= e($statusToko) ?></p>
        <p>Berdiri sejak: <?= e($tahunBerdiri) ?></p>

        <h3>Layanan Kami</h3>
        <ol>
          <?php foreach ($layanan as $item): ?>
            <li><?= e($item) ?></li>
          <?php endforeach; ?>
        </ol>

        <h3>Langkah Perawatan</h3>
        <ol>
          <?php
          for ($i = 1; $i <= 3; $i++) {
            echo "<li>Langkah ke-" . $i . ": ";
            switch ($i) {
              case 1:
                echo "Konsultasi singkat tentang kebutuhan hewan Anda.";
                break;
              case 2:
                echo "Perawatan oleh tim yang ramah dan berpengalaman.";
                break;
              default:
                echo "Hewan siap dijemput dalam keadaan bersih dan senang.";
                break;
            }
            echo "</li>";
          }
          ?>
        </ol>

        <h3>Jam Operasional</h3>
        <ol>
          <?php
          $n = 0;
          while ($n < count($hari)) {
            echo "<li>" . e($hari[$n]) . ": " . sprintf('%02d.00', $jamBuka) . " - " . sprintf('%02d.00', $jamTutup) . "</li>";
            $n++;
          }
          ?>
        </ol>
      </article>
    </section>

    <!-- ================= KONTAK ================= -->
    <section id="kontak">
      <h2>Kontak</h2>

      <?php if (count($galat) > 0): ?>
        <div class="form-feedback-error">
          <strong>Mohon periksa kembali:</strong>
          <ul>
            <?php foreach ($galat as $g): ?>
              <li><?= e($g) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <p>
        Kunjungi
        <a target="_blank" rel="noopener" href="<?= e($githubRepo) ?>">profil GitHub saya</a>.
      </p>

      <form id="contactForm" action="index.php#kontak" method="post" novalidate>
        <div class="form-group">
          <label for="nama">Nama Lengkap</label><br>
          <input class="input-form" type="text" id="nama" name="nama"
                 placeholder="Masukkan nama lengkap Anda" minlength="3" maxlength="50"
                 value="<?= e($data['nama']) ?>" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label><br>
          <input class="input-form" type="email" id="email" name="email"
                 placeholder="Masukkan email Anda"
                 value="<?= e($data['email']) ?>" required>
        </div>

        <div class="form-group">
          <label for="jumlah">Jumlah Hewan</label><br>
          <input class="input-form" type="number" id="jumlah" name="jumlah" min="1" max="10"
                 value="<?= e($data['jumlah']) ?>" required>
        </div>

        <div class="form-group">
          <label for="tanggal">Tanggal Kunjungan</label><br>
          <input class="input-form" type="date" id="tanggal" name="tanggal"
                 value="<?= e($data['tanggal']) ?>" required>
        </div>

        <div class="form-group" id="grupJenisPesan">
          <p>Jenis Pesan</p>
          <?php foreach ($jenisPesanOk as $nilai => $label): ?>
            <input type="radio" id="jp-<?= e($nilai) ?>" name="jenis_pesan" value="<?= e($nilai) ?>"
                   <?= $data['jenis_pesan'] === $nilai ? 'checked' : '' ?> required>
            <label for="jp-<?= e($nilai) ?>"><?= e($label) ?></label>
          <?php endforeach; ?>
        </div>

        <div class="form-group" id="grupLayanan">
          <p>Layanan Yang Diminati</p>
          <?php foreach ($pilihanLayanan as $i => $pilihan): ?>
            <input type="checkbox" id="ly-<?= $i ?>" name="layanan[]" value="<?= e($pilihan) ?>"
                   <?= in_array($pilihan, $data['layanan'], true) ? 'checked' : '' ?>>
            <label for="ly-<?= $i ?>"><?= e($pilihan) ?></label>
          <?php endforeach; ?>
        </div>

        <div class="form-group">
          <label for="hewan">Jenis Hewan</label><br>
          <select class="input-form" id="hewan" name="hewan" required>
            <option value="">-- Pilih Jenis Hewan --</option>
            <?php foreach ($jenisHewan as $j): ?>
              <option value="<?= e($j) ?>" <?= $data['hewan'] === $j ? 'selected' : '' ?>><?= e($j) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="pesan">Pesan</label><br>
          <textarea class="input-form" id="pesan" name="pesan" maxlength="300"
                    placeholder="Tulis pesan Anda di sini..." required><?= e($data['pesan']) ?></textarea>
          <small class="counter"><span id="pesanCount">0</span>/300</small>
        </div>

        <button type="submit">Kirim</button>
        <button type="reset">Reset</button>
        <p id="formFeedback"></p>
      </form>

      <?php if (!empty($terima)): ?>
        <div class="hasil-form">
          <h3>Data yang diterima peladen</h3>
          <p>Nama: <?= e($terima['nama']) ?></p>
          <p>Email: <?= e($terima['email']) ?></p>
          <p>Jumlah hewan: <?= e($terima['jumlah']) ?></p>
          <p>Tanggal kunjungan: <?= e($terima['tanggal']) ?></p>
          <p>Jenis pesan: <?= e($jenisPesanOk[$terima['jenis_pesan']] ?? $terima['jenis_pesan']) ?></p>
          <p>Jenis hewan: <?= e($terima['hewan']) ?></p>

          <p>Layanan yang diminati:</p>
          <?php if (count($terima['layanan']) > 0): ?>
            <ul>
              <?php foreach ($terima['layanan'] as $item): ?>
                <li><?= e($item) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>Tidak ada layanan yang dipilih.</p>
          <?php endif; ?>

          <p>Pesan:</p>
          <p><?= nl2br(e($terima['pesan'])) ?></p>
        </div>
      <?php endif; ?>
    </section>

  </main>

  <!-- ================= FOOTER ================= -->
  <footer id="footer">
    <p>&copy; <?= date("Y") ?> <?= e(NAMA_TOKO) ?> &middot; <?= e($namaPengembang) ?> [<?= e($nim) ?>]</p>
  </footer>

  <a href="#beranda" id="toTop" class="to-top" aria-label="Kembali ke atas">&uarr;</a>

  <script src="script.js"></script>
</body>
</html>