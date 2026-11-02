// ==========================================================
// HappyPaws - script.js
// ==========================================================

// ---------- 1. Menu navigasi (tombol hamburger di layar kecil) ----------
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");
const navLinks = document.querySelectorAll(".nav-link");

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

// ---------- 2. Bayangan header saat halaman digulir ----------
const siteHeader = document.getElementById("siteHeader");

window.addEventListener("scroll", () => {
  siteHeader.classList.toggle("scrolled", window.scrollY > 10);
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
  { rootMargin: "-45% 0px -50% 0px" } // aktif saat section berada di tengah layar
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

// ---------- 5. Validasi sederhana sebelum form dikirim ----------
const contactForm = document.getElementById("contactForm");
const formFeedback = document.getElementById("formFeedback");

contactForm.addEventListener("submit", (event) => {
  const namaInput = document.getElementById("nama");
  const emailInput = document.getElementById("email");
  const hewanInput = document.getElementById("hewan");

  const bidang = [namaInput, emailInput, hewanInput, pesanInput];
  bidang.forEach((el) => el.classList.remove("invalid"));

  const pesanGalat = [];

  if (namaInput.value.trim().length < 3) {
    pesanGalat.push("Nama minimal 3 karakter.");
    namaInput.classList.add("invalid");
  }

  const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!polaEmail.test(emailInput.value.trim())) {
    pesanGalat.push("Format email belum benar.");
    emailInput.classList.add("invalid");
  }

  if (hewanInput.value === "") {
    pesanGalat.push("Pilih jenis hewan Anda.");
    hewanInput.classList.add("invalid");
  }

  if (pesanInput.value.trim() === "") {
    pesanGalat.push("Pesan tidak boleh kosong.");
    pesanInput.classList.add("invalid");
  }

  if (pesanGalat.length > 0) {
    event.preventDefault(); // batalkan pengiriman, tampilkan pesan
    formFeedback.textContent = pesanGalat.join(" ");
  } else {
    formFeedback.textContent = "";
  }
});

// Bersihkan tampilan saat form di-reset
contactForm.addEventListener("reset", () => {
  formFeedback.textContent = "";
  contactForm.querySelectorAll(".invalid").forEach((el) => el.classList.remove("invalid"));
  setTimeout(perbaruiHitungan, 0);
});