
document.getElementById('cuenta').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value !== "") {
      // Obtener los datos del atributo data-*
      const banco = selectedOption.getAttribute('data-nombre');
      const numero = selectedOption.getAttribute('data-numero');
      const rif = selectedOption.getAttribute('data-rif');
      const telefono = selectedOption.getAttribute('data-telefono');
      const correo = selectedOption.getAttribute('data-correo');

      // Insertar los datos en la tabla
      document.getElementById('datoBanco').textContent = banco;
      document.getElementById('datoNumero').textContent = numero;
      document.getElementById('datoRif').textContent = rif;
      document.getElementById('datoTelefono').textContent = telefono;
      document.getElementById('datoCorreo').textContent = correo;

      // Mostrar la tabla y el título
      const contenedor = document.getElementById('tablaDatosCuenta');
      contenedor.style.display = 'block';

      // Agregar título si no existe aún
      if (!document.getElementById('tituloDatosPago')) {
        const titulo = document.createElement('h4');
        titulo.id = 'tituloDatosPago';
        titulo.textContent = 'DATOS PARA REALIZAR EL PAGO';
        titulo.style.marginBottom = '10px';
        titulo.style.marginTop = '20px';
        contenedor.insertBefore(titulo, contenedor.firstChild);
      }
    }
  });


document.getElementById('formularioPago').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe inmediatamente

    // Crear un objeto FormData para capturar los datos
    var formData = new FormData(this);

    // Preparar el mensaje
    var mensaje = "Datos enviados:\n\n";
    formData.forEach(function(valor, clave) {
        mensaje += clave + ": " + valor + "\n";
    });

    // Mostrar todos los datos en un alert
    alert(mensaje);

    // Opcional: después del alert, puedes enviar realmente el formulario
    this.submit();
});
