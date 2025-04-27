$(document).ready(function() {
    // Función para inicializar los botones de agregar al carrito
    function inicializarBotonesCarrito() {
        $('.form-agregar-carrito').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '', // La misma página
                type: 'POST',
                data: formData,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el producto al carrito'
                    });
                }
            });
        });
    }

    // Inicializar los botones al cargar la página
    inicializarBotonesCarrito();

    // Manejar el cambio en el filtro de marcas
    $('#filtroMarca').on('change', function() {
        var idMarca = $(this).val();

        // Enviar la solicitud AJAX para filtrar los productos
        $.ajax({
            url: '', // La misma página
            type: 'POST',
            data: {
                accion: 'filtrar_por_marca',
                id_marca: idMarca
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    // Actualizar la tabla de productos
                    $('#tablaProductos').html(response.html);
                    // Reinicializar los botones después de actualizar la tabla
                    inicializarBotonesCarrito();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud AJAX'
                });
            }
        });
    });
});
// Resto del código para manejar el carrito...
$('.cantidad').on('change', function () {
    const idCarritoDetalle = $(this).data('id-carrito-detalle');
    const cantidad = $(this).val();

    $.ajax({
        url: '',
        type: 'POST',
        data: {
            accion: 'actualizar_cantidad',
            id_carrito_detalle: idCarritoDetalle,
            cantidad: cantidad
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        }
    });
});

$('.btn-eliminar').on('click', function () {
    const idCarritoDetalle = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    accion: 'eliminar_del_carrito',
                    id_carrito_detalle: idCarritoDetalle
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        }
    });
});

$('#eliminar-todo-carrito').on('click', function () {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Se eliminarán todos los productos del carrito!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, vaciar carrito!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    accion: 'eliminar_todo_carrito'
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        Swal.fire(
                            'Carrito vaciado!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        }
    });
});

$('#registrar-compra').on('click', function () {
    Swal.fire({
        title: '¿Confirmar compra?',
        text: "¡Se registrará la compra con los productos actuales en el carrito!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar compra!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    accion: 'registrar_compra'
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        Swal.fire(
                            'Compra registrada!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        }
    });
});

$('#filtroMarca').on('change', function() {
    var idMarca = $(this).val();

    // Enviar la solicitud AJAX para filtrar los productos
    $.ajax({
        url: '', // La misma página
        type: 'POST',
        data: {
            accion: 'filtrar_por_marca',
            id_marca: idMarca
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                // Actualizar la tabla de productos
                $('#tablaProductos').html(response.html);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la solicitud AJAX'
            });
        }
    });
});

// Delegación de eventos para los botones de agregar al carrito
$(document).on('click', '.btn-agregar-carrito', function() {
    var idProducto = $(this).data('id-producto');
    
    $.ajax({
        url: '',
        type: 'POST',
        data: {
            accion: 'agregar_al_carrito',
            id_producto: idProducto
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message
                }).then(() => {
                    location.reload(); // Recargar la página para actualizar el carrito
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la solicitud AJAX'
            });
        }
    });
});