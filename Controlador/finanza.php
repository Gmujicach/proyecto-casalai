<?php
ob_start();
require_once 'modelo/finanza.php';

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
// Consulta automática para la vista
function consultarFinanzas() {
    $finanza = new Finanza();
    return [
        'ingresos' => $finanza->consultarIngresos(),
        'egresos' => $finanza->consultarEgresos()
    ];
}

$finanzas = consultarFinanzas(); // <-- PRIMERO OBTÉN LOS DATOS

// Agrupar ingresos y egresos por mes
function agruparPorMes($registros) {
    $res = [];
    foreach ($registros as $r) {
        $mes = date('Y-m', strtotime($r['fecha']));
        if (!isset($res[$mes])) $res[$mes] = 0;
        $res[$mes] += $r['monto'];
    }
    return $res;
}

$ingresosPorMes = agruparPorMes($finanzas['ingresos']);
$egresosPorMes = agruparPorMes($finanzas['egresos']);



$meses = array_unique(array_merge(array_keys($ingresosPorMes), array_keys($egresosPorMes)));
sort($meses);

$totalIngresos = array_sum(array_column($finanzas['ingresos'], 'monto'));
$totalEgresos = array_sum(array_column($finanzas['egresos'], 'monto'));

$pagina = "finanza";
if (is_file("vista/" . $pagina . ".php")) {
    require_once("vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}