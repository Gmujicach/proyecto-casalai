$(document).ready(function() {

    
    // Manejar el cambio en el filtro de marcas
    $('#filtroMarca').on('change', function() {
        const idMarca = $(this).val();

        $.ajax({
            url: '?pagina=catalogo',
            type: 'POST',
            data: {
                accion: 'filtrar_por_marca',
                id_marca: idMarca
            },
            beforeSend: function() {
                $('#tablaProductos').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: function(response) {
                try {
                    const data = typeof response === 'object' ? response : JSON.parse(response);
                    
                    if (data.status === 'success') {
                        $('#tablaProductos').html(data.html);
                    } else {
                        $('#tablaProductos').html(`
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-exclamation-circle"></i> ${data.message || 'Error al filtrar productos'}
                                </td>
                            </tr>
                        `);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    $('#tablaProductos').html(`
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-exclamation-triangle"></i> Error al procesar la respuesta
                            </td>
                        </tr>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);

                let errorMessage = 'Error de conexión';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                $('#tablaProductos').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-exclamation-triangle"></i> ${errorMessage}
                        </td>
                    </tr>
                `);
            }
        });
    });

    // Delegación de eventos para agregar producto al carrito
    $(document).on('click', '.btn-agregar-carrito', function() {
        const idProducto = $(this).data('id-producto');
        const button = $(this);
        
        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        
        $.ajax({
            url: '?pagina=carrito',
            type: 'POST',
            data: {
                accion: 'agregar_al_carrito',
                id_producto: idProducto
            },
            success: function(response) {
                try {
                    const data = typeof response === 'object' ? response : JSON.parse(response);
                    
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message || 'Producto agregado al carrito',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            if (typeof updateCartCount === 'function') {
                                updateCartCount();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al agregar producto'
                        });
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la respuesta del servidor'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);

                let errorMessage = 'Error de conexión';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('<i class="bi bi-cart-plus"></i> <span class="btn-text">Agregar</span>');
            }
        });
    });

    // Delegación de eventos para agregar combo al carrito
    $(document).on('click', '.btn-agregar-combo', function() {
        const button = $(this);
        const idCombo = button.data('id-combo');

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');

        Swal.fire({
            title: 'Agregando combo',
            html: 'Por favor espere mientras se agregan los productos...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '?pagina=catalogo',
            type: 'POST',
            data: {
                accion: 'agregar_combo_al_carrito',
                id_combo: idCombo
            },
            success: function(response) {
                try {
                    const data = typeof response === 'object' ? response : JSON.parse(response);

                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message || 'Combo agregado al carrito',
                            footer: `Se agregaron ${data.productos_agregados || 'varios'} productos al carrito`,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            if (typeof updateCartCount === 'function') {
                                updateCartCount();
                            }
                            // Recargar la página para actualizar los stocks
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al agregar combo'
                        });
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la respuesta del servidor'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                let errorMessage = 'Error de conexión';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('<i class="bi bi-cart-plus"></i> Agregar Combo');
            }
        });
    });
});

// Función para actualizar el contador del carrito
