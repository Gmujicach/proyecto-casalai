<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                    <div>

  <?php  if($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista'){ ?>
    <button class="btn btn-primary modificarEstado" 
   data-id="<?php echo htmlspecialchars($dato['id_detalles']); ?>"
   data-factura="<?php echo htmlspecialchars($dato['id_factura']); ?>"
   data-estatus="Pago No Encontrado"
   data-observaciones="Pago no verificado aún">
   Cambiar Estatus
  </button>
<?php }; ?>

<?php if (!($dato["estatus"] === "Pago Procesado")){ ?>

<?php }; ?>


                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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