document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");
    const toggle = document.getElementById("sidebarToggle");
    const menus = document.querySelectorAll(".has-submenu");

    if (!sidebar) return;

    /* ==========================================
       RESTORE SIDEBAR
    ========================================== */

    if (localStorage.getItem("sidebar") === "collapsed") {

        sidebar.classList.add("collapsed");

    }

    /* ==========================================
       TOGGLE SIDEBAR
    ========================================== */

    if (toggle) {

        toggle.addEventListener("click", function () {

            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed")) {

                localStorage.setItem(
                    "sidebar",
                    "collapsed"
                );

                menus.forEach(function (menu) {

                    menu.classList.remove("open");

                });

            } else {

                localStorage.setItem(
                    "sidebar",
                    "expanded"
                );

                restoreOpenMenu();

            }

        });

    }

    /* ==========================================
       RESTORE SUBMENU
    ========================================== */

    restoreOpenMenu();

    function restoreOpenMenu() {

        menus.forEach(function (menu) {

            const key = menu.dataset.menu;

            if (
                localStorage.getItem(
                    "submenu_" + key
                ) === "open"
            ) {

                menu.classList.add("open");

            }

            if (
                menu.querySelector(".active-menu")
            ) {

                menu.classList.add("open");

            }

        });

    }

    /* ==========================================
       CLICK SUBMENU
    ========================================== */

    menus.forEach(function (menu) {

        const button = menu.querySelector(".parent-link");

        const key = menu.dataset.menu;

        if (!button) return;

        button.addEventListener("click", function () {

            if (sidebar.classList.contains("collapsed")) {

                return;

            }

            const opened = menu.classList.contains("open");

            menus.forEach(function (item) {

                item.classList.remove("open");

                localStorage.setItem(
                    "submenu_" + item.dataset.menu,
                    "close"
                );

            });

            if (!opened) {

                menu.classList.add("open");

                localStorage.setItem(
                    "submenu_" + key,
                    "open"
                );

            }

        });

    });

});