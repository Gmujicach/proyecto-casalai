$(document).ready(function () {
    $(document).on('click', '.modificar', function() {
    var boton = $(this);

    $('#modificar_id_proveedor').val(boton.data('id'));
    $('#modificar_nombre_proveedor').val(boton.data('nombre'));
    $('#modificar_persona_contacto').val(boton.data('persona-contacto'));
    $('#modificar_direccion').val(boton.data('direccion'));
    $('#modificar_telefono').val(boton.data('telefono'));
    $('#modificar_correo').val(boton.data('correo'));
    $('#modificar_telefono_secundario').val(boton.data('telefono-secundario'));
    $('#modificar_rif_proveedor').val(boton.data('rif-proveedor'));
    $('#modificar_rif_representante').val(boton.data('rif-representante'));
    $('#modificar_observaciones').val(boton.data('observaciones'));

    $('#modificar_usuario_modal').modal('show');
});

    // Cargar datos del marcas en el modal al abrir
        $(document).on('click', '#modificarProductoBtn', function() {
        var boton = $(this);
    
        // Llenar los campos del formulario con los datos del botón
        $('#modificarIdProducto').val(boton.data('id'));
        $('#modificarNombreProducto').val(boton.data('nombre'));
        $('#modificarModelo').val(boton.data('modelo'));
        $('#modificarStockMinimo').val(boton.data('stockminimo'));
    
        // Mostrar el modal
        $('#modificarProductoModal').modal('show');
    });
    document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modificarProductoModal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    // Obtener datos del botón
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');
    const modelo = button.closest('tr').children[2].textContent; // Usa la celda de la tabla

    // Llenar el modal
    document.getElementById('modificarIdProducto').value = id;
    document.getElementById('modificarNombreProducto').value = nombre;
    document.getElementById('modificarModelo').value = modelo;
  });
});

    $(document).on('click', '.btn-modificar', function() {
        var id_proveedor = $(this).data('id');

        // Establecer el id_producto en el campo oculto del formulario de modificación
        $('#modificar_id_proveedor').val(id_proveedor);

        // Realizar una solicitud AJAX para obtener los datos del marcas desde la base de datos
        $.ajax({
            url: '', // Ruta al controlador PHP que maneja las peticiones
            type: 'POST',
            dataType: 'json',
            data: { id_proveedor: id_proveedor, accion: 'obtener_proveedor' },
            success: function(proveedores) {
                console.log('Datos del Proveedor obtenidos:', proveedores);
                // Llenar los campos del formulario con los datos obtenidos del marcas
                $('#modificarnombre_proveedor').val(proveedores.nombre);
                $('#modificarrif_proveedor').val(proveedores.rif_proveedor);
                $('#modificarnombre_representante').val(proveedores.presona_contacto);
                $('#modificarrif_representante').val(proveedores.rif_representante);
                $('#modificardireccion_proveedor').val(proveedores.direccion);
                $('#modificartelefono_1').val(proveedores.telefono);
                $('#modificartelefono_2').val(proveedores.telefono_secundario);
                $('#modificarcorreo_proveedor').val(proveedores.correo);
                $('#modificarobservacion').val(proveedores.observaciones);
                
                // Ajustar la imagen si se maneja la carga de imágenes
                // $('#modificarImagen').val(marcas.imagen);

                // Mostrar el modal de modificación después de llenar los datos
                $('#modificar_proveedor_modal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos del Proveedor.');
            }
        });
    });

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarProveedorForm').on('submit', function(e) {
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
    response = JSON.parse(response);
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Modificado',
            text: 'El Proveedor se ha modificado correctamente'
        }).then(function() {
            // Supón que el backend retorna el proveedor modificado en response.proveedor
            if (response.proveedor) {
                actualizarFilaProveedor(response.proveedor);
            }
            $('#modificar_usuario_modal').modal('hide');
$('.modal-backdrop').remove();
$('body').removeClass('modal-open');
$('body').css('padding-right', '');
        });
    } else {
        muestraMensaje(response.message);
    }
},
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el Proveedor:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el Proveedor.');
            }
        });
    });

function actualizarFilaProveedor(proveedor) {
    const tabla = $('#tablaConsultas').DataTable();
    $('#tablaConsultas tbody tr').each(function() {
        if ($(this).attr('data-id') == proveedor.id_proveedor) {
            tabla.row(this).data([
                `<span class="campo-nombres">${proveedor.nombre}</span><span class="campo-correo">${proveedor.correo}</span>`,
                `<span class="campo-nombres">${proveedor.rif_proveedor}</span>`,
                `<span class="campo-telefono">${proveedor.telefono}</span>`,
                `<span class="campo-estatus ${proveedor.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" data-id="${proveedor.id_proveedor}" onclick="cambiarEstatus(${proveedor.id_proveedor}, '${proveedor.estado}')" style="cursor: pointer;">${proveedor.estado}</span>`,
                `<span>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li>
                                    <a href="#" class="modificar" 
                                        data-id="${proveedor.id_proveedor}"
                                        data-nombre="${proveedor.nombre}"
                                        data-persona-contacto="${proveedor.presona_contacto}"
                                        data-direccion="${proveedor.direccion}"
                                        data-telefono="${proveedor.telefono}"
                                        data-correo="${proveedor.correo}"
                                        data-telefono-secundario="${proveedor.telefono_secundario}"
                                        data-rif-proveedor="${proveedor.rif_proveedor}"
                                        data-rif-representante="${proveedor.rif_representante}"
                                        data-observaciones="${proveedor.observaciones}"
                                        data-toggle="modal" 
                                        data-target="#modificar_usuario_modal">
                                        Modificar
                                    </a>
                                </li>
                                <li><a href="#" class="eliminar" data-id="${proveedor.id_proveedor}">Eliminar</a></li>
                            </ul>
                        </div>
                    </div>
                </span>`
            ]).draw(false);
        }
    });
}

$(document).on('click', '.acciones-boton .vertical', function(e) {
    e.stopPropagation();
    $('.desplegable').not($(this).siblings('.desplegable')).hide();
    $(this).siblings('.desplegable').toggle();
});

$(document).on('click', function() {
    $('.desplegable').hide();
});

    // Función para eliminar el proveedor
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault();
    var id_proveedor = $(this).data('id');
    
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
            var datos = new FormData();
            datos.append('accion', 'eliminar');
            datos.append('id_proveedor', id_proveedor);
            
            $.ajax({
                url: '', // La misma página
                type: 'POST',
                data: datos,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        var respuesta = JSON.parse(response);
                        if (respuesta.status === 'success') {
                            Swal.fire(
                                'Eliminado!',
                                'El proveedor ha sido eliminado.',
                                'success'
                            );
                            // Elimina la fila de la tabla y actualiza el paginador
                            const tabla = $('#tablaConsultas').DataTable();
                            $('#tablaConsultas tbody tr').each(function() {
                                if ($(this).attr('data-id') == id_proveedor) {
                                    tabla.row(this).remove().draw(false);
                                }
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                respuesta.message || 'Error al eliminar el proveedor',
                                'error'
                            );
                        }
                    } catch (e) {
                        Swal.fire(
                            'Error!',
                            'Error al procesar la respuesta del servidor',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Error en la solicitud AJAX: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});

    // Función para incluir un nuevo producto
    $('#incluirproveedor').on('submit', function(event) {
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
                text: 'Proveedor ingresado exitosamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Supón que el backend retorna el proveedor insertado en data.proveedor
                if (data.proveedor) {
                    agregarFilaProveedor(data.proveedor);
                }
                $('#incluirproveedor')[0].reset();
                $('#incluirproveedor input, #incluirproveedor textarea').val('');
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al ingresar el Proveedor',
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

function agregarFilaProveedor(proveedor) {
    const tabla = $('#tablaConsultas').DataTable();
    const nuevaFila = tabla.row.add([
        `<span class="campo-nombres">${proveedor.nombre}</span><span class="campo-correo">${proveedor.correo}</span>`,
        `<span class="campo-nombres">${proveedor.rif_proveedor}</span>`,
        `<span class="campo-telefono">${proveedor.telefono}</span>`,
        `<span class="campo-estatus ${proveedor.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" data-id="${proveedor.id_proveedor}" onclick="cambiarEstatus(${proveedor.id_proveedor}, '${proveedor.estado}')" style="cursor: pointer;">${proveedor.estado}</span>`,
        `<span>
            <div class="acciones-boton">
                <i class="vertical">
                    <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                </i>
                <div class="desplegable">
                    <ul>
                        <li>
                            <a href="#" class="modificar" 
                                data-id="${proveedor.id_proveedor}"
                                data-nombre="${proveedor.nombre}"
                                data-persona-contacto="${proveedor.presona_contacto}"
                                data-direccion="${proveedor.direccion}"
                                data-telefono="${proveedor.telefono}"
                                data-correo="${proveedor.correo}"
                                data-telefono-secundario="${proveedor.telefono_secundario}"
                                data-rif-proveedor="${proveedor.rif_proveedor}"
                                data-rif-representante="${proveedor.rif_representante}"
                                data-observaciones="${proveedor.observaciones}"
                                data-toggle="modal" 
                                data-target="#modificar_usuario_modal">
                                Modificar
                            </a>
                        </li>
                        <li><a href="#" class="eliminar" data-id="${proveedor.id_proveedor}">Eliminar</a></li>
                    </ul>
                </div>
            </div>
        </span>`
    ]).draw(false).node();
    $(nuevaFila).attr('data-id', proveedor.id_proveedor);
}

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

function cambiarEstatus(idUsuario) {
    const span = $(`span.campo-estatus[data-id="${idUsuario}"]`);
    const estatusActual = span.text().trim().toLowerCase();
    const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';

    span.addClass('cambiando');

    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'cambiar_estado',
            id_proveedor: idUsuario,
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
// Función genérica para mostrar mensajes
function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}