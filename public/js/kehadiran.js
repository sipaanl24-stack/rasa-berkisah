const button = document.getElementById("themeToggle");

const savedTheme = localStorage.getItem("kehadiran-theme");

if(savedTheme === "dark"){
    document.body.classList.add("dark-mode");
    button.innerHTML = '<i class="fas fa-sun"></i>';
}

button.addEventListener("click", ()=>{

    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){

        localStorage.setItem("kehadiran-theme","dark");
        button.innerHTML='<i class="fas fa-sun"></i>';

    }else{

        localStorage.setItem("kehadiran-theme","light");
        button.innerHTML='<i class="fas fa-moon"></i>';

    }

});