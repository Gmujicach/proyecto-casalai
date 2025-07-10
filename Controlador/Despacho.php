<?php  

function getdespacho() {
    $despacho = new Despacho();
    return $despacho->getdespacho();
}

if (!is_file("Modelo/" . $pagina . ".php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("Modelo/" . $pagina . ".php");
$k = new Despacho();
require_once 'Modelo/permiso.php';
require_once 'Modelo/bitacora.php';

define('MODULO_DESPACHO', 3);

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión
$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('despacho'));

if (is_file("vista/" . $pagina . ".php")) {
    $accion = $_POST['accion'] ?? '';

    if (!empty($_POST)) {
        switch ($accion) {
            case 'listado':
                $respuesta = $k->listadoproductos();
                echo json_encode($respuesta);
                break;

            case 'registrar':
                $k->setidcliente($_POST['cliente']);
                $k->setcorrelativo($_POST['correlativo']);
                $productos = $_POST['producto'] ?? [];
                $cantidades = $_POST['cantidad'] ?? [];
                $respuesta = $k->registrar($productos, $cantidades);

                // Obtener la lista actualizada de despachos
                $despachos = $respuesta['despachos'] ?? getdespacho();

                // Agrupar productos por despacho
                $productosPorDespacho = [];
                foreach ($despachos as $fila) {
                    $id = $fila['id_despachos'];
                    if (!isset($productosPorDespacho[$id])) {
                        $productosPorDespacho[$id] = [];
                    }
                    $productosPorDespacho[$id][] = [
                        'id_producto' => $fila['id_producto'],
                        'cantidad' => $fila['cantidad'],
                        'id_detalle' => $fila['id_detalle'] ?? '',
                    ];
                }

                // Generar el HTML del tbody
                ob_start();
            
// Agrupar productos por despacho
$productosPorDespacho = [];
foreach ($despachos as $fila) {
    $id = $fila['id_despachos'];
    if (!isset($productosPorDespacho[$id])) {
        $productosPorDespacho[$id] = [];
    }
    $productosPorDespacho[$id][] = [
        'id_producto' => $fila['id_producto'],
        'cantidad' => $fila['cantidad'],
        'id_detalle' => $fila['id_detalle'] ?? '', // si tienes iddetalle
        // agrega más campos si necesitas
    ];
}
?>
<?php

usort($despachos, function($a, $b) {
    if ($a['fecha_despacho'] == $b['fecha_despacho']) {
        if ($a['correlativo'] == $b['correlativo']) {
            if ($a['nombre_cliente'] == $b['nombre_cliente']) {
                return strcmp($a['nombre_producto'], $b['nombre_producto']);
            }
            return strcmp($a['nombre_cliente'], $b['nombre_cliente']);
        }
        return strcmp($a['correlativo'], $b['correlativo']);
    }
    return strcmp($a['fecha_despacho'], $b['fecha_despacho']);
});

// Agrupar para rowspan
$rowspans = [];
foreach ($despachos as $despacho) {
    $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
    if (!isset($rowspans[$key])) {
        $rowspans[$key] = 1;
    } else {
        $rowspans[$key]++;
    }
}
$rendered = [];
foreach ($despachos as $despacho):
    $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
    $id = $despacho['id_despachos'];
?>
<tr>
    <?php if (!in_array($key, $rendered)): ?>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['fecha_despacho']) ?></td>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['correlativo']) ?></td>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['nombre_cliente']) ?></td>
    <?php endif; ?>

    <td><?= htmlspecialchars($despacho['nombre_producto']) ?></td>
    <td><?= htmlspecialchars($despacho['cantidad']) ?></td>

    <?php if (!in_array($key, $rendered)): ?>
        <td rowspan="<?= $rowspans[$key] ?>">
            <button class="btn-modificar"
                data-bs-toggle="modal"
                data-bs-target="#modalModificar"
                data-iddespacho="<?= htmlspecialchars($despacho['id_despachos']) ?>"
                data-correlativo="<?= htmlspecialchars($despacho['correlativo']) ?>"
                data-fecha="<?= htmlspecialchars($despacho['fecha_despacho']) ?>"
                data-cliente="<?= htmlspecialchars($despacho['id_clientes']) ?>"
                data-productos='<?= json_encode($productosPorDespacho[$id], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                Modificar
            </button>
        </td>
        <?php $rendered[] = $key; ?>
    <?php endif; ?>
</tr>
<?php endforeach;            

$tbody = ob_get_clean();

                $bitacoraModel->registrarAccion(
                    'Creación de despacho: ' . $_POST['correlativo'], 
                    MODULO_DESPACHO,
                    $_SESSION['id_usuario']
                );

                echo json_encode([
                    'resultado' => 'registrar',
                    'mensaje' => $respuesta['mensaje'],
                    'tbody' => $tbody
                ]);
                break;

            case 'buscar':
                $correlativo = $_POST['correlativo'] ?? null;
                $k->setcorrelativo($correlativo);
                $respuesta = $k->buscar();
                if (!$respuesta) {
                    echo json_encode([
                        "resultado" => "no_encontro",
                        "mensaje" => "No se encontró el correlativo: " . $correlativo
                    ]);
                } else {
                    echo json_encode($respuesta);
                }
                break;
case 'permisos_tiempo_real':
    header('Content-Type: application/json; charset=utf-8');
    $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('despacho'));
    echo json_encode($permisosActualizados);
    exit;
            case 'obtener_detalles':
                $idDespacho = $_POST['id_despachos'] ?? null;
                if ($idDespacho) {
                    $respuesta = $k->obtenerDetallesPorDespacho($idDespacho);
                    echo json_encode($respuesta);
                } else {
                    echo json_encode(['error' => true, 'mensaje' => 'ID de recepción no recibido']);
                }
                break;

            case 'modificarRecepcion':
                $idDespacho = $_POST['id_recepcion'] ?? null;
                $idproducto = $_POST['productos'] ?? [];
                $cantidad = $_POST['cantidades'] ?? [];
                $iddetalle = $_POST['iddetalles'] ?? [];

                $k->setidcliente($_POST['proveedor']);
                $k->setcorrelativo($_POST['correlativo']);
                $k->setfecha($_POST['fecha']);

                if ($idDespacho) {
                    $respuesta = $k->modificarDespacho(
                        $idDespacho,
                        $idproducto,
                        $cantidad,
                        $iddetalle
                    );
                    // Obtener la lista actualizada de despachos
                    $despachos = $respuesta['despachos'] ?? getdespacho();

                    // Agrupar productos por despacho
                    $productosPorDespacho = [];
                    foreach ($despachos as $fila) {
                        $id = $fila['id_despachos'];
                        if (!isset($productosPorDespacho[$id])) {
                            $productosPorDespacho[$id] = [];
                        }
                        $productosPorDespacho[$id][] = [
                            'id_producto' => $fila['id_producto'],
                            'cantidad' => $fila['cantidad'],
                            'id_detalle' => $fila['id_detalle'] ?? '',
                        ];
                    }

                    ob_start();


// Agrupar productos por despacho
$productosPorDespacho = [];
foreach ($despachos as $fila) {
    $id = $fila['id_despachos'];
    if (!isset($productosPorDespacho[$id])) {
        $productosPorDespacho[$id] = [];
    }
    $productosPorDespacho[$id][] = [
        'id_producto' => $fila['id_producto'],
        'cantidad' => $fila['cantidad'],
        'id_detalle' => $fila['id_detalle'] ?? '', // si tienes iddetalle
        // agrega más campos si necesitas
    ];
}
?>
<?php

usort($despachos, function($a, $b) {
    if ($a['fecha_despacho'] == $b['fecha_despacho']) {
        if ($a['correlativo'] == $b['correlativo']) {
            if ($a['nombre_cliente'] == $b['nombre_cliente']) {
                return strcmp($a['nombre_producto'], $b['nombre_producto']);
            }
            return strcmp($a['nombre_cliente'], $b['nombre_cliente']);
        }
        return strcmp($a['correlativo'], $b['correlativo']);
    }
    return strcmp($a['fecha_despacho'], $b['fecha_despacho']);
});

// Agrupar para rowspan
$rowspans = [];
foreach ($despachos as $despacho) {
    $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
    if (!isset($rowspans[$key])) {
        $rowspans[$key] = 1;
    } else {
        $rowspans[$key]++;
    }
}
$rendered = [];
foreach ($despachos as $despacho):
    $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
    $id = $despacho['id_despachos'];
?>
<tr>
    <?php if (!in_array($key, $rendered)): ?>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['fecha_despacho']) ?></td>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['correlativo']) ?></td>
        <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['nombre_cliente']) ?></td>
    <?php endif; ?>

    <td><?= htmlspecialchars($despacho['nombre_producto']) ?></td>
    <td><?= htmlspecialchars($despacho['cantidad']) ?></td>

    <?php if (!in_array($key, $rendered)): ?>
        <td rowspan="<?= $rowspans[$key] ?>">
            <button class="btn-modificar"
                data-bs-toggle="modal"
                data-bs-target="#modalModificar"
                data-iddespacho="<?= htmlspecialchars($despacho['id_despachos']) ?>"
                data-correlativo="<?= htmlspecialchars($despacho['correlativo']) ?>"
                data-fecha="<?= htmlspecialchars($despacho['fecha_despacho']) ?>"
                data-cliente="<?= htmlspecialchars($despacho['id_clientes']) ?>"
                data-productos='<?= json_encode($productosPorDespacho[$id], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                Modificar
            </button>
        </td>
        <?php $rendered[] = $key; ?>
    <?php endif; ?>
</tr>
<?php endforeach; 

                    $tbody = ob_get_clean();

                    $bitacoraModel->registrarAccion(
                        'Actualización de despacho: ' . $_POST['correlativo'], 
                        MODULO_DESPACHO,
                        $_SESSION['id_usuario']
                    );

                    echo json_encode([
                        'status' => 'success',
                        'message' => $respuesta['mensaje'],
                        'tbody' => $tbody
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'ID de despacho faltante']);
                }
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida '.$accion.'']);
        }

        exit;
    }

    // Vista inicial
    $despachos = getdespacho();
    $proveedores = $k->obtenercliente();
    $productos = $k->consultarproductos();
// Total de despachos
$totalDespachos = count($despachos);

// Total de productos despachados y agrupados por producto
$productosDespachados = [];
foreach ($despachos as $d) {
    $nombre = $d['nombre_producto'];
    $cantidad = (int)$d['cantidad'];
    if (!isset($productosDespachados[$nombre])) {
        $productosDespachados[$nombre] = 0;
    }
    $productosDespachados[$nombre] += $cantidad;
}
$totalProductosDespachados = array_sum($productosDespachados);
    require_once("vista/" . $pagina . ".php");
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de despacho', MODULO_DESPACHO, $_SESSION['id_usuario']);
    }   
} else {
    echo "pagina en construccion";
}
?>