$(document).ready(function() {
    // Manejar el cambio en el filtro de marcas

document.getElementById('registrar-compra').addEventListener('click', function () {
    const datos = [];

    document.querySelectorAll('.tabla tbody tr').forEach(fila => {
        const nombre = fila.children[0]?.textContent.trim();
        const cantidadInput = fila.querySelector('.cantidad');

        const cantidad = parseInt(cantidadInput?.value || 0);
        const idCarritoDetalle = cantidadInput?.dataset.idCarritoDetalle;
        const idProducto = cantidadInput?.dataset.idProducto;

        // Limpiar el precio y subtotal de símbolos y comas
        const precioText = fila.children[2]?.textContent.replace('$', '').replace(/,/g, '').trim();
        const subtotalText = fila.children[3]?.textContent.replace('$', '').replace(/,/g, '').trim();

        const precio = parseFloat(precioText);
        const subtotal = parseFloat(subtotalText);

        if (nombre && cantidad && idCarritoDetalle && idProducto) {
            datos.push({
                id_carrito_detalle: idCarritoDetalle,
                id_producto: idProducto,
                nombre: nombre,
                cantidad: cantidad,
                precio_unitario: precio,
                subtotal: subtotal
            });
        }
    });

    console.log("✅ Datos recogidos para prefactura:", datos);


    $('#registrar-compra').on('click', function() {
        Swal.fire({
            title: '¿Confirmar compra?',
            text: "¡Se registrará la compra con los productos actuales en el carrito!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, registrar compra',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        accion: 'registrar_compra',
                        productos: datos.map(d => d.id_producto),
                        cantidad: datos.map(d => d.cantidad)
                    }
                }).then(response => {
                    return JSON.parse(response);
                }).catch(error => {
                    Swal.showValidationMessage(
                        `Error en la solicitud: ${error}`
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Compra registrada!',
                        text: result.value.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                                            // Redireccionar después de éxito
                    window.location.href = '?pagina=gestionarfactura';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.value.message
                    });
                }
            }
        });
    });
});



    // Muestra los datos en consola
    console.log("Datos del carrito a enviar:", datos);

    // Opcional: mostrar en una alerta
    alert(JSON.stringify(datos, null, 2));

    // Aquí podrías enviar los datos a tu backend con fetch/ajax si deseas
});

    $('#filtroMarca').on('change', function() {
        const idMarca = $(this).val();
        
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                accion: 'filtrar_por_marca',
                id_marca: idMarca
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#tablaProductos').html(data.html);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud AJAX: ' + error
                });
            }
        });
    });

    // Manejar cambio de cantidad en el carrito
    $(document).on('change', '.cantidad', function() {
        const idCarritoDetalle = $(this).data('id-carrito-detalle');
        const cantidad = $(this).val();

        if (cantidad < 1) {
            $(this).val(1);
            return;
        }

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                accion: 'actualizar_cantidad',
                id_carrito_detalle: idCarritoDetalle,
                cantidad: cantidad
            },
            success: function(response) {
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

    // Manejar eliminación de producto del carrito
    $(document).on('click', '.btn-eliminar', function() {
        const idCarritoDetalle = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        accion: 'eliminar_del_carrito',
                        id_carrito_detalle: idCarritoDetalle
                    },
                    success: function(response) {
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

    // Manejar vaciado completo del carrito
    $('#eliminar-todo-carrito').on('click', function() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Se eliminarán todos los productos del carrito!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, vaciar carrito',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        accion: 'eliminar_todo_carrito'
                    },
                    success: function(response) {
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

    /*Manejar registro de compra

*/
    // Delegación de eventos para los botones de agregar al carrito
    $(document).on('click', '.btn-agregar-carrito', function() {
        const idProducto = $(this).data('id-producto');
        
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
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
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
