<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../modelo/backup.php';

if (isset($_GET['accion'])) {

if ($_GET['accion'] === 'generar') {
    $tipo = isset($_GET['tipo']) && $_GET['tipo'] === 'S' ? 'S' : 'P';
    $backup = new Backup($tipo);
    $nombreArchivo = 'backup_' . ($tipo === 'S' ? 'seguridad' : 'principal') . '_' . date('Ymd_His') . '.sql';
    $ok = $backup->generar($nombreArchivo);
    $ruta = realpath(__DIR__ . '/../DB/backup/' . $nombreArchivo);
    header('Content-Type: application/json');
    if ($ok && file_exists($ruta)) {
        echo json_encode(['success' => true, 'archivo' => $nombreArchivo]);
    } else {
        $logFile = __DIR__ . '/../DB/backup/backup_debug.log';
        $logMsg = '';
        if (file_exists($logFile)) {
            $logMsg = file_get_contents($logFile);
        }
        echo json_encode([
            'success' => false,
            'error' => 'Error al generar el respaldo.',
            'debug' => $logMsg
        ]);
    }
    exit;
}

    // ... resto del código igual ...


    if ($_GET['accion'] === 'descargar') {
        $archivo = $_GET['archivo'] ?? '';
        $ruta = realpath(__DIR__ . '/../DB/backup/' . $archivo);
        if ($archivo && file_exists($ruta)) {
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
            header('Content-Length: ' . filesize($ruta));
            readfile($ruta);
            exit;
        } else {
            echo "Archivo no encontrado";
            exit;
        }
    }

    if ($_GET['accion'] === 'restaurar') {
        $archivo = $_GET['archivo'] ?? '';
        $ruta = realpath(__DIR__ . '/../DB/backup/' . $archivo);
        header('Content-Type: application/json');
        if ($archivo && file_exists($ruta)) {
            $backup = new Backup();
            $ok = $backup->restaurar($archivo);
            if ($ok) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al restaurar']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Archivo no encontrado']);
        }
        exit;
    }
}

// Renderizado de la vista
$pagina = "backup";
if (is_file("vista/" . $pagina . ".php")) {
    $backup = new Backup();
    $backups = $backup->listar();
    require_once("vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}
?>