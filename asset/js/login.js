document.addEventListener("DOMContentLoaded", function () {
  
  // 1. Inisialisasi AOS (Animasi Muncul)
  AOS.init({
    duration: 1000,
    once: true,
  });

  // 2. Logika Tombol Back to Top (Fade In/Out)
  const mybutton = document.getElementById("btn-back-to-top");

  const toggleBackToTop = () => {
    // Tombol muncul jika scroll lebih dari 200px
    if (window.scrollY > 200) {
      mybutton.classList.add("show");
    } else {
      mybutton.classList.remove("show");
    }
  };

  // Gunakan addEventListener 'scroll' (Lebih ringan & anti-delay)
  window.addEventListener("scroll", () => {
    window.requestAnimationFrame(toggleBackToTop);
  });

  // Klik untuk kembali ke atas
  mybutton.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  // Jalankan pengecekan posisi awal saat refresh
  toggleBackToTop();

  // 3. Validasi Form Bootstrap
  const forms = document.querySelectorAll(".needs-validation");
  Array.from(forms).forEach((form) => {
    form.addEventListener("submit", (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    }, false);
  });

});