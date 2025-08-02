<?php  

function getdespacho() {
    $despacho = new Compra();
    return $despacho->getdespacho();
}

if (!is_file("modelo/" . $pagina . ".php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("modelo/" . $pagina . ".php");
$k = new Compra();
require_once 'modelo/permiso.php';
require_once 'modelo/ordendespacho.php';
require_once 'modelo/bitacora.php';
require_once 'modelo/cuenta.php';

define('MODULO_DESPACHO', 3);

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión
$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$cuentaModel = new Cuentabanco();
$despacho = new OrdenDespacho();
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
    // 🔹 Validar datos obligatorios
    $idCliente = $_POST['cliente'] ?? null;
    $correlativo = $_POST['correlativo'] ?? null;
    $productos = $_POST['producto'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];
    $pagos = $_POST['pagos'] ?? [];
    $montoTotal = $_POST['monto_total'] ?? 0;
    $cambio = $_POST['cambio_efectivo'] ?? 0;

    if (!$idCliente || !$correlativo || empty($productos)) {
        echo json_encode(['status' => 'error', 'mensaje' => 'Faltan datos obligatorios']);
        exit;
    }
    $k->setcorrelativo($correlativo);
                $respuesta = $k->buscar();
    if ($respuesta) {
                echo json_encode(['resultado' => 'encontro', 'mensaje' => 'Este correlativo ya existe, por favor, ingrese otro']);
            } else {
    // 🔹 Setear datos principales en el modelo
    $k->setidcliente($idCliente);
    $k->setcorrelativo($correlativo);

    // 🔹 Preparar lista de productos
    $detalleProductos = [];
    foreach ($productos as $i => $prod) {
        $detalleProductos[] = [
            'id_producto' => $prod,
            'cantidad' => $cantidades[$i] ?? 0
        ];
    }

    // 🔹 Preparar lista de pagos
    $detallePagos = [];
    foreach ($pagos as $idx => $pago) {
        $detalle = [
            'tipo' => $pago['tipo'] ?? '',
            'cuenta' => $pago['cuenta'] ?? '',
            'referencia' => $pago['referencia'] ?? '',
            'fecha' => $pago['fecha'] ?? '',
            'monto' => $pago['monto'] ?? 0
        ];

        // 🔹 Procesar comprobante (si existe archivo subido)
        if (!empty($_FILES['pagos']['name'][$idx]['comprobante'])) {
            $tmpName = $_FILES['pagos']['tmp_name'][$idx]['comprobante'];
            $fileName = time() . '_' . basename($_FILES['pagos']['name'][$idx]['comprobante']);
            $uploadDir = "uploads/comprobantes/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            move_uploaded_file($tmpName, $uploadDir . $fileName);
            $detalle['comprobante'] = $uploadDir . $fileName;
        } else {
            $detalle['comprobante'] = null;
        }

        $detallePagos[] = $detalle;
    }

    // 🔹 Registrar compra en el modelo
    $resultado = $k->registrarCompraFisica([
        'cliente' => $idCliente,
        'correlativo' => $correlativo,
        'monto_total' => $montoTotal,
        'cambio' => $cambio,
        'productos' => $detalleProductos,
        'pagos' => $detallePagos
    ]);

    // 🔹 Registrar en bitácora
    $bitacoraModel->registrarAccion(
        "Registro de compra física (Correlativo: $correlativo)",
        MODULO_DESPACHO,
        $_SESSION['id_usuario']
    );

    echo json_encode($resultado);
}
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

    // vista inicial
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
 $listadocuentas = $cuentaModel->consultarCuentabanco();
$totalProductosDespachados = array_sum($productosDespachados);
    require_once("vista/" . $pagina . ".php");
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de despacho', MODULO_DESPACHO, $_SESSION['id_usuario']);
    }   
} else {
    echo "pagina en construccion";
}
?>