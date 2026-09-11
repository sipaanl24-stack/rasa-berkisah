
// ========================================
// THEME TOGGLE
// ========================================

const themeButton = document.getElementById("themeToggle");
const savedTheme = localStorage.getItem("kehadiran-theme");

if (savedTheme === "dark") {
    document.body.classList.add("dark-mode");

    if (themeButton) {
        themeButton.innerHTML = '<i class="fas fa-sun"></i>';
    }
}

if (themeButton) {
    themeButton.addEventListener("click", function () {

        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("kehadiran-theme", "dark");
            themeButton.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            localStorage.setItem("kehadiran-theme", "light");
            themeButton.innerHTML = '<i class="fas fa-moon"></i>';
        }

    });
}


// ========================================
// FILTER TANGGAL & CALENDAR
// ========================================

const tanggalFilter = document.getElementById("tanggalFilter");
const calendarBtn = document.getElementById("calendarBtn");

let calendar = null;

if (tanggalFilter && typeof flatpickr !== "undefined") {

    calendar = flatpickr(tanggalFilter, {

        dateFormat: "Y-m-d",

        positionElement: calendarBtn,
        position: "below left",

        allowInput: false,

        onChange: function (selectedDates, dateStr) {

            if (!dateStr) {
                return;
            }

            const url = new URL(window.location.href);

            url.searchParams.set("tanggal", dateStr);
            url.searchParams.delete("page");

            window.location.href = url.toString();
        }

    });

}


// ========================================
// BUTTON CALENDAR
// ========================================

if (calendarBtn && calendar) {

    calendarBtn.addEventListener("click", function () {
        calendar.open();
    });

}


// ========================================
// FILTER DROPDOWN
// ========================================

const filterDropdown = document.querySelector(".filter-dropdown");
const filterDropdownBtn = document.getElementById("filterDropdownBtn");

if (filterDropdown && filterDropdownBtn) {

    filterDropdownBtn.addEventListener("click", function (event) {

        event.stopPropagation();

        filterDropdown.classList.toggle("open");

    });


    document.addEventListener("click", function () {

        filterDropdown.classList.remove("open");

    });

}
