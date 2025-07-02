<?php if ($_SESSION['nombre_rol'] == 'Cliente' ) { ?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">


<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
  <div class="fondo-form">
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
    <input type="text" placeholder="<?php echo $monto.'Bs' ?>" class="control-form" id="monto" name="monto" disabled>
    <span id="smonto"></span>
  </div>

  <input type="text" name="id_factura" value="<?php echo $idFactura; ?>" hidden>
  <button class="boton-form" type="submit">Registrar</button>
</form>

<div id="tablaDatosCuenta" style="display: none; margin-top: 1rem;">
  <table border="1" cellpadding="5">
    <tr><th>Banco</th><td id="datoBanco"></td></tr>
    <tr><th>Número</th><td id="datoNumero"></td></tr>
    <tr><th>RIF</th><td id="datoRif"></td></tr>
    <tr><th>Teléfono</th><td id="datoTelefono"></td></tr>
    <tr><th>Correo</th><td id="datoCorreo"></td></tr>
  </table>
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
<script src="Javascript/pagos.js"></script>
<script>
  document.getElementById('cuenta').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value !== "") {
      // Obtener los datos del atributo data-*
      const banco = selectedOption.getAttribute('data-nombre');
      const numero = selectedOption.getAttribute('data-numero');
      const rif = selectedOption.getAttribute('data-rif');
      const telefono = selectedOption.getAttribute('data-telefono');
      const correo = selectedOption.getAttribute('data-correo');

      // Colocarlos en la tabla
      document.getElementById('datoBanco').textContent = banco;
      document.getElementById('datoNumero').textContent = numero;
      document.getElementById('datoRif').textContent = rif;
      document.getElementById('datoTelefono').textContent = telefono;
      document.getElementById('datoCorreo').textContent = correo;

      // Mostrar la tabla
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