<?php if ($_SESSION['nombre_rol'] == 'Cliente' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?> 

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body class="fondo" style="height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<!-- CONTENEDOR FLEXIBLE -->
<div class="contenedor-flex" style="display: flex; justify-content: center; align-items: flex-start; gap: 2rem; padding: 2rem; flex-wrap: wrap;">

  <!-- FORMULARIO -->
  <div class="formulario" style="background-color: rgba(255,255,255,0.95); padding: 2rem; border-radius: 10px; max-width: 400px;">
    <form id="formularioPago" method="POST" action="?pagina=pasarela&accion=ingresar">
      <input type="hidden" name="accion" value="ingresar">
      <h3 class="titulo-form">REGISTRAR PAGO</h3>

      <div class="envolver-form">
        <label for="cuenta">Cuenta a la cual pagó</label>
        <select class="control-form" id="cuenta" name="cuenta" required>
          <option value="" disabled selected>Seleccione una cuenta</option>
          <?php foreach ($listadocuentas as $cuenta): ?>
            <option 
              value="<?php echo $cuenta['id_cuenta']; ?>"
              data-nombre="<?php echo $cuenta['nombre_banco']; ?>"
              data-numero="<?php echo $cuenta['numero_cuenta']; ?>"
              data-rif="<?php echo $cuenta['rif_cuenta']; ?>"
              data-telefono="<?php echo $cuenta['telefono_cuenta']; ?>"
              data-correo="<?php echo $cuenta['correo_cuenta']; ?>"
            >
              <?php echo $cuenta['nombre_banco'] . " - " . $cuenta['numero_cuenta']; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <span id="scuenta"></span>
      </div>

      <div class="envolver-form">
        <label for="referencia">Referencia</label>
        <input type="text" placeholder="Número de referencia" class="control-form" id="referencia" name="referencia" required>
        <span id="sreferencia"></span>
      </div>

      <div class="envolver-form">
        <label for="fecha">Fecha de pago</label>
        <input type="date" class="control-form" id="fecha" name="fecha" required>
        <span id="sfecha"></span>
      </div>

      <div class="envolver-form">
        <label for="tipo">Tipo de pago</label>
        <select id="tipo" name="tipo" class="control-form" required>
          <option value="" disabled selected>Seleccionar</option>
          <option value="Transferencia">Transferencia</option>
          <option value="Pago móvil">Pago móvil</option>
          <option value="Depósito">Depósito</option>
          <option value="Otro">Otro</option>
        </select>
        <span id="stipo"></span>
      </div>

      <div class="envolver-form">
        <label for="monto">Monto</label>
        <input type="text" placeholder="<?php echo $monto . ' Bs' ?>" class="control-form" id="monto" name="monto" disabled>
        <span id="smonto"></span>
      </div>

      <input type="hidden" name="id_factura" value="<?php echo $idFactura; ?>">
      <button class="boton-form" type="submit">Registrar</button>
    </form>
  </div>

  <!-- DATOS DE LA CUENTA -->
  <div id="tablaDatosCuenta" class="datos-cuenta" style="display: none; background-color: rgba(255,255,255,0.95); padding: 2rem; border-radius: 10px; max-width: 400px; min-width: 300px;">
    <h3 style="margin-bottom: 1rem;">Datos de la Cuenta</h3>
    <table border="1" cellpadding="5" style="width: 100%;">
      <tr><th>Banco</th><td id="datoBanco"></td></tr>
      <tr><th>Número</th><td id="datoNumero"></td></tr>
      <tr><th>RIF</th><td id="datoRif"></td></tr>
      <tr><th>Teléfono</th><td id="datoTelefono"></td></tr>
      <tr><th>Correo</th><td id="datoCorreo"></td></tr>
    </table>
  </div>

</div>

<!-- FOOTER -->
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
<script src="Javascript/pagos.js"></script>

<script>
  document.getElementById('cuenta').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value !== "") {
      document.getElementById('datoBanco').textContent = selectedOption.getAttribute('data-nombre');
      document.getElementById('datoNumero').textContent = selectedOption.getAttribute('data-numero');
      document.getElementById('datoRif').textContent = selectedOption.getAttribute('data-rif');
      document.getElementById('datoTelefono').textContent = selectedOption.getAttribute('data-telefono');
      document.getElementById('datoCorreo').textContent = selectedOption.getAttribute('data-correo');
      document.getElementById('tablaDatosCuenta').style.display = 'block';
    }
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
