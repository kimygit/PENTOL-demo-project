  <button type="button" class="btn btn-danger shadow position-fixed bottom-0 end-0 m-3" id="btn-back-to-top">
    <i class="bi bi-arrow-up fs-4"></i>
  </button>

  <script>
// asset/js/admin.js

document.addEventListener("DOMContentLoaded", function () {
  
    // --- LOGIKA TOMBOL BACK TO TOP ---
    const mybutton = document.getElementById("btn-back-to-top");

    const toggleBackToTop = () => {
        if (window.scrollY > 200) {
            mybutton.classList.add("show");
        } else {
            mybutton.classList.remove("show");
        }
    };

    // Muncul saat scroll
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

    // --- LOGIKA LAIN (AOS & Validasi) ---
    AOS.init({ duration: 1000, once: true });

    // Validasi Form
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
    </script>