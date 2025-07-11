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
    'gestionarFactura' => ['Gestionar Pre-Factura', 'img/receipt-text.svg', '?pagina=gestionarfactura'],
    'Ordenes de despacho' => ['Gestionar Ordenes de Despacho', 'img/list-ordered.svg', '?pagina=ordendespacho'],
    'Cuentas bancarias' => ['Gestionar Cuentas Bancarias', 'img/landmark.svg', '?pagina=cuenta'],
    'finanza' => ['Gestionar Ingresos y Egresos', 'img/dollar-sign.svg', '?pagina=finanza'],
    'permisos' => ['Gestionar Permisos', 'img/key-round.svg', '?pagina=permiso'],
    'Roles' => ['Gestionar Roles', 'img/user-round-search.svg', '?pagina=rol'],
    'bitacora' => ['Gestionar Bitácora', 'img/notebook.svg', '?pagina=bitacora'],
];

$permisosConsulta = [];
foreach ($modulos as $moduloBD => $info) {
    $permisosConsulta[$moduloBD] = $permisosObj->getPermisosUsuarioModulo($id_rol, $moduloBD)['consultar'] ?? false;
}

if ($nombre_rol == 'SuperUsuario') {
    foreach ($permisosConsulta as $mod => &$permiso) {
        $permiso = true;
    }
    unset($permiso);
}

$bd_navbar = new BD('S');
$pdo_navbar = $bd_navbar->getConexion();
$query = "SELECT b.*, m.nombre_modulo, u.nombres 
          FROM tbl_bitacora b 
          JOIN tbl_modulos m ON b.id_modulo = m.id_modulo 
          JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario 
          ORDER BY b.fecha_hora DESC LIMIT 5";
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
        <?php
        if ($notificaciones_count > 0 && is_array($result)) {
            foreach ($result as $row) {
                $fecha = date('d/m/Y H:i', strtotime($row['fecha_hora']));
                $accion = $row['accion'];
                $modulo = $row['nombre_modulo'];
                $usuario = $row['nombres'];
                echo '<div class="item-notificacion">';
                echo '<div class="texto">';
                echo '<img src="img/usuario_circulo.svg" alt="img">';
                echo '<h4>'.$usuario.'</h4>';
                echo '<p>'.$accion.' en '.$modulo.'</p>';
                echo '<small>'.$fecha.'</small>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="item-notificacion">';
            echo '<div class="texto">';
            echo '<p>No hay notificaciones recientes</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <div>
<ul class="menu-link">
    <h4><span>Menu Principal</span><div class="menu-separador"></div></h4>
    <li>
        <a href="?pagina=dashboard">
            <span class="simbolo">
                <img src="img/house.svg" alt="dashboard" class="icono-svg" />
                Dashboard
            </span>
        </a>
    </li>

    <?php
    // SUPERUSUARIO: ve todos los módulos con títulos
    if ($nombre_rol == 'SuperUsuario') {
        // Perfiles
        echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=usuario"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';

        // Inventario
        echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=recepcion"><span class="simbolo"><img src="img/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
        echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="img/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';

        // Productos
        echo '<h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=marca"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Marcas</span></a></li>';
        echo '<li><a href="?pagina=modelo"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Modelos</span></a></li>';
        echo '<li><a href="?pagina=producto"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Productos</span></a></li>';
        echo '<li><a href="?pagina=categoria"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Categorias</span></a></li>';

        // Proveedores
        echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=proveedor"><span class="simbolo"><img src="img/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';

        // Clientes
        echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=cliente"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';

        // Ventas
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="img/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="img/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="img/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarfactura"><span class="simbolo"><img src="img/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
        echo '<li><a href="?pagina=ordendespacho"><span class="simbolo"><img src="img/list-ordered.svg" class="icono-svg" />Gestionar Ordenes de Despacho</span></a></li>';

        // Finanzas
        echo '<h4><span>Administrar Finanzas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=cuenta"><span class="simbolo"><img src="img/landmark.svg" class="icono-svg" />Gestionar Cuentas Bancarias</span></a></li>';
        echo '<li><a href="?pagina=finanza"><span class="simbolo"><img src="img/dollar-sign.svg" class="icono-svg" />Gestionar Ingresos y Egresos</span></a></li>';

        // Seguridad
        echo '<h4><span>Administrar Seguridad</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=permiso"><span class="simbolo"><img src="img/key-round.svg" class="icono-svg" />Gestionar Permisos</span></a></li>';
        echo '<li><a href="?pagina=rol"><span class="simbolo"><img src="img/user-round-search.svg" class="icono-svg" />Gestionar Roles</span></a></li>';
        echo '<li><a href="?pagina=bitacora"><span class="simbolo"><img src="img/notebook.svg" class="icono-svg" />Gestionar Bitácora</span></a></li>';
    }
    if ($nombre_rol == 'SuperUsuario') {
        // Perfiles
        echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=usuario"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';

        // Inventario
        echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=recepcion"><span class="simbolo"><img src="img/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
        echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="img/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';

        // Productos
        echo '<h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=marca"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Marcas</span></a></li>';
        echo '<li><a href="?pagina=modelo"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Modelos</span></a></li>';
        echo '<li><a href="?pagina=producto"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Productos</span></a></li>';
        echo '<li><a href="?pagina=categoria"><span class="simbolo"><img src="img/package-search.svg" class="icono-svg" />Gestionar Categorias</span></a></li>';

        // Proveedores
        echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=proveedor"><span class="simbolo"><img src="img/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';

        // Clientes
        echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=cliente"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';

        // Ventas
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="img/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="img/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="img/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarfactura"><span class="simbolo"><img src="img/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
}

    if ($nombre_rol == 'Cliente') {
  
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="img/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="img/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="img/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarfactura"><span class="simbolo"><img src="img/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
}
    // CLIENTE: solo puede ver catálogo, carrito, pasarela, prefactura
    else if ($nombre_rol == 'Cliente') {
        $cliente_modulos = ['Catalogo', 'carrito', 'pasarela', 'gestionarFactura'];
        foreach ($cliente_modulos as $mod) {
            if (!empty($permisosConsulta[$mod])) {
                echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
            }
            echo '<li><a href="?pagina=backup"><span class="simbolo"><img src="IMG/files.svg" class="icono-svg" />Gestionar Respaldo</span></a></li>';
        }
    } else {
        // ADMINISTRAR PERFILES (solo Admin y SuperUsuario)
        if (in_array($nombre_rol, ['Administrador', 'SuperUsuario']) && !empty($permisosConsulta['Usuario'])) {
            echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=usuario"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';
        }

        // ADMINISTRAR INVENTARIO (Admin y Almacenista)
        if (in_array($nombre_rol, ['Administrador', 'Almacenista'])) {
            if (!empty($permisosConsulta['Recepcion']) || !empty($permisosConsulta['Despacho'])) {
                echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
                if (!empty($permisosConsulta['Recepcion'])) {
                    echo '<li><a href="?pagina=recepcion"><span class="simbolo"><img src="img/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
                }
                if (!empty($permisosConsulta['Despacho'])) {
                    echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="img/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';
                }
            }
        }
        ?>

        <h4><span>Solicitar Ayuda</span><div class='menu-separador'></div></h4>
        <li><a href="Public/casalai-manual/index.php"><span class="simbolo"><img src="IMG/user-round-search.svg" class="icono-svg" />Manual de Usuarios</span></a></li>

        // ADMINISTRAR PROVEEDORES (solo Admin)
        if ($nombre_rol == 'Administrador' && !empty($permisosConsulta['Proveedores'])) {
            echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=proveedor"><span class="simbolo"><img src="img/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';
        
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="img/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
    }

        // ADMINISTRAR CLIENTES (Admin y Almacenista)
        if (in_array($nombre_rol, ['Administrador', 'Almacenista']) && !empty($permisosConsulta['Clientes'])) {
            echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=cliente"><span class="simbolo"><img src="img/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';
        }

        // ADMINISTRAR VENTAS (Admin)
        if ($nombre_rol == 'Administrador'  ) {
            $ventas = ['Catalogo', 'carrito', 'pasarela', 'gestionarFactura', 'Ordenes de despacho'];
            $hayVentas = false;
            foreach ($ventas as $mod) {
                if (!empty($permisosConsulta[$mod])) $hayVentas = true;
            }
            if ($hayVentas) {
                echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
                foreach ($ventas as $mod) {
                    if (!empty($permisosConsulta[$mod])) {
                        echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
                    }
                }
            }
        }
// ADMINISTRAR FINANZAS (solo Admin)
        if ($nombre_rol == 'Administrador' && (!empty($permisosConsulta['Cuentas bancarias']) || !empty($permisosConsulta['finanza']))) {
            echo '<h4><span>Administrar Finanzas</span><div class="menu-separador"></div></h4>';
            if (!empty($permisosConsulta['Cuentas bancarias'])) {
                echo '<li><a href="?pagina=cuenta"><span class="simbolo"><img src="img/landmark.svg" class="icono-svg" />Gestionar Cuentas Bancarias</span></a></li>';
            }
            if (!empty($permisosConsulta['finanza'])) {
                echo '<li><a href="?pagina=finanza"><span class="simbolo"><img src="img/dollar-sign.svg" class="icono-svg" />Gestionar Ingresos y Egresos</span></a></li>';
            }
        }

        
        // ADMINISTRAR SEGURIDAD (solo Admin y SuperUsuario)
        if (in_array($nombre_rol, ['Administrador', 'SuperUsuario'])) {
            $seguridad = ['permisos', 'Roles', 'bitacora'];
            $haySeguridad = false;
            foreach ($seguridad as $mod) {
                if (!empty($permisosConsulta[$mod])) $haySeguridad = true;
            }
            if ($haySeguridad) {
                echo '<h4><span>Administrar Seguridad</span><div class="menu-separador"></div></h4>';
                foreach ($seguridad as $mod) {
                    if (!empty($permisosConsulta[$mod])) {
                        echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
                    }
                }
            }
        }
        
    }
    ?>
<?php if (in_array($nombre_rol, ['Administrador', 'SuperUsuario'])): ?>
    <li><a href='?pagina=backup'><span class="simbolo"><img src="img/files.svg" class="icono-svg" />Gestionar Respaldo</span></a></li>
<?php endif; ?>

    <h4><span>Solicitar Ayuda</span><div class='menu-separador'></div></h4>;
    <li><a href="public/casalai-manual/index.php"><span class="simbolo"><img src="img/user-round-search.svg" class="icono-svg" />Manual de Usuarios</span></a></li>;
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
    </div>
</div>
</aside>
