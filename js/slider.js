let container_img = $('.container-img');
let prev = $('.container-boton_prev');
let next = $('.container-boton_next');

$('img:last').insertBefore('img:first');

container_img.css({ left: '-' + 100 + '%' });

let reset = 0;
let maxImages = 4; // Número máximo de imágenes permitidas

function siguiente() {
    if (reset < maxImages) {
        container_img.animate({ left: '-' + 200 + '%' }, 900, function () {
            $('img:first').insertAfter('img:last');
            container_img.css({ left: '-' + 100 + '%' });
        });
        reset++;
    }
}

function anterior() {
    if (reset > 0) {
        container_img.animate({ left: 0 }, 900, function () {
            $('img:last').insertBefore('img:first');
            container_img.css({ left: '-' + 100 + '%' });
        });
        reset--;
    }
}

next.on('click', function () {
    siguiente();
});

prev.on('click', function () {
    anterior();
});

let intervalId = setInterval(() => {
    if (reset < maxImages) {
        siguiente();
    } else {
        clearInterval(intervalId); // Detener el intervalo después de la quinta imagen
    }
}, 3000);
