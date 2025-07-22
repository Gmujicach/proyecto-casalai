<?php
require_once('config/config.php');
require_once('modelo/permiso.php');

$id_rol = $_SESSION['id_rol'];
$nombre_rol = $_SESSION['nombre_rol'] ?? '';

$permisosObj = new Permisos();

$modulos = [
    'Usuario' => ['Gestionar Usuario', 'img/users-round.svg', '?pagina=usuario'],
    'Recepcion' => ['Gestionar Recepcion', 'img/package-open.svg', '?pagina=recepcion'],
    'Despacho' => ['Gestionar Despacho', 'img/package-check.svg', '?pagina=despacho'],
    'Marcas' => ['Gestionar Marcas', 'img/package-search.svg', '?pagina=marca'],
    'Modelos' => ['Gestionar Modelos', 'img/package-search.svg', '?pagina=modelo'],
    'Productos' => ['Gestionar Productos', 'img/package-search.svg', '?pagina=producto'],
    'Categorias' => ['Gestionar Categorias', 'img/package-search.svg', '?pagina=categoria'],
    'Proveedores' => ['Gestionar Proveedores', 'img/truck.svg', '?pagina=proveedor'],
    'Clientes' => ['Gestionar Clientes', 'img/users-round.svg', '?pagina=cliente'],
    'Catalogo' => ['Gestionar Catálogo', 'img/book-open.svg', '?pagina=catalogo'],
    'carrito' => ['Gestionar Carrito de Compras', 'img/shopping-cart.svg', '?pagina=carrito'],
    'pasarela' => ['Gestionar Pasarela de Pagos', 'img/credit-card.svg', '?pagina=pasarela'],
    'Prefactura' => ['Gestionar Pre-Factura', 'img/receipt-text.svg', '?pagina=gestionarfactura'],
    'Ordenes de despacho' => ['Gestionar Ordenes de Despacho', 'img/list-ordered.svg', '?pagina=ordendespacho'],
    'Cuentas bancarias' => ['Gestionar Cuentas Bancarias', 'img/landmark.svg', '?pagina=cuenta'],
    'Finanzas' => ['Gestionar Ingresos y Egresos', 'img/dollar-sign.svg', '?pagina=finanza'],
    'permisos' => ['Gestionar Permisos', 'img/key-round.svg', '?pagina=permiso'],
    'Roles' => ['Gestionar Roles', 'img/user-round-search.svg', '?pagina=rol'],
    'bitacora' => ['Gestionar Bitácora', 'img/notebook.svg', '?pagina=bitacora'],
    'Respaldo' => ['Gestionar Respaldo', 'img/files.svg', '?pagina=backup'],
];

$permisosConsulta = [];
foreach ($modulos as $moduloBD => $info) {
    $permisosConsulta[$moduloBD] = $permisosObj->getPermisosUsuarioModulo($id_rol, $moduloBD)['ingresar'] ?? false;
}

if ($nombre_rol === 'SuperUsuario') {
    foreach ($permisosConsulta as &$permiso) $permiso = true;
    unset($permiso);
}

$bd_navbar = new BD('S');
$pdo_navbar = $bd_navbar->getConexion();
$query = "SELECT b.*, m.nombre_modulo, u.nombres FROM tbl_bitacora b JOIN tbl_modulos m ON b.id_modulo = m.id_modulo JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario ORDER BY b.fecha_hora DESC LIMIT 5";
$stmt = $pdo_navbar->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notificaciones_count = is_array($result) ? count($result) : 0;
?>

<aside class="sidebar">
    <div class="headmenu">
        <img src="img/logo.png" alt="logo">
        <h2><span>Casa Lai</span></h2>
    </div>

    <div class="campana" onclick="toggleNotification()">
        <img src="img/campana.svg" alt="">
        <span class="campana"><?php echo $notificaciones_count; ?></span>
    </div>

    <div class="notificacion" id="contenedor-notificacion">
        <h2>Notificaciones <span><?php echo $notificaciones_count; ?></span></h2>
        <?php if ($notificaciones_count > 0): ?>
            <?php foreach ($result as $row): ?>
                <div class="item-notificacion">
                    <div class="texto">
                        <img src="img/usuario_circulo.svg" alt="img">
                        <h4><?= htmlspecialchars($row['nombres']) ?></h4>
                        <p><?= htmlspecialchars($row['accion']) . ' en ' . htmlspecialchars($row['nombre_modulo']) ?></p>
                        <small><?= date('d/m/Y H:i', strtotime($row['fecha_hora'])) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="item-notificacion">
                <div class="texto">
                    <p>No hay notificaciones recientes</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <ul class="menu-link">


        <?php

        if (in_array($nombre_rol, ['Cliente'])) {
            $modulos = [
    'Catalogo' => ['Catálogo', 'img/book-open.svg', '?pagina=catalogo'],
    'carrito' => ['Carrito de Compras', 'img/shopping-cart.svg', '?pagina=carrito'],
    'pasarela' => ['Pasarela de Pagos', 'img/credit-card.svg', '?pagina=pasarela'],
    'Prefactura' => ['Pre-Factura', 'img/receipt-text.svg', '?pagina=gestionarfactura'],
];

$permisosConsulta = [];
foreach ($modulos as $moduloBD => $info) {
    $permisosConsulta[$moduloBD] = $permisosObj->getPermisosUsuarioModulo($id_rol, $moduloBD)['ingresar'] ?? false;
}
        $secciones = [
            'Compras' => ['Catalogo', 'carrito', 'pasarela', 'Prefactura', 'Ordenes de despacho'],
        ];

        foreach ($secciones as $titulo => $mods) {
            $hayModulo = false;
            foreach ($mods as $mod) {
                if (!empty($permisosConsulta[$mod])) {
                    $hayModulo = true;
                    break;
                }
            }
            if ($hayModulo) {
                echo '<h4><span>' . $titulo . '</span><div class="menu-separador"></div></h4>';
                foreach ($mods as $mod) {
                    if (!empty($permisosConsulta[$mod])) {
                        echo '<li><a href="' . $modulos[$mod][2] . '"><span class="simbolo"><img src="' . $modulos[$mod][1] . '" class="icono-svg" />' . $modulos[$mod][0] . '</span></a></li>';
                    }
                }
            }
        }
        }else{
            ?>
                    <h4><span>Menu Principal</span><div class="menu-separador"></div></h4>
        <li>
            <a href="?pagina=dashboard">
                <span class="simbolo">
                    <img src="img/house.svg" alt="dashboard" class="icono-svg" /> Dashboard
                </span>
            </a>
        </li>

       <?php
        $secciones = [
            'Administrar Perfiles' => ['Usuario'],
            'Administrar Inventario' => ['Recepcion', 'Despacho'],
            'Administrar Productos' => ['Marcas', 'Modelos', 'Productos', 'Categorias'],
            'Administrar Proveedores' => ['Proveedores'],
            'Administrar Clientes' => ['Clientes'],
            'Administrar Ventas' => ['Catalogo', 'carrito', 'pasarela', 'Prefactura', 'Ordenes de despacho'],
            'Administrar Finanzas' => ['Cuentas bancarias', 'Finanzas'],
            'Administrar Seguridad' => ['permisos', 'Roles', 'bitacora', 'Respaldo'],
        ];

        foreach ($secciones as $titulo => $mods) {
            $hayModulo = false;
            foreach ($mods as $mod) {
                if (!empty($permisosConsulta[$mod])) {
                    $hayModulo = true;
                    break;
                }
            }
            if ($hayModulo) {
                echo '<h4><span>' . $titulo . '</span><div class="menu-separador"></div></h4>';
                foreach ($mods as $mod) {
                    if (!empty($permisosConsulta[$mod])) {
                        echo '<li><a href="' . $modulos[$mod][2] . '"><span class="simbolo"><img src="' . $modulos[$mod][1] . '" class="icono-svg" />' . $modulos[$mod][0] . '</span></a></li>';
                    }
                }
            }
        }

        if (in_array($nombre_rol, ['Administrador', 'SuperUsuario', 'Cliente'])) {
            echo '<h4><span>Solicitar Ayuda</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="public/casalai-manual/index.php"><span class="simbolo"><img src="img/user-round-search.svg" class="icono-svg" />Manual de Usuarios</span></a></li>';
        }

        if (in_array($nombre_rol, ['SuperUsuario'])) {
            echo '<li><a href="?pagina=backup"><span class="simbolo"><img src="img/files.svg" class="icono-svg" />Gestionar Respaldo</span></a></li>';
        }
         }
        ?>

        <h4><span>Cuenta</span><div class="menu-separador"></div></h4>
        <li><a href="#"><span class="simbolo"><img src="img/circle-user-round.svg" class="icono-svg" />Perfil</span></a></li>
        <li><a href='?pagina=cerrar'><span class="simbolo"><img src="img/log-out.svg" class="icono-svg" />Cerrar Sesión</span></a></li>
    </ul>

    <div class="user-cuenta">
        <div class="user-perfil">
            <img src="img/avatar.png" alt="perfil-img">
            <div class="user-detalle">
                <h3><?php echo htmlspecialchars($_SESSION['name'] ?? 'Invitado'); ?></h3>
                <span><?php echo htmlspecialchars($_SESSION['nombre_rol'] ?? 'Usuario'); ?></span>
            </div>
        </div>
    </div>
</aside>
