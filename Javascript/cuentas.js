$(document).ready(function () {

    // Cargar datos de la cuenta en el modal al abrir
    $(document).on('click', '.btn-modificar', function() {
        var id_cuenta = $(this).data('id');
        $('#modificar_id_cuenta').val(id_cuenta);
        $.ajax({
            url: '',
            type: 'POST',
            dataType: 'json',
            data: { id_cuenta: id_cuenta, accion: 'obtener_cuenta' },
            success: function(cuenta) {
                $('#modificar_nombre_banco').val(cuenta.nombre_banco);
                $('#modificar_numero_cuenta').val(cuenta.numero_cuenta);
                $('#modificar_rif_cuenta').val(cuenta.rif_cuenta);
                $('#modificar_telefono_cuenta').val(cuenta.telefono_cuenta);
                $('#modificar_correo_cuenta').val(cuenta.correo_cuenta);
                $('#modificarCuentaModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos de la Cuenta.');
            }
        });
    });

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarCuenta').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('accion', 'modificar');
        $.ajax({
            url: '',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $('#modificarCuentaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La Cuenta se ha modificado correctamente'
                    });
                    // Actualizar la fila correspondiente en la tabla
                    actualizarFilaCuenta(response.cuenta);
                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la Cuenta:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la Cuenta.');
            }
        });
    });

    // Función para eliminar la cuenta
    $(document).on('click', '.btn-eliminar', function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarla!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id_cuenta = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_cuenta', id_cuenta);
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'La Cuenta ha sido eliminada.',
                            'success'
                        );
                        // Eliminar la fila de la tabla
                        eliminarFilaCuenta(id_cuenta);
                    } else {
                        muestraMensaje(respuesta.message);
                    }
                });
            }
        });
    });

    // Función para incluir una nueva cuenta
    $('#registrarCuenta').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
    
        $.ajax({
            url: '', // Asegúrate de que esta URL esté definida correctamente
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
                            text: data.message || 'Cuenta ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
    
                        agregarFilaCuenta(data.cuenta);
                    } else {
                        Swal.fire({
                            title: 'Error del servidor',
                            html: `<strong>Mensaje:</strong> ${data.message || 'Error al ingresar la cuenta'}<br>
                                   <strong>Detalle:</strong> ${data.detail || 'No se proporcionó detalle adicional'}`,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error inesperado',
                        html: `<strong>Respuesta no válida del servidor.</strong><br><code>${response}</code>`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    console.error('Respuesta no válida:', response);
                }
            },
            error: function(xhr, status, error) {
                let mensajeError = `Error en la solicitud AJAX: ${status} - ${error}`;
    
                // Si el servidor devuelve algo útil en el cuerpo
                if (xhr.responseText) {
                    mensajeError += `<br><strong>Respuesta del servidor:</strong><br><code>${xhr.responseText}</code>`;
                }
    
                Swal.fire({
                    title: 'Error en la conexión',
                    html: mensajeError,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
    
                console.error('Detalles del error AJAX:', {
                    status: xhr.status,
                    responseText: xhr.responseText,
                    readyState: xhr.readyState,
                    errorThrown: error
                });
            }
        });
    });
    

    // Función para cambiar el estado de la cuenta
    $(document).on('click', '.btn-cambiar-estado', function() {
        const id_cuenta = $(this).data('id');
        const span = $(this).closest('td').find('.estado');
        const estadoActual = span.text().trim().toLowerCase();
        const nuevoEstado = estadoActual === 'Habilitado' ? 'Inhabilitado' : 'Habilitado';

        // Feedback visual inmediato
        span.addClass('cambiando');
        $.ajax({
            url: '',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'cambiar_estado',
                id_cuenta: id_cuenta,
                nuevo_estado: estado
            },
            success: function(data) {
                span.removeClass('cambiando');
                if (data.status === 'success') {
                    span.text(nuevoEstado);
                    span.removeClass('Habilitado Inhabilitado').addClass(nuevoEstado);
                    Swal.fire({
                        icon: 'success',
                        title: '¡Estado actualizado!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Revertir visualmente
                    span.text(estadoActual);
                    span.removeClass('Habilitado Inhabilitado').addClass(estadoActual);
                    Swal.fire('Error', data.message || 'Error al cambiar el estado', 'error');
                }
            },
            error: function(xhr, status, error) {
                span.removeClass('cambiando');
                // Revertir visualmente
                span.text(estadoActual);
                span.removeClass('Habilitado Inhabilitado').addClass(estadoActual);
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    });
});

// Función para agregar una nueva fila a la tabla
function agregarFilaCuenta(cuenta) {
    const nuevaFila = `
        <tr>
            <td>${cuenta.id_cuenta}</td>
            <td>${cuenta.nombre_banco}</td>
            <td>${cuenta.numero_cuenta}</td>
            <td>${cuenta.rif_cuenta}</td>
            <td>${cuenta.telefono_cuenta}</td>
            <td>${cuenta.correo_cuenta}</td>
            <td>${cuenta.estado}</td>
            <td>
                <button class="btn btn-primary btn-modificar" data-id="${cuenta.id_cuenta}">Modificar</button>
                <button class="btn btn-danger btn-eliminar" data-id="${cuenta.id_cuenta}">Eliminar</button>
            </td>
        </tr>
    `;
    $('#tablaConsultas tbody').append(nuevaFila);
}

// Función para actualizar una fila existente en la tabla
function actualizarFilaCuenta(cuenta) {
    const fila = $(`#tablaConsultas tbody tr:has(td:contains(${cuenta.id_cuenta}))`);
    fila.find('td:nth-child(2)').text(cuenta.nombre_banco);
    fila.find('td:nth-child(3)').text(cuenta.numero_cuenta);
    fila.find('td:nth-child(4)').text(cuenta.rif_cuenta);
    fila.find('td:nth-child(5)').text(cuenta.telefono_cuenta);
    fila.find('td:nth-child(6)').text(cuenta.correo_cuenta);
    fila.find('td:nth-child(7)').text(cuenta.estado);
}

// Función para eliminar una fila de la tabla
function eliminarFilaCuenta(id_cuenta) {
    $(`#tablaConsultas tbody tr:has(td:contains(${id_cuenta}))`).remove();
}
// Función genérica para enviar AJAX
function enviarAjax(datos, callback) {
    $.ajax({
        url: '',
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta) {
            callback(JSON.parse(respuesta));
        },
        error: function () {
            muestraMensaje('Error en la solicitud AJAX');
        }
    });
}

// Función genérica para mostrar mensajes
function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}

