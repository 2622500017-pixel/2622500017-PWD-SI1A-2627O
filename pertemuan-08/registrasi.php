<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

    <section id="registrasi">
      <h2>Registrasi</h2>

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
        <a target="_blank" rel="noopener" href="<?= e($githubRepo) ?>">Profil GitHub saya</a>.
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

<?php include 'footer.php'; ?>