document.addEventListener('DOMContentLoaded', () => {
    // Halaman jurnal belum membutuhkan JavaScript
});

const dateRange = document.getElementById("dateRange");
const calendarBtn = document.getElementById("calendarBtn");

if(dateRange){

    const fp = flatpickr(dateRange,{

        mode:"range",
        dateFormat:"Y-m-d",
        locale:"id",

        onOpen:function(){

            document.getElementById("quickFilter").value="all";

        },

        onClose:function(selectedDates,dateStr){

            if(dateStr!=""){
                document.getElementById("filterForm").submit();
            }

        }

    });

    calendarBtn.addEventListener("click",function(){

        fp.open();

    });

}

const quickFilter=document.getElementById("quickFilter");
console.log(dateRange);
if(quickFilter){

    quickFilter.addEventListener("change",function(){

        document.getElementById("dateRange").value="";

        document.getElementById("filterForm").submit();

    });

}

window.addEventListener("load",function(){

    const navigation=performance.getEntriesByType("navigation");

    if(navigation.length && navigation[0].type==="reload"){

        window.location.href=window.location.pathname;

    }

});