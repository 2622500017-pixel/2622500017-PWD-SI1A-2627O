<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

<section id="tentang">
      <h2>Tentang Kami</h2>

      <article>
        <h3>Profil Singkat</h3>
        <p>Nama toko: <?= e(NAMA_TOKO) ?></p>
        <p>Jenis Usaha: <?= e(TAGLINE) ?></p>
        <p>Alamat: <?= e($alamat) ?></p>
        <p>Telepon: <?= e($telepon) ?></p>
        <p>Email: <?= e($emailToko) ?></p>
        <p>Status Toko: <?= e($statusToko) ?></p>
        <p>Berdiri Sejak: <?= e($tahunBerdiri) ?></p>

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

<?php include 'footer.php'; ?>
