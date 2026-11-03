<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

  <main>
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

      <img src="Logo.webp" alt="Logo <?= e(NAMA_TOKO) ?>" width="500" height="500">
    </section>

   
  
 <?php include 'footer.php'; ?>