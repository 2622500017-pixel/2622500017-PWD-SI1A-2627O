<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>2622500017_REVAND_SI1A</title>
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

  </header>
    <nav>
      <ul id="navMenu">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="tentang.php">Tentang</a></li>
        <li><a href="registrasi.php">Registrasi</a></li>
      </ul>
    </nav>
