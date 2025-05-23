<?php
ob_start();
require_once 'Modelo/finanza.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar_ingreso':
            $id_despacho = $_POST['id_despacho'];
            $finanza = new Finanza();
            $ok = $finanza->registrarIngreso($id_despacho);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
            exit;

        case 'registrar_egreso':
            $id_recepcion = $_POST['id_recepcion'];
            $finanza = new Finanza();
            $ok = $finanza->registrarEgreso($id_recepcion);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
            exit;

        case 'anular':
            $id_finanzas = $_POST['id_finanzas'];
            $finanza = new Finanza();
            $ok = $finanza->anularRegistro($id_finanzas);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            exit;
    }
}

// Consulta automática para la vista
function consultarFinanzas() {
    $finanza = new Finanza();
    return [
        'ingresos' => $finanza->consultarIngresos(),
        'egresos' => $finanza->consultarEgresos()
    ];
}

$pagina = "finanza";
if (is_file("Vista/" . $pagina . ".php")) {
    $finanzas = consultarFinanzas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}