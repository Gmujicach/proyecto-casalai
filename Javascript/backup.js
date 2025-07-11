document.addEventListener('DOMContentLoaded', function () {
    // Mostrar mensajes flotantes
    function mostrarMensaje(msg, tipo = 'info') {
        let div = document.createElement('div');
        div.className = 'alert alert-' + tipo;
        div.textContent = msg;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 2500);
    }

    document.addEventListener('DOMContentLoaded', function () {
    // Descargar respaldo actual (genera y descarga)
    document.getElementById('btn-backup-principal').addEventListener('click', function (e) {
        e.preventDefault();
        fetch('controlador/backup.php?accion=generar')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location = 'controlador/backup.php?accion=descargar&archivo=' + encodeURIComponent(data.archivo);
                } else {
                    alert('Error al generar respaldo');
                }
            });
    });

    

    // Restaurar el último respaldo disponible
    document.getElementById('btn-restaurar-ultimo').addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('¿Seguro que deseas restaurar el último respaldo?')) {
            fetch('controlador/backup.php?accion=consultar')
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Ordena por nombre descendente (el más reciente primero)
                        data.sort().reverse();
                        let ultimo = data[0];
                        fetch('controlador/backup.php?accion=restaurar&archivo=' + encodeURIComponent(ultimo))
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Restauración exitosa');
                                    location.reload();
                                } else {
                                    alert('Error al restaurar');
                                }
                            });
                    } else {
                        alert('No hay respaldos disponibles');
                    }
                });
        }
    });
});

    // Actualiza la tabla de respaldos (si usas AJAX para listar)
    function actualizarTablaRespaldos() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'controlador/backup.php?accion=consultar', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let tbody = document.querySelector('#tablaConsultas tbody');
                tbody.innerHTML = '';
                data.forEach(function (respaldo) {
                    let tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${respaldo}</td>
                        <td>
                            <button class="btn btn-info btn-descargar" data-archivo="${respaldo}">Descargar</button>
                            <button class="btn btn-warning btn-restaurar" data-archivo="${respaldo}">Restaurar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                agregarEventosBotones();
            }
        };
        xhr.send();
    }

    // Agrega eventos a los botones de la tabla
    function agregarEventosBotones() {
document.querySelectorAll('.btn-descargar').forEach(btn => {
    btn.onclick = function (e) {
        e.preventDefault();
        window.location = 'controlador/backup.php?accion=descargar&archivo=' + encodeURIComponent(this.dataset.archivo);
    };
});

        document.querySelectorAll('.btn-restaurar').forEach(btn => {
            btn.onclick = function (e) {
                e.preventDefault();
                if (confirm('¿Seguro que deseas restaurar este respaldo?')) {
                    fetch('controlador/backup.php?accion=restaurar&archivo=' + encodeURIComponent(this.dataset.archivo))
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                mostrarMensaje('Restauración exitosa', 'success');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                mostrarMensaje('Error al restaurar', 'danger');
                            }
                        });
                }
            };
        });
    }

    // Generar respaldo principal
    document.getElementById('btn-backup-principal').addEventListener('click', function (e) {
        e.preventDefault();
        fetch('controlador/backup.php?accion=generar&tipo=P')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje('Respaldo generado: ' + data.archivo, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    mostrarMensaje('Error al generar respaldo', 'danger');
                }
            });
    });

    // Generar respaldo seguridad
    document.getElementById('btn-backup-seguridad').addEventListener('click', function (e) {
        e.preventDefault();
        fetch('controlador/backup.php?accion=generar&tipo=S')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje('Respaldo generado: ' + data.archivo, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    mostrarMensaje('Error al generar respaldo', 'danger');
                }
            });
    });

    agregarEventosBotones();
});