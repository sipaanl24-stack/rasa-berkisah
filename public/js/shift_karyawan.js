document.addEventListener("DOMContentLoaded", function () {
    new Litepicker({
        element: document.getElementById("rentang_tanggal"),
        singleMode:false,
        format:"YYYY-MM-DD",
        numberOfMonths: 1,
        numberOfColumns: 1,
        autoApply:true,
        setup:(picker)=>{
            picker.on("selected", (start,end)=>{
                document.getElementById("tanggal_mulai").value =
                    start.format("YYYY-MM-DD");
                document.getElementById("tanggal_selesai").value =
                    end.format("YYYY-MM-DD");
            });
        }
    });
});