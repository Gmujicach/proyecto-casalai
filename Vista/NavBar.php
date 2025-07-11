

<div class="top-bar">
    <button id="menu-toggle">☰ Menú</button>
    
    <!-- Contenedor para el logo y el nombre -->
    <a class="navbar-brand" href="?pagina=Dashboard" style="display: flex; align-items: center;">
        <!-- Imagen del logo -->
        <img src="img/logotipo.png" alt="Logo" width="60" height="50" style="margin-right: 10px;">
        
        <!-- Nombre de la página -->
        <h3 style="color: white; margin: 0;">Casa Lai</h3>
    </a>
    
    <!-- Botón de cerrar sesión -->
    <button class="btn-logout" onclick="window.location.href='?pagina=cerrar'">Cerrar Sesión</button>
</div>


    <nav class="sidebar" id="sidebar">
        <a href="?pagina=Dashboard">Inicio</a>
        <a href="?pagina=Usuarios">Gestionar Usuarios</a>
        <a href="?pagina=Recepcion">Gestionar Recepción</a>
        <a href="?pagina=despacho">Gestionar Despacho</a>
        <a href="?pagina=marcas">Gestionar Marcas</a>
        <a href="?pagina=modelos">Gestionar Modelos</a>
        <a href="?pagina=Productos">Gestionar Productos</a>
        <a href="?pagina=clientes">Gestionar Clientes</a>
        <a href="?pagina=Proveedores">Gestionar Proveedores</a>
        <a href="?pagina=gestionarfactura">Gestionar Facturas</a>
        <a href="vista/Manual.pdf" target="_blank">Manual Usuario</a>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            if (sidebar.style.width === '0px' || sidebar.style.width === '') {
                sidebar.style.width = '250px';
            } else {
                sidebar.style.width = '0px';
            }
        });
    </script>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="javascript/js/bootstrap.min.js"></script>