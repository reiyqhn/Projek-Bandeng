
document.addEventListener("DOMContentLoaded", function () {
    // Mengambil tombol menu dan daftar navigasi.
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");

    // Membuka atau menutup menu pada layar HP.
    if (menuToggle && navLinks) {
        menuToggle.addEventListener("click", function () {
            navLinks.classList.toggle("active");
        });
    }

    const navigationItems = document.querySelectorAll(".nav-links a");

    navigationItems.forEach(function (item) {
        item.addEventListener("click", function () {
            if (navLinks) {
                navLinks.classList.remove("active");
            }
        });
    });

    const searchForm = document.querySelector("#search-form");
    const searchInput = document.querySelector("#search-input");

    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const keyword = searchInput.value
                .trim()
                .toLowerCase();

            if (
                keyword.includes("bandeng") ||
                keyword.includes("samudera") ||
                keyword.includes("samudra")
            ) {
                const productSection =
                    document.querySelector("#produk");

                if (productSection) {
                    productSection.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            } else if (keyword === "") {
                alert("Masukkan kata kunci pencarian terlebih dahulu.");
            } else {
                alert("Produk tidak ditemukan.");
            }
        });
    }
});
