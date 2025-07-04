<?php
require_once('Config/Config.php');
require_once('Modelo/Permisos.php');

$id_rol = $_SESSION['id_rol'];
$nombre_rol = $_SESSION['nombre_rol'] ?? '';

$permisosObj = new Permisos();

// Mapeo de módulos: nombre en BD => [etiqueta, ícono, url]
$modulos = [
    'Usuario' => ['Gestionar Usuario', 'IMG/users-round.svg', '?pagina=Usuarios'],
    'Recepcion' => ['Gestionar Recepcion', 'IMG/package-open.svg', '?pagina=Recepcion'],
    'Despacho' => ['Gestionar Despacho', 'IMG/package-check.svg', '?pagina=despacho'],
    'Marcas' => ['Gestionar Marcas', 'IMG/package-search.svg', '?pagina=marcas'],
    'Modelos' => ['Gestionar Modelos', 'IMG/package-search.svg', '?pagina=modelos'],
    'Productos' => ['Gestionar Productos', 'IMG/package-search.svg', '?pagina=Productos'],
    'Categorias' => ['Gestionar Categorias', 'IMG/package-search.svg', '?pagina=categoria'],
    'Proveedores' => ['Gestionar Proveedores', 'IMG/truck.svg', '?pagina=proveedores'],
    'Clientes' => ['Gestionar Clientes', 'IMG/users-round.svg', '?pagina=clientes'],
    'Catalogo' => ['Gestionar Catálogo', 'IMG/book-open.svg', '?pagina=catalogo'],
    'carrito' => ['Gestionar Carrito de Compras', 'IMG/shopping-cart.svg', '?pagina=carrito'],
    'pasarela' => ['Gestionar Pasarela de Pagos', 'IMG/credit-card.svg', '?pagina=pasarela'],
    'gestionarFactura' => ['Gestionar Pre-Factura', 'IMG/receipt-text.svg', '?pagina=gestionarFactura'],
    'Ordenes de despacho' => ['Gestionar Ordenes de Despacho', 'IMG/list-ordered.svg', '?pagina=OrdenDespacho'],
    'Cuentas bancarias' => ['Gestionar Cuentas Bancarias', 'IMG/landmark.svg', '?pagina=cuentas'],
    'finanza' => ['Gestionar Ingresos y Egresos', 'IMG/dollar-sign.svg', '?pagina=finanza'],
    'permisos' => ['Gestionar Permisos', 'IMG/key-round.svg', '?pagina=permisos'],
    'Roles' => ['Gestionar Roles', 'IMG/user-round-search.svg', '?pagina=rol'],
    'bitacora' => ['Gestionar Bitácora', 'IMG/notebook.svg', '?pagina=bitacora'],
];

// Cargar permisos de consulta para cada módulo
$permisosConsulta = [];
foreach ($modulos as $moduloBD => $info) {
    $permisosConsulta[$moduloBD] = $permisosObj->getPermisosUsuarioModulo($id_rol, $moduloBD)['consultar'] ?? false;
}

// Notificaciones
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
        <img src="img/LOGO.png" alt="logo">
        <h2><span>Casa Lai</span></h2>
    </div>

    <div class="campana" onclick="toggleNotification()">
        <img src="IMG/campana.svg" alt="">
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
                echo '<img src="IMG/usuario_circulo.svg" alt="img">';
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
        <a href="?pagina=Dashboard">
            <span class="simbolo">
                <img src="IMG/house.svg" alt="Dashboard" class="icono-svg" />
                Dashboard
            </span>
        </a>
    </li>

    <?php
    // SUPERUSUARIO: ve todos los módulos con títulos
    if ($nombre_rol == 'SuperUsuario') {
        // Perfiles
        echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=Usuarios"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';

        // Inventario
        echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=Recepcion"><span class="simbolo"><img src="IMG/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
        echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="IMG/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';

        // Productos
        echo '<h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=marcas"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Marcas</span></a></li>';
        echo '<li><a href="?pagina=modelos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Modelos</span></a></li>';
        echo '<li><a href="?pagina=Productos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Productos</span></a></li>';
        echo '<li><a href="?pagina=categoria"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Categorias</span></a></li>';

        // Proveedores
        echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=proveedores"><span class="simbolo"><img src="IMG/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';

        // Clientes
        echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=clientes"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';

        // Ventas
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="IMG/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="IMG/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="IMG/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarFactura"><span class="simbolo"><img src="IMG/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
        echo '<li><a href="?pagina=OrdenDespacho"><span class="simbolo"><img src="IMG/list-ordered.svg" class="icono-svg" />Gestionar Ordenes de Despacho</span></a></li>';

        // Finanzas
        echo '<h4><span>Administrar Finanzas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=cuentas"><span class="simbolo"><img src="IMG/landmark.svg" class="icono-svg" />Gestionar Cuentas Bancarias</span></a></li>';
        echo '<li><a href="?pagina=finanza"><span class="simbolo"><img src="IMG/dollar-sign.svg" class="icono-svg" />Gestionar Ingresos y Egresos</span></a></li>';

        // Seguridad
        echo '<h4><span>Administrar Seguridad</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=permisos"><span class="simbolo"><img src="IMG/key-round.svg" class="icono-svg" />Gestionar Permisos</span></a></li>';
        echo '<li><a href="?pagina=rol"><span class="simbolo"><img src="IMG/user-round-search.svg" class="icono-svg" />Gestionar Roles</span></a></li>';
        echo '<li><a href="?pagina=bitacora"><span class="simbolo"><img src="IMG/notebook.svg" class="icono-svg" />Gestionar Bitácora</span></a></li>';
    }
    if ($nombre_rol == 'SuperUsuario') {
        // Perfiles
        echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=Usuarios"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';

        // Inventario
        echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=Recepcion"><span class="simbolo"><img src="IMG/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
        echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="IMG/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';

        // Productos
        echo '<h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=marcas"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Marcas</span></a></li>';
        echo '<li><a href="?pagina=modelos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Modelos</span></a></li>';
        echo '<li><a href="?pagina=Productos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Productos</span></a></li>';
        echo '<li><a href="?pagina=categoria"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Categorias</span></a></li>';

        // Proveedores
        echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=proveedores"><span class="simbolo"><img src="IMG/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';

        // Clientes
        echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=clientes"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';

        // Ventas
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="IMG/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="IMG/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="IMG/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarFactura"><span class="simbolo"><img src="IMG/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
}

    if ($nombre_rol == 'Cliente') {
  
        echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
        echo '<li><a href="?pagina=catalogo"><span class="simbolo"><img src="IMG/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>';
        echo '<li><a href="?pagina=carrito"><span class="simbolo"><img src="IMG/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>';
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="IMG/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
        echo '<li><a href="?pagina=gestionarFactura"><span class="simbolo"><img src="IMG/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>';
}
    // CLIENTE: solo puede ver catálogo, carrito, pasarela, prefactura
    else if ($nombre_rol == 'Cliente') {
        $cliente_modulos = ['Catalogo', 'carrito', 'pasarela', 'gestionarFactura'];
        foreach ($cliente_modulos as $mod) {
            if (!empty($permisosConsulta[$mod])) {
                echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
            }
        }
    } else {
        // ADMINISTRAR PERFILES (solo Admin y SuperUsuario)
        if (in_array($nombre_rol, ['Administrador', 'SuperUsuario']) && !empty($permisosConsulta['Usuario'])) {
            echo '<h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=Usuarios"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Usuario</span></a></li>';
        }

        // ADMINISTRAR INVENTARIO (Admin y Almacenista)
        if (in_array($nombre_rol, ['Administrador', 'Almacenista'])) {
            if (!empty($permisosConsulta['Recepcion']) || !empty($permisosConsulta['Despacho'])) {
                echo '<h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>';
                if (!empty($permisosConsulta['Recepcion'])) {
                    echo '<li><a href="?pagina=Recepcion"><span class="simbolo"><img src="IMG/package-open.svg" class="icono-svg" />Gestionar Recepcion</span></a></li>';
                }
                if (!empty($permisosConsulta['Despacho'])) {
                    echo '<li><a href="?pagina=despacho"><span class="simbolo"><img src="IMG/package-check.svg" class="icono-svg" />Gestionar Despacho</span></a></li>';
                }
            }
        }

        // ADMINISTRAR PRODUCTOS (Admin y Almacenista)
        if (in_array($nombre_rol, ['Administrador', 'Almacenista'])) {
            $productoNav = ['Marcas', 'Modelos', 'Productos', 'Categorias'];
            $hayProductos = false;
            foreach ($productoNav as $mod) {
                if (!empty($permisosConsulta[$mod])) $hayProductos = true;
            }
            if ($hayProductos) {
                echo '<h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>';
                foreach ($productoNav as $mod) {
                    if (!empty($permisosConsulta[$mod])) {
                        echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
                    }
                }
            }
        }

        // ADMINISTRAR PROVEEDORES (solo Admin)
        if ($nombre_rol == 'Administrador' && !empty($permisosConsulta['Proveedores'])) {
            echo '<h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=proveedores"><span class="simbolo"><img src="IMG/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>';
        
        echo '<li><a href="?pagina=pasarela"><span class="simbolo"><img src="IMG/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>';
    }

        // ADMINISTRAR CLIENTES (Admin y Almacenista)
        if (in_array($nombre_rol, ['Administrador', 'Almacenista']) && !empty($permisosConsulta['Clientes'])) {
            echo '<h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>';
            echo '<li><a href="?pagina=clientes"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>';
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
                echo '<li><a href="?pagina=cuentas"><span class="simbolo"><img src="IMG/landmark.svg" class="icono-svg" />Gestionar Cuentas Bancarias</span></a></li>';
            }
            if (!empty($permisosConsulta['finanza'])) {
                echo '<li><a href="?pagina=finanza"><span class="simbolo"><img src="IMG/dollar-sign.svg" class="icono-svg" />Gestionar Ingresos y Egresos</span></a></li>';
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
    <li><a href='?pagina=backup'><span class="simbolo"><img src="IMG/files.svg" class="icono-svg" />Gestionar Respaldo</span></a></li>
<?php endif; ?>

    <h4><span>Solicitar Ayuda</span><div class='menu-separador'></div></h4>;
    <li><a href="Public/casalai-manual/index.php"><span class="simbolo"><img src="IMG/user-round-search.svg" class="icono-svg" />Manual de Usuarios</span></a></li>;
    <h4><span>Cuenta</span><div class="menu-separador"></div></h4>
    <li><a href="#"><span class="simbolo"><img src="IMG/circle-user-round.svg" class="icono-svg" />Perfil</span></a></li>
    <li><a href='?pagina=cerrar'><span class="simbolo"><img src="IMG/log-out.svg" class="icono-svg" />Cerrar Sesión</span></a></li>
</ul>
        <div class="user-cuenta">
            <div class="user-perfil">
                <img src="img/Avatar.png" alt="perfil-img">
                <div class="user-detalle">
                    <h3><?php echo htmlspecialchars($_SESSION['name'] ?? 'Invitado'); ?></h3>
                    <span><?php echo htmlspecialchars($_SESSION['nombre_rol'] ?? 'Usuario'); ?></span>
                </div>
            </div>
        </div>
    </div>
</aside>