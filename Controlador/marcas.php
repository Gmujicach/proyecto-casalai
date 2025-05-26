<?php
ob_start();

require_once 'Modelo/marcas.php';
require_once 'Modelo/Paginador.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            header('Content-Type: application/json; charset=utf-8');
            $marca = new marca();
            $marca->setnombre_marca($_POST['nombre_marca']);
            
            if ($marca->existeNumeroMarca($_POST['nombre_marca'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la marca ya existe'
                ]);
                exit;
            }

            if ($marca->ingresarmarcas()) {
                $marcaRegistrada = $marca->obtenerUltimaMarca();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Marca registrada correctamente',
                    'marca' => $marcaRegistrada
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar la marca'
                ]);
            }
            exit;

        case 'obtener_marcas':
            $id = $_POST['id_marca'];
            if ($id !== null) {
                $marca = new marca();
                $marca = $marca->obtenermarcasPorId($id);
                if ($marca !== null) {
                    echo json_encode($marca);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Marca no encontrada']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de Marca no proporcionado']);
            }
            exit;

        case 'modificar':
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            $id = $_POST['id_marca'];
            $marca = new marca();
            $marca->setId($id);
            $marca->setnombre_marca($_POST['nombre_marca']);

            if ($marca->existeNumeroMarca($_POST['nombre_marca'], $id_marca)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la marca ya existe'
                ]);
                exit;
            }
            
            if ($marca->modificarmarcas($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la marca']);
            }
            exit;

        case 'eliminar':
            $id = $_POST['id'];
            $marcaModel = new marca();
            if ($marcaModel->eliminarmarcas($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la marca']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        break;
    }
}


function getmarcas() {
    $marca = new marca();
    return $marca->getmarcas();
}

$pagina = "Marcas";
if (is_file("Vista/" . $pagina . ".php")) {

    $paginaActual = $_GET['pagina'] ?? 1;
    $filasPorPagina = $_GET['filas'] ?? 10;
    
    // Crear instancia del paginador
    $paginador = new Paginador(); // Asegúrate de tener $this->conex disponible
    
    // Obtener datos paginados
    $resultados = $paginador->paginar(
        'tbl_marcas', // Cambia por 'tbl_marcas' si es necesario
        $paginaActual,
        $filasPorPagina
    );
    
    // Calcular valores para la vista
    $paginaActual = intval($paginaActual); // Asegura que sea un número entero
    $inicio = ($paginaActual - 1) * $filasPorPagina + 1;
    $fin = min($paginaActual * $filasPorPagina, $resultados['total']);
    $totalMarcas = $resultados['total'];
    
    // Pasar a la vista
    $datosVista = [
        'marcas' => $resultados['datos'], // Cambia por 'marcas' si es necesario
        'inicio' => $inicio,
        'fin' => $fin,
        'totalUsuarios' => $totalMarcas, // Cambia por 'totalMarcas' si es necesario
        'paginaActual' => $paginaActual,
        'filasPorPagina' => $filasPorPagina
    ];

    $marcas = getmarcas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>