$(document).ready(function () {

$('#formularioPago').on('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);

    $.ajax({
        url: '', // mismo archivo PHP
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                Swal.fire({
                    title: 'Éxito',
                    text: 'Orden de Despacho ingresada exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redireccionar después de éxito
                    window.location.href = '?pagina=pasarela'; // 🔁 cambia esto según a dónde quieres ir
                });

                // Bloque para evitar retroceso
                history.pushState(null, '', location.href);
                window.addEventListener('popstate', function () {
                    window.location.href = '?pagina=GestionarFactura';
                });

            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Error al registrar la orden de despacho',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error',
                text: 'Error en la solicitud AJAX: ' + error,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});


    });



function enviarAjax(datos, callback) {
    console.log("Enviando datos AJAX: ", datos);
    $.ajax({
        url: '', 
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta) {
            console.log("Respuesta del servidor: ", respuesta); 
            callback(JSON.parse(respuesta));
        },
        error: function () {
            console.error('Error en la solicitud AJAX');
            muestraMensaje('Error en la solicitud AJAX');
        }
    });
}

function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}


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

