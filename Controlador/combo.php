<?php
ob_start();
//session_start();
require_once './modelo/producto.php';
require_once './modelo/combo.php';
//require_once './modelo/producto.php';

//$productoModel = new Productos();
//$comboModel = new Combo();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'crear_combo') {
    try {
       // $combo = new Combo();
        $productos = json_decode($_POST['productos'], true);

        if (!is_array($productos) || empty($productos)) {
            throw new Exception("Lista de productos inválida");
        }

        // Crear nuevo combo (cabecera)
        $id_combo = $combo->crearNuevoCombo();
        if (!$id_combo) {
            throw new Exception("No se pudo crear el combo");
        }

        // Insertar productos (detalle)
        foreach ($productos as $p) {
            if (!isset($p['id']) || !isset($p['cantidad'])) {
                throw new Exception("Formato de producto inválido");
            }
            $combo->insertarProductoEnCombo($id_combo, $p['id'], $p['cantidad']);
        }

        // Obtener combos actualizados
        $combos = $combo->obtenerCombos();
        $comboInsertado = array_filter($combos, fn($c) => $c['id_combo'] == $id_combo);
        $comboInsertado = array_shift($comboInsertado);

        echo json_encode([
            'status' => 'success',
            'combo' => $comboInsertado
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

$pagina = "combo";
// Verifica si el archivo de vista existe
if (is_file("vista/" . $pagina . ".php")) {
    // Incluye el archivo de vista
    require_once("vista/" . $pagina . ".php");
} else {
    // Muestra un mensaje si la página está en construcción
    echo "Página en construcción";
}

ob_end_flush();
?>