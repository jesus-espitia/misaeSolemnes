document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (event) {
            const href = this.getAttribute('href');

            // Si no hay href o es un ancla (#), no mostramos loader
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
                return;
            }

            event.preventDefault(); // Evitar redirección inmediata
            const loader = document.getElementById('page-loader');
            loader.style.display = 'flex'; // Mostrar loader

            setTimeout(() => {
                loader.classList.add('fade-out'); // Suaviza el ocultamiento
            }, 800); // Empieza a desvanecer antes

            setTimeout(() => {
                window.location.href = href; // Redirige a la nueva página
            }, 1000); // Tiempo total hasta que cambia
        });
    });
});