/* =====================================================
   FOCUS MODE
===================================================== */

function enterFocusMode() {
    $("body").addClass("focus-mode");
    localStorage.setItem("focusMode", "true");

    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(() => {});
    }
}

function exitFocusMode() {
    $("body").removeClass("focus-mode");
    localStorage.removeItem("focusMode");

    if (document.fullscreenElement) {
        document.exitFullscreen();
    }
}


$(document).ready(function () {
    $("#searchHistory").on("keyup", function () {
        const searchTerm = $(this).val().toLowerCase();
        $(".history-item").each(function () {
            const code = $(this).find(".history-code").text().toLowerCase();
            const customer = $(this).find(".history-customer").text().toLowerCase();
            const menuItems = $(this).find(".item-name").text().toLowerCase();
            const hasMatch = code.includes(searchTerm) || 
                           customer.includes(searchTerm) || 
                           menuItems.includes(searchTerm) ||
                           searchTerm === "";
            $(this).toggle(hasMatch);
        });
    });

    /* =====================================================
        SWIPER KITCHEN DISPLAY
    ===================================================== */

    let swiper = null;
    if ($(".kdsSwiper").length) {
        swiper = new Swiper(".kdsSwiper", {
            effect: "coverflow",
            centeredSlides: true,
            slidesPerView: "auto",
            initialSlide: 0,
            loop: false,
            speed: 600,
            grabCursor: true,
            watchOverflow: true,
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
            spaceBetween: 0,
            coverflowEffect: {
                rotate: 0,
                stretch: -120,
                depth: 260,
                modifier: 1,
                scale: 0.85,
                slideShadows: false
            },

            breakpoints: {
                0: {
                    effect: "slide",
                    slidesPerView: 1,
                    centeredSlides: false
                },

                992: {
                    effect: "coverflow",
                    slidesPerView: "auto",
                    centeredSlides: true
                }
            },

            on: {
                init: function () {
                    updateSlides(this);
                },
                slideChangeTransitionEnd: function () {
                    updateSlides(this);
                }
            }
        });
    }

    /* =====================================================
        RESTORE FOCUS MODE
        ===================================================== */

        if (localStorage.getItem("focusMode") === "true") {

            $("body").addClass("focus-mode");

            // Browser hanya mengizinkan requestFullscreen()
            // jika dipicu oleh aksi pengguna.
            // Jadi setelah reload kita hanya mengembalikan tampilan.
        }

    /* =====================================================
        UPDATE CLASS
    ===================================================== */

    function updateSlides(swiper) {

        $(".swiper-slide")
            .removeClass("slide-left slide-center slide-right");
        if (swiper.slides[swiper.activeIndex + 1]) {
            swiper.slides[swiper.activeIndex + 1]
                .classList.add("slide-left");
        }

        if (swiper.slides[swiper.activeIndex]) {
            swiper.slides[swiper.activeIndex]
                .classList.add("slide-center");
        }

        if (swiper.slides[swiper.activeIndex - 1]) {
            swiper.slides[swiper.activeIndex - 1]
                .classList.add("slide-right");
        }
    }

    /* =====================================================
        PESANAN SELESAI
    ===================================================== */

    $(".kds-form").on("submit", function (e) {
        e.preventDefault();
        const form = this;
        const slide = $(this).closest(".swiper-slide");
        slide.addClass("slide-out");
        setTimeout(function () {
            if (swiper) {
                swiper.slidePrev(600);
            }
        }, 120);
        setTimeout(function () {
            form.submit();
        }, 550);
    });
});

/* =====================================================
    DIGITAL CLOCK
===================================================== */

function updateClock() {

    const now = new Date();

    const waktu = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false
    });

    const tanggal = now.toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric"
    });

    $("#focusClock").html(`
        <div class="clock-time">${waktu}</div>
        <div class="clock-date">${tanggal}</div>
    `);

}

updateClock();
setInterval(updateClock, 1000);

/* =====================================================
    FOCUS MODE
===================================================== */

$("#focusModeBtn").on("click", function () {
    enterFocusMode();
});

$("#exitFocusBtn").on("click", function () {
    exitFocusMode();
});

document.addEventListener("fullscreenchange", function () {

    if (document.fullscreenElement) {

        $("body").addClass("focus-mode");

    } else {

        $("body").removeClass("focus-mode");

    }

});