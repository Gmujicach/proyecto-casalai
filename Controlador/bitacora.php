<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Modelo/bitacora.php';
define('MODULO_BITACORA', 1);
$bitacoraModel = new Bitacora();

try {
    $registros = $bitacoraModel->obtenerRegistrosDetallados(500);
} catch (Exception $e) {
    $registros = [];
}

$pagina = "bitacora";
if (is_file("Vista/" . $pagina . ".php")) {
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de bitacora', MODULO_BITACORA, $_SESSION['id_usuario']);
    }
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
