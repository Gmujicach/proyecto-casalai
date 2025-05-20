$(document).ready(function () {
// Abrir modal y llenar campos
$('#modificarPago').length
$(document).on('click', '.modificar', function() {
    console.log("Click en botón modificar");
    var boton = $(this);

    $('#modificarIdDetalles').val(boton.data('id'));
    $('#modificarCuenta').val(boton.data('cuenta'));
    $('#modificarReferencia').val(boton.data('referencia'));
    $('#modificarFecha').val(boton.data('fecha'));

    $('#modificarPago').modal('show');
});

// Enviar datos por AJAX
$('#modificarPagoForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('accion', 'modificar');

    $.ajax({
        url: '', // Cambia esto si tienes un archivo separado para manejar la petición
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            try {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $('#modificarPago').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El pago se ha modificado correctamente'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    muestraMensaje(response.message);
                }
            } catch (e) {
                console.error('Error en la respuesta JSON', e);
                muestraMensaje('Error en la respuesta del servidor.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al modificar el pago:', textStatus, errorThrown);
            muestraMensaje('Error al modificar el pago.');
        }
    });
});

$('#formModificarEstado').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('accion', 'modificar_estado');

    $.ajax({
        url: '', // Cambia esto si tienes un archivo separado para manejar la petición
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            try {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $('#modificarEstadoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El estado del pago se ha modificado correctamente'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    muestraMensaje(response.message);
                }
            } catch (e) {
                console.error('Error en la respuesta JSON', e);
                muestraMensaje('Error en la respuesta del servidor.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al modificar el pago:', textStatus, errorThrown);
            muestraMensaje('Error al modificar el pago.');
        }
    });
});
    

    
  
    $(document).on('click', '.btn-eliminar', function (e) {
        e.preventDefault(); 
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                console.log("ID del producto a eliminar: ", id); 
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El producto ha sido eliminado.',
                            'success'
                        ).then(function() {
                            location.reload(); 
                        });
                    } else {
                        muestraMensaje(respuesta.message);
                    }
                });
            }
        });
    });

$(document).on('click', '.modificarEstado', function (e) {
  e.preventDefault();

  const idPago = $(this).data('id');
  const estatus = $(this).data('estatus');
  const observaciones = $(this).data('observaciones');

  $('#estadoIdPago').val(idPago);
  $('#estatus').val(estatus);
  $('#observaciones').val(observaciones);

  $('#modificarEstadoModal').modal('show');
});


    function estatusAClase(estatus) {
        return estatus
            .toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // elimina tildes
            .replace(/\s+/g, '-') // espacios por guiones
            .replace(/[^a-z\-]/g, ''); // elimina caracteres no válidos
    }

    function aplicarClasesEstatus() {
        const elementos = document.querySelectorAll('.campo-estatus');

        elementos.forEach(el => {
            const estatus = el.dataset.estatus;
            const clase = estatusAClase(estatus);
            el.classList.add(clase);
        });
    }

    // Ejecutar al cargar la página
    document.addEventListener('DOMContentLoaded', aplicarClasesEstatus);


   
    $('#incluirProductoForm').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Producto ingresado exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al ingresar el producto',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al procesar la respuesta del servidor',
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
