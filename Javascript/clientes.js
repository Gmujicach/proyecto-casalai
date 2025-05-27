$(document).ready(function () {
    // Cargar datos del clientes en el modal al abrir
        $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_clientes').val($(this).data('id'));
        $('#modificarnombre').val($(this).data('nombre'));
        $('#modificarcedula').val($(this).data('cedula'));
        $('#modificardireccion').val($(this).data('direccion'));
        $('#modificartelefono').val($(this).data('telefono'));
        $('#modificarcorreo').val($(this).data('correo'));
        $('#smnombre_cliente').text('');
        $('#modificar_clientes_modal').modal('show');
    });


    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarclientes').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('accion', 'modificar');

        $.ajax({
            url: '', // Asegúrate de que la URL sea correcta
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $('#modificar_clientes_modal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El Cliente se ha modificado correctamente'
                    });

                    // Actualiza la fila en la tabla sin recargar
                    let id = $('#modificar_id_clientes').val();
                    let fila = $(`tr[data-id="${id}"]`);
                    fila.find('td').eq(1).text($('#modificarnombre').val());
                    fila.find('td').eq(2).text($('#modificardireccion').val());
                    fila.find('td').eq(3).text($('#modificartelefono').val());
                    fila.find('td').eq(4).text($('#modificarcedula').val());
                    fila.find('td').eq(5).text($('#modificarcorreo').val());
                    fila.find('td').eq(6).text($('#modificaractivo').val());

                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                muestraMensaje('Error al modificar el Cliente.');
            }
        });
    });

    // Cerrar modal de modificación
    $(document).on('click', '#modificar_clientes_modal .close', function() {
        $('#modificar_clientes_modal').modal('hide');
    });

    // Función para eliminar el producto
    $(document).on('click', '.btn-eliminar', function (e) {
        e.preventDefault(); // Evitar la redirección predeterminada del enlace
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
                console.log("ID de el Cliente a eliminar: ", id); // Punto de depuración
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El Cliente ha sido eliminado.',
                            'success'
                        ).then(function() {
                            location.reload(); // Recargar la página al eliminar un producto
                        });
                    } else {
                        muestraMensaje(respuesta.message);
                    }
                });
            }
        });
    });

    // Función para incluir un nuevo producto
    $('#incluirclientes').on('submit', function(event) {
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
                            text: 'Cliente ingresado exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al ingresar el Cliente',
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

// Función genérica para enviar AJAX
function enviarAjax(datos, callback) {
    console.log("Enviando datos AJAX: ", datos); // Punto de depuración
    $.ajax({
        url: '', // Asegúrate de que la URL apunte al controlador correcto
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta) {
            console.log("Respuesta del servidor: ", respuesta); // Punto de depuración
            callback(JSON.parse(respuesta));
        },
        error: function () {
            console.error('Error en la solicitud AJAX');
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

