$(document).ready(function () {
    // Cargar datos de la orden de despacho en el modal al abrir
    $(document).on('click', '.modificar', function() {
        var id_despacho = $(this).data('id');

        // Establecer el id en el campo oculto del formulario
        $('#modificar_id_despacho').val(id_despacho);

        // Realizar solicitud AJAX para obtener los datos
        $.ajax({
            url: '', // Mismo archivo controlador
            type: 'POST',
            dataType: 'json',
            data: { 
                id_despachos: id_despacho, 
                accion: 'obtener_orden' 
            },
            success: function(orden) {
                console.log('Datos de la orden obtenidos:', orden);
                
                // Llenar campos del formulario
                $('#modificar_fecha').val(orden.fecha_despacho);
                $('#modificar_correlativo').val(orden.correlativo);
                
                // Cargar facturas disponibles y seleccionar la correcta
                $.ajax({
                    url: '',
                    type: 'POST',
                    dataType: 'json',
                    data: { accion: 'obtener_facturas' },
                    success: function(facturas) {
                        let select = $('#modificar_factura');
                        select.empty();
                        select.append('<option value="" disabled>Seleccionar Factura</option>');
                        
                        facturas.forEach(function(factura) {
                            let option = $('<option>')
                                .val(factura.id_factura)
                                .text(factura.numero_factura);
                            
                            if(factura.id_factura == orden.id_factura) {
                                option.prop('selected', true);
                            }
                            
                            select.append(option);
                        });
                        
                        // Mostrar el modal después de cargar todo
                        $('#modificar_orden_modal').modal('show');
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos de la orden.');
            }
        });
    });

    // Enviar datos de modificación por AJAX
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
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $('#modificar_orden_modal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La orden se ha modificado correctamente'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la orden:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la orden.');
            }
        });
    });

    // Eliminar orden de despacho
    $(document).on('click', '.eliminar', function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarla!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'La orden ha sido eliminada.',
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

    // Crear nueva orden de despacho
    $('#incluirordendespacho').on('submit', function(event) {
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
                            text: 'Orden creada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al crear la orden',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al procesar la respuesta',
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

// Función para cambiar estatus (si aplica)
function cambiarEstatus(idOrden) {
    const span = $(`span[onclick*="cambiarEstatus(${idOrden}"]`);
    const estatusActual = span.text().trim().toLowerCase();
    const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';
    
    span.addClass('cambiando');
    
    $.ajax({
        url: '',
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
                // Revertir visualmente
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

// Funciones auxiliares
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

function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}

// Paginación (si aplica)
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
});