var notificacion = document.getElementById('contenedor-notificacion');
var bajar = false;

function toggleNotification() {
    if (bajar) {
        notificacion.style.height = "0px";
        notificacion.style.opacity = "0";
        bajar = false;
    } else {
        notificacion.style.height = "auto"; // Cambiado de 100px a auto para contenido dinámico
        notificacion.style.opacity = "1";
        notificacion.style.padding = "10px"; // Añade padding cuando está visible
        bajar = true;
    }
}

// Cerrar notificaciones al hacer clic fuera
document.addEventListener('click', function(event) {
    var campana = document.querySelector('.campana');
    if (!campana.contains(event.target) && !notificacion.contains(event.target)) {
        notificacion.style.height = "0px";
        notificacion.style.opacity = "0";
        notificacion.style.padding = "0";
        bajar = false;
    }
});