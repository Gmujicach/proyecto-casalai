<?php
ob_start();
require_once 'Modelo/categoria.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

define('MODULO_CATEGORIA', 1);

$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();

$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('Categorias'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    switch ($accion) {
        case 'registrar':
            $categoria = new Categoria();
            $categoria->setNombreCategoria($_POST['nombre_categoria']);
            $caracteristicas = isset($_POST['caracteristicas']) ? $_POST['caracteristicas'] : [];

            if ($categoria->existeNombreCategoria($_POST['nombre_categoria'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la categoria ya existe'
                ]);
                exit;
            }

            if ($categoria->registrarCategoria($caracteristicas)) {
                $categoriaRegistrado = $categoria->obtenerUltimoCategoria();

                $bitacoraModel->registrarAccion(
                    'Creación de categoria: ' . $_POST['nombre_categoria'], 
                    MODULO_CATEGORIA, 
                    $_SESSION['id_usuario']
                );

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

            case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('categorias'));
            echo json_encode($permisosActualizados);
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
            $nuevo_nombre = $_POST['nombre_categoria'];
            $caracteristicas = isset($_POST['caracteristicas']) ? $_POST['caracteristicas'] : [];
            $categoria = new Categoria();
            $categoria->setIdCategoria($id_categoria);
            $categoria->setNombreCategoria($nuevo_nombre);

            if ($categoria->existeNombreCategoria($nuevo_nombre, $id_categoria)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la categoria ya existe'
                ]);
                exit;
            }

            if ($categoria->modificarCategoria($id_categoria, $nuevo_nombre, $caracteristicas)) {
                $categoriaActualizada = $categoria->obtenerCategoriaPorId($id_categoria);

                $bitacoraModel->registrarAccion(
                    'Actualización de categoria: ' . $_POST['nombre_categoria'], 
                    MODULO_CATEGORIA, 
                    $_SESSION['id_usuario']
                );

                echo json_encode([
                    'status' => 'success',
                    'categoria' => $categoriaActualizada
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la categoria']);
            }
            exit;

        case 'eliminar':
            $id_categoria = $_POST['id_categoria'];
            $categoria = new Categoria();
            $resultado = $categoria->eliminarCategoria($id_categoria);
            if (is_array($resultado) && isset($resultado['status']) && $resultado['status'] === 'error') {
                $bitacoraModel->registrarAccion(
                    'Eliminación de categoria: (ID: ' . $id_categoria . ')', 
                    MODULO_CATEGORIA, 
                    $_SESSION['id_usuario']
                );
                echo json_encode(['status' => 'error', 'message' => $resultado['mensaje']]);
            } else {
                echo json_encode(['status' => 'success']);
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
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de categoria', MODULO_CATEGORIA, $_SESSION['id_usuario']);
    }
    $categorias = consultarCategorias();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>