<?php
require_once('Config/Config.php');
require_once('Modelo/Permisos.php');

$id_rol = $_SESSION['id_rol'];
$nombre_rol = $_SESSION['nombre_rol'] ?? '';

$permisosObj = new Permisos();

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
        if ($nombre_rol == 'SuperUsuario') {
            echo '<h4><span>Acceso Total</span><div class="menu-separador"></div></h4>';
            foreach ($modulos as $moduloBD => $info) {
                echo '<li><a href="'.$info[2].'"><span class="simbolo"><img src="'.$info[1].'" class="icono-svg" />'.$info[0].'</span></a></li>';
            }
            echo '<li><a href="?pagina=backup"><span class="simbolo"><img src="IMG/files.svg" class="icono-svg" />Gestionar Respaldo</span></a></li>';
        }
        ?>

        <?php if ($nombre_rol == 'Cliente') {
            $cliente_modulos = ['Catalogo', 'carrito', 'pasarela', 'gestionarFactura'];
            echo '<h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>';
            foreach ($cliente_modulos as $mod) {
                if (!empty($permisosConsulta[$mod])) {
                    echo '<li><a href="'.$modulos[$mod][2].'"><span class="simbolo"><img src="'.$modulos[$mod][1].'" class="icono-svg" />'.$modulos[$mod][0].'</span></a></li>';
                }
            }
        }
        ?>

        <h4><span>Solicitar Ayuda</span><div class='menu-separador'></div></h4>
        <li><a href="Public/casalai-manual/index.php"><span class="simbolo"><img src="IMG/user-round-search.svg" class="icono-svg" />Manual de Usuarios</span></a></li>

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
