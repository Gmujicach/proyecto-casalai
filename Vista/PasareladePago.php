<?php if ($_SESSION['nombre_rol'] == 'Cliente' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
  </head>

  <body class="fondo"
    style="height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <?php include 'newnavbar.php'; ?>

    <!-- CONTENEDOR FLEXIBLE -->
    <div class="contenedor-flex"
      style="display: flex; justify-content: center; align-items: flex-start; gap: 2rem; padding: 2rem; flex-wrap: wrap;">

      <!-- FORMULARIO -->
      <div class="formulario"
        style="background-color: rgba(255,255,255,0.95); padding: 2rem; border-radius: 10px; max-width: 400px;">
        <form id="formularioPago" method="POST" action="?pagina=pasarela&accion=ingresar">
          <input type="hidden" name="accion" value="ingresar">
          <h3 class="titulo-form">REGISTRAR PAGO</h3>
  <div class="envolver-form">
  <label for="tipo">Tipo de pago</label>
  <select id="tipo" name="tipo" class="control-form" required>
    <option value="" disabled selected>Seleccionar</option>
    <!-- Las opciones se llenarán dinámicamente -->
  </select>
  <span id="stipo"></span>
</div>
          <div class="envolver-form">
            <label for="cuenta">Cuenta a la cual pagó</label>
            <select class="control-form" id="cuenta" name="cuenta" disabled required>
              <option value="" disabled selected>Seleccione una cuenta</option>
              <?php foreach ($listadocuentas as $cuenta): ?>

                <option value="<?php echo $cuenta['id_cuenta']; ?>" data-nombre="<?php echo $cuenta['nombre_banco']; ?>"
                  data-numero="<?php echo $cuenta['numero_cuenta']; ?>" data-rif="<?php echo $cuenta['rif_cuenta']; ?>"
                  data-telefono="<?php echo $cuenta['telefono_cuenta']; ?>"
                  data-correo="<?php echo $cuenta['correo_cuenta']; ?>" data-metodos="<?php echo $cuenta['metodos']; ?>">
                  <?php echo $cuenta['nombre_banco'] . " - " . $cuenta['numero_cuenta']; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span id="scuenta"></span>
          </div>

          <div class="envolver-form">
            <label for="referencia">Referencia</label>
            <input type="text" placeholder="Número de referencia" class="control-form" id="referencia" name="referencia"
              required>
            <span id="sreferencia"></span>
          </div>

          <div class="envolver-form">
            <label for="fecha">Fecha de pago</label>
            <input type="date" class="control-form" id="fecha" name="fecha" required>
            <span id="sfecha"></span>
          </div>

          <div class="envolver-form">
            <label for="comprobante">Comprobante (imagen)</label>
            <input type="file" id="comprobante" name="comprobante" class="control-form" accept="image/*" required>
            <span id="scomprobante"></span>
          </div>

          <div class="envolver-form">
            <label for="monto">Monto</label>
            <input type="text" placeholder="<?php echo $monto . ' Bs' ?>" class="control-form" id="monto" name="monto"
              disabled>
            <span id="smonto"></span>
          </div>

          <input type="hidden" name="id_factura" value="<?php echo $idFactura; ?>">
          <button class="boton-form" type="submit">Registrar</button>
        </form>
      </div>

      <!-- DATOS DE LA CUENTA -->
      <div id="tablaDatosCuenta" class="datos-cuenta"
        style="display: none; background-color: rgba(255,255,255,0.95); padding: 2rem; border-radius: 10px; max-width: 400px; min-width: 300px;">
        <h3 style="margin-bottom: 1rem;">Datos de la Cuenta</h3>
        <table border="1" cellpadding="5" style="width: 100%;">
          <tr>
            <th>Banco</th>
            <td id="datoBanco"></td>
          </tr>
          <tr>
            <th>Número</th>
            <td id="datoNumero"></td>
          </tr>
          <tr>
            <th>RIF</th>
            <td id="datoRif"></td>
          </tr>
          <tr>
            <th>Teléfono</th>
            <td id="datoTelefono"></td>
          </tr>
          <tr>
            <th>Correo</th>
            <td id="datoCorreo"></td>
          </tr>
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
    <script src="javascript/sweetalert2.all.min.js"></script>
    <script src="javascript/usuario.js"></script>
    <script src="javascript/validaciones.js"></script>
    <script src="javascript/pago.js"></script>

   <script>
$(document).ready(function() {
    // Ocultamos inicialmente el campo de cuenta y su label
    $('label[for="cuenta"]').parent().hide();
    
    // Primero llenamos el select de tipos de pago con los métodos disponibles
    const tiposPagoDisponibles = ['Pago Movil', 'Transferencia'];
    const $tipoSelect = $('#tipo');
    
    tiposPagoDisponibles.forEach(tipo => {
        $tipoSelect.append(`<option value="${tipo}">${tipo}</option>`);
    });

    // Obtenemos todas las cuentas disponibles al cargar la página
    const $cuentaSelect = $('#cuenta');
    const cuentasOriginales = [];
    
    $cuentaSelect.find('option').each(function() {
        if ($(this).val() !== "") {
            cuentasOriginales.push({
                element: $(this),
                metodos: $(this).data('metodos')?.split(',') || []
            });
        }
    });

    // Evento cuando cambia el tipo de pago
    $tipoSelect.on('change', function() {
        const metodoSeleccionado = $(this).val();
        
        if (metodoSeleccionado) {
            // Mostramos el campo de cuenta y habilitamos el select
            $('label[for="cuenta"]').parent().show();
            $cuentaSelect.prop('disabled', false);
            
            // Limpiamos el select de cuentas
            $cuentaSelect.empty().append('<option value="" disabled selected>Seleccione una cuenta</option>');
            
            // Filtramos las cuentas que tienen este método de pago
            cuentasOriginales.forEach(cuenta => {
                if (cuenta.metodos.includes(metodoSeleccionado)) {
                    $cuentaSelect.append(cuenta.element.clone());
                }
            });
            
            // Ocultamos el panel de datos hasta que seleccionen una cuenta
            $('#tablaDatosCuenta').hide();
        } else {
            // Si no hay tipo seleccionado, ocultamos y deshabilitamos el select de cuentas
            $('label[for="cuenta"]').parent().hide();
            $cuentaSelect.prop('disabled', true);
        }
    });

    // Evento cuando cambia la cuenta seleccionada
    $cuentaSelect.on('change', function() {
        const selectedOption = $(this).find('option:selected');
        
        if (selectedOption.val() !== "") {
            $('#datoBanco').text(selectedOption.data('nombre'));
            $('#datoNumero').text(selectedOption.data('numero'));
            $('#datoRif').text(selectedOption.data('rif'));
            $('#datoTelefono').text(selectedOption.data('telefono'));
            $('#datoCorreo').text(selectedOption.data('correo'));
            $('#tablaDatosCuenta').show();
        } else {
            $('#tablaDatosCuenta').hide();
        }
    });
});

// Validaciones del formulario de pago
$(document).ready(function() {
    // Validación del formulario al enviar
    $('#formularioPago').on('submit', function(e) {
        e.preventDefault();
        
        // Validar referencia (solo números)
        const referencia = $('#referencia').val();
        if (!/^\d+$/.test(referencia)) {
            $('#sreferencia').text('La referencia debe contener solo números').css('color', 'red');
            return false;
        } else {
            $('#sreferencia').text('');
        }

        // Validar comprobante (imagen seleccionada)
        const comprobante = $('#comprobante')[0].files[0];
        if (!comprobante) {
            $('#scomprobante').text('Debe seleccionar un comprobante').css('color', 'red');
            return false;
        } else {
            // Validar que sea una imagen
            if (!comprobante.type.match('image.*')) {
                $('#scomprobante').text('El archivo debe ser una imagen').css('color', 'red');
                return false;
            }
            $('#scomprobante').text('');
        }

        // Validar fecha (no puede ser futura)
        const fechaPago = new Date($('#fecha').val());
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0); // Eliminar la parte de la hora para comparar solo fechas
        
        if (fechaPago > hoy) {
            $('#sfecha').text('La fecha no puede ser futura').css('color', 'red');
            return false;
        } else {
            $('#sfecha').text('');
        }

        // Si todas las validaciones pasan, enviar el formulario
        this.submit();
    });

    // Validación en tiempo real para la referencia (solo números)
    $('#referencia').on('input', function() {
        const valor = $(this).val();
        if (!/^\d*$/.test(valor)) {
            $('#sreferencia').text('Solo se permiten números').css('color', 'red');
            $(this).val(valor.replace(/[^\d]/g, ''));
        } else {
            $('#sreferencia').text('');
        }
    });

    // Validación en tiempo real para la fecha
    $('#fecha').on('change', function() {
        const fechaPago = new Date($(this).val());
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        
        if (fechaPago > hoy) {
            $('#sfecha').text('La fecha no puede ser futura').css('color', 'red');
        } else {
            $('#sfecha').text('');
        }
    });

    // Validación en tiempo real para el comprobante
    $('#comprobante').on('change', function() {
        const file = this.files[0];
        if (!file) {
            $('#scomprobante').text('Debe seleccionar un comprobante').css('color', 'red');
        } else if (!file.type.match('image.*')) {
            $('#scomprobante').text('El archivo debe ser una imagen').css('color', 'red');
        } else {
            $('#scomprobante').text('');
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