<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'modelo/bitacora.php';
define('MODULO_BITACORA', 1);
$bitacoraModel = new Bitacora();

try {
    $registros = $bitacoraModel->obtenerRegistrosDetallados(500);
} catch (Exception $e) {
    $registros = [];
}

$pagina = "bitacora";
if (is_file("vista/" . $pagina . ".php")) {
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de bitacora', MODULO_BITACORA, $_SESSION['id_usuario']);
    }
    require_once("vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
