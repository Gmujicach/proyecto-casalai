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
                <th>Cuenta</th>
                <th>Tipo de Pago</th>
                <th>Referencia</th>
                <th>Fecha</th>
                <th>Estatus</th>
                <th>Observaciones</th>
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
                <td><?php echo htmlspecialchars($dato['tbl_cuentas']); ?></td>
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
                <td><?php echo htmlspecialchars($dato['observaciones']); ?></td>

                <td>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li><a href="#" class="modificarEstado" 
   data-id="1"
   data-estatus="Pago No Encontrado"
   data-observaciones="Pago no verificado aún">
   Cambiar Estatus
</a>
</li>
                                <li>
  <a href="#"
   class="modificar"
   data-id="<?php echo $dato['id_detalles']; ?>"
   data-cuenta="<?php echo htmlspecialchars($dato['id_cuenta']); ?>"
   data-referencia="<?php echo htmlspecialchars($dato['referencia']); ?>"
   data-fecha="<?php echo htmlspecialchars($dato['fecha']); ?>"
   data-tipo="<?php echo htmlspecialchars($dato['tipo']); ?>"
   data-factura="<?php echo htmlspecialchars($dato['id_factura']); ?>">
   Modificar
</a>

</li>

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

<!-- Modal de modificación -->
<div class="modal fade" id="modificarPago" tabindex="-1" role="dialog" aria-labelledby="modificarPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content shadow-lg rounded-4">
      <form id="modificarPagoForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="modificar">
        <input type="hidden" name="id_detalles" id="modificarIdDetalles">

        <div class="modal-header bg-primary text-white rounded-top">
          <h5 class="modal-title" id="modificarPagoLabel">Modificar Pago</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="modificarCuenta" class="form-label">Cuenta a la cual pagó</label>
            <select class="form-select" id="modificarCuenta" name="cuenta" required>
              <option value="" disabled selected>Seleccione una cuenta</option>
              <?php foreach ($listadocuentas as $cuenta): ?>
                <option value="<?php echo $cuenta['id_cuenta']; ?>">
                  <?php echo $cuenta['nombre_banco'] . " - " . $cuenta['numero_cuenta']; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-text text-danger" id="scuenta"></div>
          </div>

          <div class="mb-3">
            <label for="modificarReferencia" class="form-label">Referencia</label>
            <input type="text" class="form-control" id="modificarReferencia" name="referencia" placeholder="Número de referencia" required>
            <div class="form-text text-danger" id="sreferencia"></div>
          </div>

          <div class="mb-3">
            <label for="modificarFecha" class="form-label">Fecha de pago</label>
            <input type="date" class="form-control" id="modificarFecha" name="fecha" required>
            <div class="form-text text-danger" id="sfecha"></div>
          </div>

          <div class="mb-3">
            <label for="modificarTipo" class="form-label">Tipo de pago</label>
            <select id="modificarTipo" name="tipo" class="form-select" required>
              <option value="" disabled selected>Seleccionar</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Pago móvil">Pago móvil</option>
              <option value="Depósito">Depósito</option>
              <option value="Otro">Otro</option>
            </select>
            <div class="form-text text-danger" id="stipo"></div>
          </div>

          <input type="hidden" name="id_factura" id="modificarFactura" value="">
        </div>

        <div class="modal-footer bg-light border-top">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para modificar estatus y observaciones -->
<div class="modal fade" id="modificarEstadoModal" tabindex="-1" aria-labelledby="modificarEstadoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modificarEstadoLabel">Modificar Estatus del Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      <form id="formModificarEstado" method="POST" enctype="multipart/form-data">
        <div class="modal-body">

          <input type="hidden" id="estadoIdPago" name="id_pago">
          <input type="hidden" name="accion" value="modificar_estado">
          <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select class="form-select" id="estatus" name="estatus" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="Pago Procesado">Pago Procesado</option>
              <option value="Pago No Encontrado">Pago No Encontrado</option>
              <option value="Pago Incompleto">Pago Incompleto</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>

    </div>
  </div>
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

<script>
  document.getElementById('formModificarEstado').addEventListener('submit', function(e) {
    e.preventDefault(); // evita el envío tradicional del formulario

    const form = e.target;
    const formData = new FormData(form);

    console.log("🔍 Valores enviados:");
    for (let [name, value] of formData.entries()) {
        console.log(`name: ${name}, value: ${value}`);
    }
  });
$(document).ready(function () {
  $('.modificar').on('click', function (e) {
    e.preventDefault();

    const id = $(this).data('id');
    const cuenta = $(this).data('cuenta');
    const referencia = $(this).data('referencia');
    const fecha = $(this).data('fecha');
    const tipo = $(this).data('tipo'); // Asegúrate de agregarlo en el HTML
    const factura = $(this).data('factura');
    $('#modificarIdDetalles').val(id);
    $('#modificarCuenta').val(cuenta);
    $('#modificarReferencia').val(referencia);
    $('#modificarFecha').val(fecha);
    $('#modificarTipo').val(tipo);
    $('#modificarFactura').val(factura);
    $('#modificarPago').modal('show');
  });
});
</script>



</body>


</html>