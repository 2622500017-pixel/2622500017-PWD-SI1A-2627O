// ==========================================================
// HappyPaws - script.js
// ==========================================================

// ---------- 1. Menu navigasi (tombol hamburger di layar kecil) ----------
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");
const navLinks = document.querySelectorAll("nav a.nav-link");

navToggle.addEventListener("click", () => {
  const terbuka = navMenu.classList.toggle("nav-open");
  navToggle.setAttribute("aria-expanded", terbuka);
  navToggle.setAttribute("aria-label", terbuka ? "Tutup navigasi" : "Buka navigasi");
});

// Tutup menu otomatis setelah salah satu tautan diklik
navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    navMenu.classList.remove("nav-open");
    navToggle.setAttribute("aria-expanded", "false");
    navToggle.setAttribute("aria-label", "Buka navigasi");
  });
});

// ---------- 2. Bayangan header + tombol "ke atas" saat halaman digulir ----------
const siteHeader = document.getElementById("siteHeader");
const toTop = document.getElementById("toTop");

window.addEventListener("scroll", () => {
  siteHeader.classList.toggle("scrolled", window.scrollY > 10);
  toTop.classList.toggle("tampil", window.scrollY > 400);
});

// ---------- 3. Menandai menu aktif sesuai bagian yang sedang dilihat ----------
const sections = document.querySelectorAll("main section[id]");

const pengamat = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        navLinks.forEach((link) => {
          link.classList.toggle("active", link.getAttribute("href") === "#" + entry.target.id);
        });
      }
    });
  },
  { rootMargin: "-30% 0px -60% 0px" } // aktif saat bagian berada di area atas-tengah layar
);

sections.forEach((section) => pengamat.observe(section));

// ---------- 4. Penghitung karakter pada kolom pesan ----------
const pesanInput = document.getElementById("pesan");
const pesanCount = document.getElementById("pesanCount");

function perbaruiHitungan() {
  pesanCount.textContent = pesanInput.value.length;
}

pesanInput.addEventListener("input", perbaruiHitungan);
perbaruiHitungan();

// ---------- 5. Validasi sebelum form dikirim ----------
const contactForm = document.getElementById("contactForm");
const formFeedback = document.getElementById("formFeedback");

function bersihkanTanda() {
  contactForm.querySelectorAll(".invalid").forEach((el) => el.classList.remove("invalid"));
  contactForm.querySelectorAll(".invalid-group").forEach((el) => el.classList.remove("invalid-group"));
}

contactForm.addEventListener("submit", (event) => {
  bersihkanTanda();
  const galat = [];

  const nama = document.getElementById("nama");
  const email = document.getElementById("email");
  const jumlah = document.getElementById("jumlah");
  const tanggal = document.getElementById("tanggal");
  const hewan = document.getElementById("hewan");

  if (nama.value.trim().length < 3) {
    galat.push("Nama minimal 3 karakter.");
    nama.classList.add("invalid");
  }

  const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!polaEmail.test(email.value.trim())) {
    galat.push("Format email belum benar.");
    email.classList.add("invalid");
  }

  const angka = Number(jumlah.value);
  if (jumlah.value === "" || !Number.isInteger(angka) || angka < 1 || angka > 10) {
    galat.push("Jumlah hewan harus antara 1 dan 10.");
    jumlah.classList.add("invalid");
  }

  if (tanggal.value === "") {
    galat.push("Tanggal kunjungan wajib diisi.");
    tanggal.classList.add("invalid");
  }

  if (!contactForm.querySelector('input[name="jenis_pesan"]:checked')) {
    galat.push("Pilih jenis pesan.");
    document.getElementById("grupJenisPesan").classList.add("invalid-group");
  }

  if (!contactForm.querySelector('input[name="layanan[]"]:checked')) {
    galat.push("Pilih minimal satu layanan.");
    document.getElementById("grupLayanan").classList.add("invalid-group");
  }

  if (hewan.value === "") {
    galat.push("Pilih jenis hewan.");
    hewan.classList.add("invalid");
  }

  if (pesanInput.value.trim() === "") {
    galat.push("Pesan tidak boleh kosong.");
    pesanInput.classList.add("invalid");
  }

  if (galat.length > 0) {
    event.preventDefault(); // batalkan pengiriman, tampilkan pesan
    formFeedback.textContent = galat.join(" ");
  } else {
    formFeedback.textContent = "";
  }
});

// Bersihkan tampilan saat form di-reset
contactForm.addEventListener("reset", () => {
  formFeedback.textContent = "";
  bersihkanTanda();
  setTimeout(perbaruiHitungan, 0);
});