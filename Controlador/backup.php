<?php
require_once __DIR__ . '/../Modelo/backup.php';

// Funciones para el controlador (sin clases)
function consultarBackups($tipo = 'P') {
    $backup = new Backup($tipo);
    return $backup->listarRespaldos();
}

function generarBackup($tipo = 'P') {
    $backup = new Backup($tipo);
    $nombreArchivo = 'backup_' . strtolower($tipo) . '_' . date('Ymd_His') . '.sql';
    $ruta = $backup->backup($nombreArchivo);
    return $ruta ? $nombreArchivo : false;
}

function restaurarBackup($tipo = 'P', $archivo) {
    $backup = new Backup($tipo);
    return $backup->restore($archivo);
}

// Enrutamiento para AJAX
if (isset($_GET['accion'])) {
    if ($_GET['accion'] === 'generar') {
        $tipo = $_GET['tipo'] ?? 'P';
        $archivo = generarBackup($tipo);
        echo json_encode(['success' => $archivo !== false, 'archivo' => $archivo]);
        exit;
    }
    if ($_GET['accion'] === 'restaurar') {
        $archivo = $_GET['archivo'] ?? '';
        $tipo = (strpos($archivo, 'seguridad') !== false) ? 'S' : 'P';
        $ok = restaurarBackup($tipo, $archivo);
        echo json_encode(['success' => $ok]);
        exit;
    }
}

$pagina = "backup";
if (is_file("Vista/" . $pagina . ".php")) {
    $backups = consultarBackups();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}
?>