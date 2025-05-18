<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body>
<?php include 'NewNavBar.php'; ?>

<div class="contenedor-tabla">
    <h3>LISTA DE PAGOS DE PAGOS REALIZADOS</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>ID Factura</th>
                <th>ID Cuenta</th>
                <th>Tipo de Pago</th>
                <th>Referencia</th>
                <th>Fecha</th>
                <th>Estatus</th>
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($datos as $dato): ?>
            <tr>
                <td><input type="checkbox" value="<?php echo htmlspecialchars($dato['id_detalles']); ?>"></td>
                
                <td><?php echo htmlspecialchars($dato['id_factura']); ?></td>
                <td><?php echo htmlspecialchars($dato['id_cuenta']); ?></td>
                <td><?php echo htmlspecialchars($dato['tipo']); ?></td>
                <td><?php echo htmlspecialchars($dato['referencia']); ?></td>
                <td><?php echo htmlspecialchars($dato['fecha']); ?></td>
                <td>
                    <span class="campo-estatus <?php echo ($dato['estatus'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                        onclick="cambiarEstatus(<?php echo $dato['id_detalles']; ?>, '<?php echo $dato['estatus']; ?>')"
                        style="cursor: pointer;">
                        <?php echo htmlspecialchars($dato['estatus']); ?>
                    </span>
                </td>

                <td>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li><a href="#">Ver</a></li>
                                <li><a href="#" class="modificar" onclick="obtenerPago(<?php echo $dato['id_detalles']; ?>)">Modificar</a></li>
                                <li><a href="#" class="eliminar" onclick="eliminarPago(<?php echo $dato['id_detalles']; ?>)">Eliminar</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php include 'footer.php'; ?>
<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/usuario.js"></script>
<script src="Javascript/validaciones.js"></script>
<script src="Javascript/pasarela.js"></script>
<script>
  // Este bloque impide el retroceso y redirige al usuario
  (function () {
    const redirectURL = '?pagina=pasarela'; // <-- cambia esto si quieres otra página

    // Empuja una entrada adicional en el historial
    history.pushState(null, '', location.href);

    // Al presionar el botón atrás (popstate), se redirige
    window.addEventListener('popstate', function () {
      window.location.href = redirectURL;
    });

    // También evita el botón de retroceso en móviles Android
    window.history.forward();
  })();
</script>



</body>


</html>