var notificacion = document.getElementById('contenedor-notificacion');
var bajar = false;

function toggleNotification() {
    if (bajar) {
        notificacion.style.height = "0px";
        notificacion.style.opacity = "0";
        notificacion.style.padding = "0";
        bajar = false;
    } else {
        notificacion.style.height = "auto";
        notificacion.style.opacity = "1";
        notificacion.style.padding = "10px";
        bajar = true;
        
        // PROXIMO: Marcar notificaciones como leídas
        marcarNotificacionesLeidas();
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

setInterval(actualizarNotificaciones, 60000);

function actualizarNotificaciones() {
    // Realizar una petición AJAX para obtener nuevas notificaciones
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'obtener_notificaciones.php', true);
    xhr.onload = function() {
        if (this.status == 200) {
            var data = JSON.parse(this.responseText);
            document.querySelector('.campana span').textContent = data.count;
            
            // Actualizar el contenido de las notificaciones
            var contenedor = document.getElementById('contenedor-notificacion');
            contenedor.innerHTML = data.html;
        }
    };
    xhr.send();
}