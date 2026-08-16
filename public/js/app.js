/* ==================================================
                         ELEMENT
================================================== */

const sidebar = document.getElementById("sidebar");
const navbar = document.querySelector(".navbar");
const content = document.getElementById("content");

const themeBtn = document.getElementById("themeToggle");
const toggleSidebar = document.getElementById("toggleSidebar");

/* ==================================================
                    THEME
================================================== */

if (themeBtn) {

    const themeIcon = themeBtn.querySelector("i");

    // Restore Theme
    if (localStorage.getItem("theme") === "light") {

        document.body.classList.add("light");

        themeIcon.classList.remove("fa-moon");
        themeIcon.classList.add("fa-sun");

    }

    // Toggle Theme
    themeBtn.onclick = function () {

        document.body.classList.toggle("light");

        if (document.body.classList.contains("light")) {

            localStorage.setItem("theme", "light");

            themeIcon.classList.replace("fa-moon", "fa-sun");

        } else {

            localStorage.setItem("theme", "dark");

            themeIcon.classList.replace("fa-sun", "fa-moon");

        }

    };

}

/* ==================================================
                    SIDEBAR
================================================== */

if (sidebar && navbar && content && toggleSidebar) {

    // Restore Sidebar
    if (localStorage.getItem("sidebar") === "hide") {

        sidebar.classList.add("hide");
        navbar.classList.add("full");
        content.classList.add("full");

    }

    // Toggle Sidebar
    toggleSidebar.onclick = function () {

        sidebar.classList.toggle("hide");
        navbar.classList.toggle("full");
        content.classList.toggle("full");

        localStorage.setItem(
            "sidebar",
            sidebar.classList.contains("hide") ? "hide" : "show"
        );

    };

}

const btn = document.getElementById("notifBtn");
const menu = document.getElementById("notifDropdown");

if (btn && menu) {

    btn.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("show");
    });

    document.addEventListener("click", function () {
        menu.classList.remove("show");
    });

}

