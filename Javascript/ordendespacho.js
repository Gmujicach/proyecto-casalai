$(document).ready(function () {
    $(document).on('click', '.modificar', function (e) {
        e.preventDefault(); // Evita que el enlace haga scroll o recargue
    
        var boton = $(this);
    
        // Llenar los campos del modal con los datos del botón
        $('#modificar_id_orden').val(boton.data('id'));
        $('#modificar_fecha').val(boton.data('fecha'));
        $('#modificar_correlativo').val(boton.data('correlativo'));
        $('#modificar_factura').val(boton.data('factura'));
    
        // Mostrar el modal
        $('#modificar_orden_modal').modal('show');
    });
    

    $('#modificarorden').on('submit', function(e) {
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
                console.log('Respuesta del servidor:', response);
                response = JSON.parse(response); 
                if (response.status === 'success') {
                    $('#modificarProductoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El producto se ha modificado correctamente'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el producto:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el producto.');
            }
        });
    });

    $(document).on('click', '.eliminar', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        eliminarOrdenDespacho(id);
    });
    
    function eliminarOrdenDespacho(id) {
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
                console.log("ID del despacho a eliminar: ", id); 
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'La orden de despacho ha sido eliminada.',
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
    }

    


   
    $('#incluirordendepacho').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Orden de Despacho ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al registrar la orden de despacho',
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
/*const URL_CONTROLADOR = 'controladores/despachos.controlador.php';
    /*Función para cambiar estatus
    function cambiarEstatus(idOrden) {
        const span = $(`span[onclick*="cambiarEstatus(${idOrden}"]`);
        const estatusActual = span.text().trim().toLowerCase();
        const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';

        span.addClass('cambiando');

        $.ajax({
            url: URL_CONTROLADOR,
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'cambiar_estatus',
                id_despachos: idOrden,
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
                    span.text(estatusActual);
                    span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                    Swal.fire('Error', data.message || 'Error al cambiar el estatus', 'error');
                }
            },
            error: function(xhr, status, error) {
                span.removeClass('cambiando');
                span.text(estatusActual);
                span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    }

    // Función auxiliar AJAX
    function enviarAjax(datos, callback) {
        $.ajax({
            url: URL_CONTROLADOR,
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

    // Mostrar mensajes con SweetAlert
    function muestraMensaje(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: mensaje
        });
    }

    // Paginación
    $(document).on('click', '.flecha-izquierda, .flecha-derecha', function(e) {
        e.preventDefault();
        const url = $(this).closest('a').attr('href');
        if(url) {
            window.location.href = url;
        }
    });

    $('#filasPorPagina').change(function() {
        const url = new URL(window.location.href);
        url.searchParams.set('filas', this.value);
        url.searchParams.set('pagina', 1);
        window.location.href = url.toString();
    });*/
