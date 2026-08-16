document.querySelectorAll(".dropdown-toggle").forEach(btn => {
    btn.addEventListener("click", function () {
        this.nextElementSibling.classList.toggle("open");
    });
});