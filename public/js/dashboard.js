document.addEventListener("DOMContentLoaded", () => {

    const chart = document.getElementById("grafikPenjualanChart");

    if (!chart || typeof grafikData === "undefined") {
        return;
    }

    new Chart(chart, {
        type: "line",

        data: grafikData,

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: true,

                    labels: {
                        font: {
                            size: 14
                        }
                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback(value) {
                            return "Rp" + new Intl.NumberFormat("id-ID").format(value);
                        }

                    }

                }

            }

        }

    });

});