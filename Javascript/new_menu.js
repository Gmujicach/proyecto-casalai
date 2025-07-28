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

document.addEventListener('DOMContentLoaded', function() {
    // Manejar clic en botones de marcar como leído
    document.querySelectorAll('.marcar-leido').forEach(button => {
        button.addEventListener('click', function() {
            const idNotificacion = this.getAttribute('data-id');
            
            fetch('marcar_notificacion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_notificacion=${idNotificacion}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Eliminar la notificación del DOM
                    this.closest('.item-notificacion').remove();
                    
                    // Actualizar el contador de notificaciones
                    const contador = document.querySelector('.campana span');
                    if (contador) {
                        const nuevoTotal = parseInt(contador.textContent) - 1;
                        contador.textContent = nuevoTotal;
                        
                        // Actualizar el título de notificaciones
                        const tituloNotificaciones = document.querySelector('.notificacion h2 span');
                        if (tituloNotificaciones) {
                            tituloNotificaciones.textContent = nuevoTotal;
                        }
                        
                        // Si no hay más notificaciones, mostrar mensaje
                        if (nuevoTotal === 0) {
                            const contenedor = document.getElementById('contenedor-notificacion');
                            contenedor.innerHTML = `
                                <h2>Notificaciones <span>0</span></h2>
                                <div class="item-notificacion">
                                    <div class="texto">
                                        <p>No hay notificaciones recientes</p>
                                    </div>
                                </div>
                            `;
                        }
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});