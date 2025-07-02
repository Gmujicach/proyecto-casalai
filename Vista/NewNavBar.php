<aside class="sidebar">
    <div class="headmenu">
        <img src="img/LOGO.png" alt="logo">
        <h2><span>Casa Lai</span></h2>
    </div>

    <?php
    // Conexión a la base de datos y consulta de notificaciones
    include('Config/Config.php');
    
            // Consulta para obtener las notificaciones recientes de la bitácora
            $query = "SELECT b.*, m.nombre_modulo, u.nombres 
                    FROM tbl_bitacora b 
                    JOIN tbl_modulos m ON b.id_modulo = m.id_modulo 
                    JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario 
                    ORDER BY b.fecha_hora DESC LIMIT 5";
            $result = mysqli_query($conexion, $query);
            $notificaciones_count = mysqli_num_rows($result);
            ?>

    <div class="campana" onclick="toggleNotification()">
        <img src="IMG/campana.svg" alt="">
        <span class="campana"><?php echo $notificaciones_count; ?></span>
    </div>

    <div class="notificacion" id="contenedor-notificacion">
        <h2>Notificaciones <span><?php echo $notificaciones_count; ?></span></h2>
        <?php
        if ($notificaciones_count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
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

            <?php if ($_SESSION['nombre_rol'] == 'Administrador') { ?>
            <h4><span>Administrar Perfiles</span><div class="menu-separador"></div></h4>
            <li>
                <a href="?pagina=Usuarios">
                    <span class="simbolo">
                        <img src="IMG/users-round.svg" alt="Usuarios" class="icono-svg" />
                        Gestionar Usuario
                    </span>
                </a>
            </li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista') { ?>
            <h4><span>Administrar Inventario</span><div class="menu-separador"></div></h4>
            <li>
                <a href="?pagina=Recepcion">
                    <span class="simbolo">
                        <img src="IMG/package-open.svg" alt="Recepcion" class="icono-svg" />
                        Gestionar Recepcion
                    </span>
                </a>
            </li>
            <li>
                <a href="?pagina=despacho">
                    <span class="simbolo">
                        <img src="IMG/package-check.svg" alt="Despacho" class="icono-svg" />
                        Gestionar Despacho
                    </span>
                </a>
            </li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista') { ?>
            <h4><span>Administrar Productos</span><div class="menu-separador"></div></h4>
            <li><a href="?pagina=marcas"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Marcas</span></a></li>
            <li><a href="?pagina=modelos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Modelos</span></a></li>
            <li><a href="?pagina=Productos"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Productos</span></a></li>
            <li><a href="?pagina=categoria"><span class="simbolo"><img src="IMG/package-search.svg" class="icono-svg" />Gestionar Categorias</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador') { ?>
            <h4><span>Administrar Proveedores</span><div class="menu-separador"></div></h4>
            <li><a href="?pagina=proveedores"><span class="simbolo"><img src="IMG/truck.svg" class="icono-svg" />Gestionar Proveedores</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista') { ?>
            <h4><span>Administrar Clientes</span><div class="menu-separador"></div></h4>
            <li><a href="?pagina=clientes"><span class="simbolo"><img src="IMG/users-round.svg" class="icono-svg" />Gestionar Clientes</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente') { ?>
            <h4><span>Administrar Ventas</span><div class="menu-separador"></div></h4>
            <li><a href="?pagina=catalogo"><span class="simbolo"><img src="IMG/book-open.svg" class="icono-svg" />Gestionar Catálogo</span></a></li>
            <li><a href="?pagina=carrito"><span class="simbolo"><img src="IMG/shopping-cart.svg" class="icono-svg" />Gestionar Carrito de Compras</span></a></li>
            <li><a href="?pagina=pasarela"><span class="simbolo"><img src="IMG/credit-card.svg" class="icono-svg" />Gestionar Pasarela de Pagos</span></a></li>
            <li><a href="?pagina=gestionarFactura"><span class="simbolo"><img src="IMG/receipt-text.svg" class="icono-svg" />Gestionar Pre-Factura</span></a></li>
            <li><a href="?pagina=OrdenDespacho"><span class="simbolo"><img src="IMG/list-ordered.svg" class="icono-svg" />Gestionar Ordenes de Despacho</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador') { ?>
            <h4><span>Administrar Finanzas</span><div class="menu-separador"></div></h4>
            <li><a href="?pagina=cuentas"><span class="simbolo"><img src="IMG/landmark.svg" class="icono-svg" />Gestionar Cuentas Bancarias</span></a></li>
            <li><a href="?pagina=finanza"><span class="simbolo"><img src="IMG/dollar-sign.svg" class="icono-svg" />Gestionar Ingresos y Egresos</span></a></li>
            <?php } ?>

            <?php if ($_SESSION['nombre_rol'] == 'Administrador') { ?>
                <h4><span>Administrar Seguridad</span><div class="menu-separador"></div></h4>
                <li><a href="?pagina=permisos"><span class="simbolo"><img src="IMG/key-round.svg" class="icono-svg" />Gestionar Permisos</span></a></li>
                <li><a href="?pagina=rol"><span class="simbolo"><img src="IMG/user-round-search.svg" class="icono-svg" />Gestionar Roles</span></a></li>
                <li><a href="?pagina=bitacora"><span class="simbolo"><img src="IMG/notebook.svg" class="icono-svg" />Gestionar Bitácora</span></a></li>
            <?php } ?>
            
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
