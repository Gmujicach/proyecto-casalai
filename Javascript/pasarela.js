$(document).ready(function () {
// Abrir modal y llenar campos
$('#modificarPago').length

// Evita recarga al abrir el menú de acciones
$(document).on('click', '.acciones-boton .vertical', function(e) {
    e.preventDefault();
    $('.desplegable').not($(this).siblings('.desplegable')).hide();
    $(this).siblings('.desplegable').toggle();
});

// Evita recarga en cualquier acción del menú
$(document).on('click', '.acciones-boton a', function(e) {
    e.preventDefault();
});

$(document).on('click', '.modificar', function() {
    console.log("Click en botón modificar");
    var boton = $(this);

    $('#modificarIdDetalles').val(boton.data('id'));
    $('#modificarCuenta').val(boton.data('cuenta'));
    $('#modificarReferencia').val(boton.data('referencia'));
    $('#modificarFecha').val(boton.data('fecha'));

    $('#modificarPago').modal('show');
});
$(document).on('click', '.modificar', function() {
    var boton = $(this);

    $('#modificarIdDetalles').val(boton.data('id'));
    $('#modificarCuenta').val(boton.data('cuenta'));
    $('#modificarReferencia').val(boton.data('referencia'));
    $('#modificarFecha').val(boton.data('fecha'));
    $('#modificarTipo').val(boton.data('tipo')); // <--- ¡AÑADE ESTO!
    $('#modificarFactura').val(boton.data('factura')); // <--- ¡AÑADE ESTO!

    $('#modificarPago').modal('show');
});
// Enviar datos por AJAX
// Modificar pago
$('#modificarPagoForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('accion', 'modificar');
    $.ajax({
        url: '',
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
                    });
                    if (response.pago) {
                        actualizarFilaPago(response.pago);
                    }
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

// Cambiar estatus
$('#formModificarEstado').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('accion', 'modificar_estado');
    $.ajax({
        url: '',
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
                    });
                    if (response.pago) {
                        actualizarFilaPago(response.pago);
                    }
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

function eliminarPago(id) {
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
}
$(document).on('click', '.modificarEstado', function (e) {
  e.preventDefault();

  const idPago = $(this).data('id');
  const idFactura = $(this).data('factura');
  const estatus = $(this).data('estatus');
  const observaciones = $(this).data('observaciones');

  $('#estadoIdPago').val(idPago);
  $('#modificarIdFactura').val(idFactura);
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
        const elementos = document.querySelectorAll('.campo-estatus-pagos');

        elementos.forEach(el => {
            const estatus = el.dataset.estatus;
            const clase = estatusAClase(estatus);
            el.classList.add(clase);
        });
    }
function actualizarFilaPago(pago) {
    const tabla = $('#tablaConsultas').DataTable();
    $('#tablaConsultas tbody tr').each(function() {
        // Suponiendo que la columna de referencia es única, o mejor aún, pon un data-id en el <tr>
        if ($(this).find('td:eq(3)').text().trim() == pago.referencia) {
            tabla.row(this).data([
                pago.id_factura,
                pago.tbl_cuentas,
                pago.tipo,
                pago.referencia,
                pago.fecha,
                `<span class="campo-estatus-pagos" data-estatus="${pago.estatus}" style="cursor: pointer;">${pago.estatus}</span>`,
                pago.observaciones,
                `<div class="acciones-boton">
                    <i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                    <div class="desplegable">
                        <ul>
                            <li><a href="#" class="modificarEstado" 
                                data-id="${pago.id_detalles}"
                                data-factura="${pago.id_factura}"
                                data-estatus="${pago.estatus}"
                                data-observaciones="${pago.observaciones}">
                                Cambiar Estatus
                            </a></li>
                            <li>
                                <a href="#" class="modificar"
                                    data-id="${pago.id_detalles}"
                                    data-cuenta="${pago.id_cuenta}"
                                    data-referencia="${pago.referencia}"
                                    data-fecha="${pago.fecha}"
                                    data-tipo="${pago.tipo}"
                                    data-factura="${pago.id_factura}">
                                    Modificar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>`
            ]).draw(false);
        }
    });
    aplicarClasesEstatus(); // Vuelve a aplicar las clases de estatus
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
        $.ajax({
            url: '',
            type: 'POST',
            data: datos,
            contentType: false,
            processData: false,
            cache: false,
            success: function (respuesta) {
                if (typeof respuesta === "string") {
                    respuesta = JSON.parse(respuesta);
                }
                if(callback) callback(respuesta);
            },
            error: function () {
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
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
