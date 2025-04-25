$(document).ready(function () {
    // Cargar datos del clientes en el modal al abrir
    $(document).on('click', '.btn-modificar', function() {
        var id_clientes = $(this).data('id');

        // Establecer el id_producto en el campo oculto del formulario de modificación
        $('#modificar_id_clientes').val(id_clientes);

        // Realizar una solicitud AJAX para obtener los datos del clientes desde la base de datos
        $.ajax({
            url: '', // Ruta al controlador PHP que maneja las peticiones
            type: 'POST',
            dataType: 'json',
            data: { id_clientes: id_clientes, accion: 'obtener_clientes' },
            success: function(clientes) {
                console.log('Datos del Cliente obtenidos:', clientes);
                // Llenar los campos del formulario con los datos obtenidos del clientes
                $('#modificarnombre').val(clientes.nombre);
                $('#modificarpersona_contacto').val(clientes.persona_contacto);
                $('#modificardireccion').val(clientes.direccion);
                $('#modificartelefono').val(clientes.telefono);
                $('#modificartelefono_secundario').val(clientes.telefono_secundario);
                $('#modificarrif').val(clientes.rif);
                $('#modificarcorreo').val(clientes.correo);
                $('#modificarobservaciones').val(clientes.observaciones);
                $('#modificaractivo').val(clientes.activo);
                
                // Ajustar la imagen si se maneja la carga de imágenes
                // $('#modificarImagen').val(clientes.imagen);

                // Mostrar el modal de modificación después de llenar los datos
                $('#modificar_clientes_modal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos del Cliente.');
            }
        });
    });


    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarclientes').on('submit', function(e) {
        e.preventDefault();

        // Crear un objeto FormData con los datos del formulario
        var formData = new FormData(this);
        formData.append('accion', 'modificar');

        // Enviar la solicitud AJAX al controlador PHP
        $.ajax({
            url: '', // Asegúrate de que la URL sea correcta
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                response = JSON.parse(response); // Asegúrate de que la respuesta sea un objeto JSON
                if (response.status === 'success') {
                    $('#modificarProductoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El Cliente se ha modificado correctamente'
                    }).then(function() {
                        location.reload(); // Recargar la página al modificar un producto
                    });
                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el Cliente:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el Cliente.');
            }
        });
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

