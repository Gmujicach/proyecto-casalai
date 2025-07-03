document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn-backup-principal').addEventListener('click', function () {
        fetch('Controlador/backup.php?accion=generar&tipo=P')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Respaldo generado: ' + data.archivo);
                    location.reload();
                } else {
                    alert('Error al generar respaldo');
                }
            });
    });

    document.getElementById('btn-backup-seguridad').addEventListener('click', function () {
        fetch('Controlador/backup.php?accion=generar&tipo=S')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Respaldo generado: ' + data.archivo);
                    location.reload();
                } else {
                    alert('Error al generar respaldo');
                }
            });
    });

    document.querySelectorAll('.btn-descargar').forEach(btn => {
        btn.addEventListener('click', function () {
            window.location = 'Backups/' + this.dataset.archivo;
        });
    });

    document.querySelectorAll('.btn-restaurar').forEach(btn => {
        btn.addEventListener('click', function () {
            if (confirm('¿Seguro que deseas restaurar este respaldo?')) {
                fetch('Controlador/backup.php?accion=restaurar&archivo=' + this.dataset.archivo)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Restauración exitosa');
                            location.reload();
                        } else {
                            alert('Error al restaurar');
                        }
                    });
            }
        });
    });
});document.addEventListener('DOMContentLoaded', function () {
    function mostrarMensaje(msg, tipo = 'info') {
        let div = document.createElement('div');
        div.className = 'alert alert-' + tipo;
        div.textContent = msg;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 2500);
    }

    function actualizarTablaRespaldos() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'Controlador/backup.php?accion=consultar', true);
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

    function agregarEventosBotones() {
        document.querySelectorAll('.btn-descargar').forEach(btn => {
            btn.onclick = function (e) {
                e.preventDefault();
                // Descarga usando AJAX y blob
                let archivo = this.dataset.archivo;
                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'DB/backup/' + archivo, true);
                xhr.responseType = 'blob';
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        let url = URL.createObjectURL(xhr.response);
                        let a = document.createElement('a');
                        a.href = url;
                        a.download = archivo;
                        document.body.appendChild(a);
                        a.click();
                        setTimeout(() => {
                            document.body.removeChild(a);
                            URL.revokeObjectURL(url);
                        }, 100);
                    }
                };
                xhr.send();
            };
        });

        document.querySelectorAll('.btn-restaurar').forEach(btn => {
            btn.onclick = function (e) {
                e.preventDefault();
                if (confirm('¿Seguro que deseas restaurar este respaldo?')) {
                    let archivo = this.dataset.archivo;
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'Controlador/backup.php?accion=restaurar', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        let data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            mostrarMensaje('Restauración exitosa', 'success');
                            actualizarTablaRespaldos();
                        } else {
                            mostrarMensaje('Error al restaurar', 'danger');
                        }
                    };
                    xhr.send('archivo=' + encodeURIComponent(archivo));
                }
            };
        });
    }

    document.getElementById('btn-backup-principal').onclick = function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'Controlador/backup.php?accion=generar', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            let data = JSON.parse(xhr.responseText);
            if (data.success) {
                mostrarMensaje('Respaldo generado: ' + data.archivo, 'success');
                actualizarTablaRespaldos();
            } else {
                mostrarMensaje('Error al generar respaldo', 'danger');
            }
        };
        xhr.send('tipo=P');
    };

    document.getElementById('btn-backup-seguridad').onclick = function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'Controlador/backup.php?accion=generar', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            let data = JSON.parse(xhr.responseText);
            if (data.success) {
                mostrarMensaje('Respaldo generado: ' + data.archivo, 'success');
                actualizarTablaRespaldos();
            } else {
                mostrarMensaje('Error al generar respaldo', 'danger');
            }
        };
        xhr.send('tipo=S');
    };

    agregarEventosBotones();
});