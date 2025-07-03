<?php
require_once __DIR__ . '/../Modelo/backup.php';

// Enrutamiento para AJAX
if (isset($_GET['accion'])) {
    $tipo = $_POST['tipo'] ?? $_GET['tipo'] ?? 'P';
    $backup = new Backup($tipo);

    if ($_GET['accion'] === 'generar') {
        $nombreArchivo = 'backup_' . strtolower($tipo) . '_' . date('Ymd_His') . '.sql';
        $archivo = $backup->generar($nombreArchivo);
        echo json_encode(['success' => $archivo !== false, 'archivo' => $archivo]);
        exit;
    }

    if ($_GET['accion'] === 'restaurar') {
        $archivo = $_POST['archivo'] ?? $_GET['archivo'] ?? '';
        $ok = $backup->restaurar($archivo);
        echo json_encode(['success' => $ok]);
        exit;
    }

    if ($_GET['accion'] === 'consultar') {
        $archivos = $backup->listar();
        echo json_encode($archivos);
        exit;
    }
}

// Renderizado de la vista (para acceso normal)
$pagina = "backup";
if (is_file("Vista/" . $pagina . ".php")) {
    $backup = new Backup();
    $backups = $backup->listar();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}
?>