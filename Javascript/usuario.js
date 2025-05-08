$(document).ready(function () {
    // Cargar datos del marcas en el modal al abrir
    $(document).on('click', '.btn-modificar', function() {
        var id_usuario = $(this).data('id');

        // Establecer el id_producto en el campo oculto del formulario de modificación
        $('#modificar_id_usuario').val(id_usuario);

        // Realizar una solicitud AJAX para obtener los datos del marcas desde la base de datos
        $.ajax({
            url: '', // Ruta al controlador PHP que maneja las peticiones
            type: 'POST',
            dataType: 'json',
            data: { id_usuario: id_usuario, accion: 'obtener_usuario' },
            success: function(usuarios) {
                console.log('Datos del Usuario obtenidos:', usuarios);
                // Llenar los campos del formulario con los datos obtenidos del marcas
                $('#modificarnombre_usuario').val(usuarios.username);
                $('#modificarclave_usuario').val(usuarios.password);
                $('#rango').val(usuarios.rango);
                
                // Ajustar la imagen si se maneja la carga de imágenes
                // $('#modificarImagen').val(marcas.imagen);

                // Mostrar el modal de modificación después de llenar los datos
                $('#modificar_usuario_modal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos de la Marca.');
            }
        });
    });

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarusuario').on('submit', function(e) {
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
                        text: 'El Usuario se ha modificada correctamente'
                    }).then(function() {
                        location.reload(); // Recargar la página al modificar un producto
                    });
                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el Usuario:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el Usuario.');
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
                console.log("ID del Usuario a eliminar: ", id); // Punto de depuración
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El Usuario ha sido eliminada.',
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
    $('#incluirusuario').on('submit', function(event) {
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
                            text: 'Usuario ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al ingresar la Marca',
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

function cambiarEstatus(idUsuario) {
    const span = $(`span[onclick*="cambiarEstatus(${idUsuario}"]`);
    const estatusActual = span.text().trim().toLowerCase();
    const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';
    
    // Feedback visual inmediato
    span.addClass('cambiando');
    
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'cambiar_estatus',
            id_usuario: idUsuario,
            nuevo_estatus: nuevoEstatus
        },
        success: function(data) {
            span.removeClass('cambiando');
            
            if (data.status === 'success') {
                span.text(nuevoEstatus);
                span.removeClass('habilitado inhabilitado').addClass(nuevoEstatus);
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Estatus actualizado!',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Revertir visualmente
                span.text(estatusActual);
                span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                Swal.fire('Error', data.message || 'Error al cambiar el estatus', 'error');
            }
        },
        error: function(xhr, status, error) {
            span.removeClass('cambiando');
            // Revertir visualmente
            span.text(estatusActual);
            span.removeClass('habilitado inhabilitado').addClass(estatusActual);
            Swal.fire('Error', 'Error en la conexión', 'error');
        }
    });
}

$(document).ready(function() {
    // Manejar clic en flechas
    $(document).on('click', '.flecha-izquierda, .flecha-derecha', function(e) {
        e.preventDefault();
        const url = $(this).closest('a').attr('href');
        if(url) {
            cambiarPagina(url.split('pagina=')[1]);
        }
    });

    // Manejar cambio en filas por página
    $('#filasPorPagina').change(function() {
        cambiarFilasPorPagina(this.value);
    });
});

function cambiarPagina(pagina) {
    const filas = $('#filasPorPagina').val();
    
    $.ajax({
        url: '',
        type: 'GET',
        data: {
            pagina: pagina,
            filas: filas,
            ajax: true
        },
        success: function(data) {
            $('#tabla-usuarios').replaceWith($(data).find('#tabla-usuarios'));
            actualizarParametrosURL(pagina, filas);
        }
    });
}

function actualizarParametrosURL(pagina, filas) {
    const url = new URL(window.location);
    url.searchParams.set('pagina', pagina);
    url.searchParams.set('filas', filas);
    window.history.pushState({}, '', url);
}