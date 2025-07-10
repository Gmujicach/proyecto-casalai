<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
<?php include 'newnavbar.php'; ?>

<div class="contenedor-tabla">
    <h3>LISTA DE PAGOS DE PAGOS REALIZADOS</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID Factura</th>
                <th>Cuenta</th>
                <th>Tipo de Pago</th>
                <th>Referencia</th>
                <th>Fecha</th>
                <th>Estatus</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($datos as $dato): ?>
            <tr>
                
                <td><?php echo htmlspecialchars($dato['id_factura']); ?></td>
                <td><?php echo htmlspecialchars($dato['tbl_cuentas']); ?></td>
                <td><?php echo htmlspecialchars($dato['tipo']); ?></td>
                <td><?php echo htmlspecialchars($dato['referencia']); ?></td>
                <td><?php echo htmlspecialchars($dato['fecha']); ?></td>
                <td>
<span class="campo-estatus-pagos" 
      data-estatus="<?php echo htmlspecialchars($dato['estatus']); ?>" 
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
                            <ul><?php  if($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista'){ ?>
                                <li><a href="#" class="modificarEstado" 
   data-id="<?php echo htmlspecialchars($dato['id_detalles']); ?>"
   data-factura="<?php echo htmlspecialchars($dato['id_factura']); ?>"
   data-estatus="Pago No Encontrado"
   data-observaciones="Pago no verificado aún">
   Cambiar Estatus
</a>
<?php }; ?>
</li>
<?php if (!($dato["estatus"] === "Pago Procesado")){ ?>
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
<?php }; ?>

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

          <input type="hidden" id="estadoIdPago" name="id_detalles">
          <input type="hidden" name="id_factura" id="modificarIdFactura">
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
  <script src="javascript/sweetalert2.all.min.js"></script>
<script src="javascript/validaciones.js"></script>
<script src="javascript/pasarela.js"></script>
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
    function estatusAClase(estatus) {
        return estatus
            .toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // elimina tildes
            .replace(/\s+/g, '-') // reemplaza espacios con guiones
            .replace(/[^a-z\-]/g, ''); // elimina cualquier otro carácter extraño
    }

    function aplicarClasesEstatus() {
        const elementos = document.querySelectorAll('.campo-estatus-pagos');

        elementos.forEach(el => {
            const estatus = el.dataset.estatus;
            const clase = estatusAClase(estatus);
            if (estatus && clase) {
                el.classList.add(clase);
            }
        });
    }

    // Ejecutar automáticamente al cargar la página
    document.addEventListener('DOMContentLoaded', aplicarClasesEstatus);
</script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'public/js/es-ES.json'
        }
    });
});
</script>


</body>


</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>