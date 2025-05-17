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

<div class="formulario-responsivo">
    <div class="fondo-form">
    <form id="incluirordendepacho" action="" method="POST">
        <input type="hidden" name="accion" value="ingresar">
        <h3 class="titulo-form">Generar órdenes de despacho</h3>

        <!-- <div class="grupo-form">
            <input type="date" placeholder="Nombre" class="control-form" id="fecha" name="fecha" required>
            <span id="sfecha"></span>
        </div> -->
        <div class="envolver-form">
            <input type="date" placeholder="" class="control-form" id="fecha" name="fecha" required>
            <span id="sfecha"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="Correlativo" class="control-form" id="correlativo" name="correlativo" required>
            <span id="scorrelativo"></span>
        </div>
        <div class="envolver-form">
            <select name="factura" id="factura" class="control-form" required>
                <option value="" disabled selected>Seleccionar Factura</option>
                <?php foreach ($facturas as $factura): ?>
                    <option value="<?php echo htmlspecialchars($factura['id_factura']); ?>">
                        <?php echo htmlspecialchars($factura['fecha']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="boton-form" type="submit">Registrar</button>
    </form>
    </div>
</div>


<div class="contenedor-tabla">
    <h3>LISTA DE ORDENES</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Correlativo</th>
                <th>Fecha</th>
                <th>Factura</th>
                <th></th>
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($ordendespacho as $orden): ?>
            <tr>
    <td><input type="checkbox"></td>
    <td><span class="campo-correlativo"><?php echo htmlspecialchars($orden['correlativo']); ?></span></td>
    <td><span class="campo-fecha"><?php echo htmlspecialchars($orden['fecha_despacho']); ?></span></td>
    <td><span class="campo-factura"><?php echo htmlspecialchars($orden['activo']); ?></span></td>
    <td><span><a href="#" class="">Ver Mas</a></span></td>
    <td>
        <div class="acciones-boton">
            <i class="vertical">
                <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
            </i>
            <div class="desplegable">
                <ul>
                    <li><a href="#">Ver</a></li>
                    <li>
                    <a href="#" class="modificar" 
                        data-id="<?php echo $orden['id_despachos']; ?>" 
                        data-fecha="<?php echo $orden['fecha_despacho']; ?>"
                        data-correlativo="<?php echo $orden['correlativo']; ?>"
                        data-factura="<?php echo $orden['id_factura']; ?>"
                        data-bs-toggle="modal" 
                        data-bs-target="#modificar_orden_modal">Modificar
                    </a>
                    </li>
                    <li><a href="#" class="eliminar" data-id="<?php echo $orden['id_despachos']; ?>">Eliminar</a></li>
                </ul>
            </div>
        </div>
    </td>
</tr>

        <?php endforeach; ?>
        </tbody>
        <!-- <tfoot>
            <tr>
                <td>Filas por Página: 
                    <select id="filasPorPagina" onchange="cambiarFilasPorPagina(this.value)">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </td>
                <td><?php //echo "$inicio-$fin de $totalUsuarios"; ?></td>
                <td>
                    <a href="?pagina=<?php //echo max(1, $paginaActual - 1); ?>">
                        <i class="flecha-izquierda"><img src="IMG/flecha_izquierda.svg" alt="Anterior" width="16" height="16"></i>
                    </a>
                </td>
                <td>
                    <a href="?pagina<?php //echo min(ceil($totalUsuarios / $filasPorPagina), $paginaActual + 1); ?>">
                        <i class="flecha-derecha"><img src="IMG/flecha_derecha.svg" alt="Siguiente" width="16" height="16"></i>
                    </a>
                </td>
            </tr>
        </tfoot> -->
    </table>




<!-- Modal de modificación -->
    <!-- Modal de modificación de orden de despacho -->
<div class="modal fade" id="modificar_orden_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_orden_modal_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modificarorden" method="POST">
      <input type="hidden" name="accion" value="modificar">
        <div class="modal-header">
          <h5 class="modal-title" id="modificar_orden_modal_label">Modificar Orden de Despacho</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="modificar_id_orden" name="id_despachos">
          <div class="form-group">
            <label for="modificar_fecha">Fecha</label>
            <input type="date" class="form-control" id="modificar_fecha" name="fecha_despacho" required>
          </div>
          <div class="form-group">
            <label for="modificar_correlativo">Correlativo</label>
            <input type="text" class="form-control" id="modificar_correlativo" name="correlativo" required>
          </div>
          <div class="form-group">
            <label for="modificar_factura">Factura</label>
            <select name="factura" id="modificar_factura" class="form-control">
              <?php foreach ($facturas as $factura): ?>
                <option value="<?php echo htmlspecialchars($factura['id_factura']); ?>">
                  <?php echo htmlspecialchars($factura['fecha']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>


<!-- Modal de eliminación -->
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
<script src="Javascript/ordendespacho.js"></script>
</body>


</html>