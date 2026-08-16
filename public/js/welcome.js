const space = document.querySelector('.space');

for(let i = 0; i < 180; i++){

    const star = document.createElement('div');

    star.classList.add('star');

    star.style.setProperty(
        '--angle',
        Math.random() * 360 + 'deg'
    );

    star.style.animationDuration =
        (0.8 + Math.random() * 1.5) + 's';

    star.style.animationDelay =
        (Math.random() * 2) + 's';

    space.appendChild(star);

}

setTimeout(function(){

    window.location.replace(window.dashboardUrl);

},3000);