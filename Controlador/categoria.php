<?php
ob_start();
require_once 'Modelo/categoria.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $categoria = new Categoria();
            $categoria->setNombreCategoria($_POST['nombre_categoria']);

            if ($categoria->existeNombreCategoria($_POST['nombre_categoria'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la cartegoria ya existe'
                ]);
                exit;
            }

            if ($categoria->registrarCategoria()) {
                $categoriaRegistrado = $categoria->obtenerUltimoCategoria();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Categoria registrada correctamente',
                    'categoria' => $categoriaRegistrado
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar la categoria'
                ]);
            }
            exit;
        
        case 'consultar_categorias':
            $categoria = new Categoria();
            $categorias_obt = $categoria->consultarCategorias();

            echo json_encode($categorias_obt);
            exit;
        
        case 'obtener_categoria':
            $id_categoria = $_POST['id_categoria'];

            if ($id_categoria !== null) {
                $categoria = new Categoria();
                $categoria_obt = $categoria->obtenerCategoriaPorId($id_categoria);

                if ($categoria_obt !== null) {
                    echo json_encode($categoria_obt);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Categoria no encontrada']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de la categoria no proporcionada']);
            }
            exit;

        case 'modificar':
            $id_categoria  = $_POST['id_categoria'];
            $categoria = new Categoria();
            $categoria->setIdCategoria($id_categoria);
            $categoria->setNombreCategoria($_POST['nombre_categoria']);
            
            if ($categoria->existeNombreCategoria($_POST['nombre_categoria'], $id_categoria)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la categoria ya existe'
                ]);
                exit;
            }
            
            if ($categoria->modificarCategoria($id_categoria)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la categoria']);
            }
            exit;

        case 'eliminar':
            $id_categoria = $_POST['id_categoria'];
            $categoria = new Categoria();

            if ($categoria->eliminarCategoria($id_categoria)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la categoria']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
}

function consultarCategorias() {
    $categoria = new Categoria();
    return $categoria->consultarCategorias();
}

$pagina = "categoria";
if (is_file("Vista/" . $pagina . ".php")) {
    $categorias = consultarCategorias();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>