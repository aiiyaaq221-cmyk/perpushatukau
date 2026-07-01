document.addEventListener("DOMContentLoaded", function () {
    const menus = document.querySelectorAll(".has-submenu");
    menus.forEach(function (menu) {
        const parentLink = menu.querySelector(".parent-link");
        if (!parentLink) return;
       const key = menu.dataset.menu;
        /* =============================
           Restore State
        ============================= */
        const state = localStorage.getItem("sidebar_" + key);
        if (state === "open") {
            menu.classList.add("open");
        }
        // Jika route aktif tapi belum ada state
        if (menu.classList.contains("active-parent") && state === null) {
            menu.classList.add("open");
        }

        /* =============================
           Click Parent
        ============================= */

        parentLink.addEventListener("click", function (e) {
            e.preventDefault();
            if (menu.classList.contains("open")) {
                // Tutup submenu
                menu.classList.remove("open");
                localStorage.setItem("sidebar_" + key, "close");
            } else {

                // Tutup submenu lain
                menus.forEach(function (item) {
                    item.classList.remove("open");
                    const itemKey = item.dataset.menu;

                    if (itemKey) {
                        localStorage.setItem("sidebar_" + itemKey, "close");
                    }
                });

                // Buka submenu yang dipilih
                menu.classList.add("open");
                localStorage.setItem("sidebar_" + key, "open");
            }
        });
    });
});