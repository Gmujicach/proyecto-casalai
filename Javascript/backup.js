document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn-backup-principal').addEventListener('click', function () {
        fetch('Controlador/BackupController.php?accion=generar&tipo=P')
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
        fetch('Controlador/BackupController.php?accion=generar&tipo=S')
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
                fetch('Controlador/BackupController.php?accion=restaurar&archivo=' + this.dataset.archivo)
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
});