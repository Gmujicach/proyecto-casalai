<?php
require_once('config/config.php');
require_once('modelo/permiso.php');

$id_rol = $_SESSION['id_rol'];
$nombre_rol = $_SESSION['nombre_rol'] ?? '';
$id_usuario = $_SESSION['id_usuario'] ?? 0;

$permisosObj = new Permisos();

$modulos = [
    'Usuario' => ['Gestionar Usuario', 'img/users-round.svg', '?pagina=usuario'],
    'Recepcion' => ['Gestionar Recepcion', 'img/package-open.svg', '?pagina=recepcion'],
    'Despacho' => ['Gestionar Despacho', 'img/package-check.svg', '?pagina=despacho'],
    'Marcas' => ['Gestionar Marcas', 'img/package-search.svg', '?pagina=marca'],
    'Modelos' => ['Gestionar Modelos', 'img/package-search.svg', '?pagina=modelo'],
    'Productos' => ['Gestionar Productos', 'img/package-search.svg', '?pagina=producto'],
    'Categorias' => ['Gestionar Categorias', 'img/package-search.svg', '?pagina=categoria'],
    'comprafisica' => ['Gestionar Compra Fisica', 'img/files.svg', '?pagina=comprafisica'],
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

$bd_seguridad = new BD('S'); // Asumo que 'S' es para seguridad
$pdo_seguridad = $bd_seguridad->getConexion();

// Conexión a la base de datos de casalai
$bd_casalai = new BD('C'); // Asumo que 'C' es para casalai (deberás configurar esto)
$pdo_casalai = $bd_casalai->getConexion();

// Consulta de notificaciones
$query = "SELECT * FROM tbl_notificaciones 
          WHERE id_usuario = :id_usuario AND leido = 0
          ORDER BY fecha_hora DESC LIMIT 5";
$stmt = $pdo_seguridad->prepare($query);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar notificaciones para obtener más detalles si es necesario
foreach ($notificaciones as &$notif) {
    if ($notif['tipo'] == 'pago' && $notif['id_referencia']) {
        // Obtener detalles del pago desde casalai
        $query_pago = "SELECT * FROM tbl_detalles_pago WHERE id_detalles = ?";
        $stmt_pago = $pdo_casalai->prepare($query_pago);
        $stmt_pago->execute([$notif['id_referencia']]);
        $notif['detalle_pago'] = $stmt_pago->fetch(PDO::FETCH_ASSOC);
    }
    // Puedes añadir más casos para otros tipos de notificaciones
}
unset($notif); // Romper la referencia

$notificaciones_count = count($notificaciones);
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
        <?php foreach ($notificaciones as $notif): ?>
            <div class="item-notificacion">
                <div class="texto">
                    <img src="img/<?php 
                        echo $notif['tipo'] == 'pago' ? 'credit-card' : 
                             ($notif['tipo'] == 'factura' ? 'receipt-text' : 
                              ($notif['tipo'] == 'despacho' ? 'package-check' : 'bell')); 
                    ?>.svg" alt="img">
                    <h4><?= htmlspecialchars($notif['titulo']) ?></h4>
                    <p><?= htmlspecialchars($notif['mensaje']) ?></p>
                    <?php if ($notif['tipo'] == 'pago' && !empty($notif['detalle_pago'])): ?>
                        <small>Referencia: <?= htmlspecialchars($notif['detalle_pago']['referencia']) ?></small>
                    <?php endif; ?>
                    <small><?= date('d/m/Y H:i', strtotime($notif['fecha_hora'])) ?></small>
                </div>
                <button class="marcar-leido" data-id="<?= $notif['id_notificacion'] ?>">
                    <img src="img/check.svg" alt="Marcar como leído">
                </button>
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
            'Administrar Ventas' => ['Catalogo', 'comprafisica', 'carrito', 'pasarela', 'Prefactura', 'Ordenes de despacho'],
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
            echo '<li><a href="?pagina=comprafisica"><span class="simbolo"><img src="img/files.svg" class="icono-svg" />Compra Fisica</span></a></li>';
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

    <script>
// Función para mostrar/ocultar notificaciones
function toggleNotification() {
    const notificacion = document.getElementById('contenedor-notificacion');
    if (notificacion.style.height === '0px' || notificacion.style.height === '') {
        notificacion.style.height = 'auto';
        notificacion.style.opacity = '1';
        notificacion.style.padding = '15px';
    } else {
        notificacion.style.height = '0px';
        notificacion.style.opacity = '0';
        notificacion.style.padding = '0';
    }
}

// Manejar el clic en "Marcar como leído"
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.marcar-leido').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const idNotificacion = this.getAttribute('data-id');
            
            fetch('marcar_notificacion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_notificacion=' + idNotificacion
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Eliminar la notificación del DOM
                    this.closest('.item-notificacion').remove();
                    // Actualizar el contador
                    const countElement = document.querySelector('.campana span');
                    if (countElement) {
                        const newCount = parseInt(countElement.textContent) - 1;
                        countElement.textContent = newCount;
                        if (newCount <= 0) {
                            countElement.style.display = 'none';
                        }
                    }
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
</aside>


