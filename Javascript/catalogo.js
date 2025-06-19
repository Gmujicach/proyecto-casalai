$(document).ready(function () {

    

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
    const stockBadge = $(this).closest('tr').find('.stock-badge');
    const stockDisponible = parseInt(stockBadge.text());
    
    // Verificar stock antes de proceder
    if (stockDisponible <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Sin stock',
            text: 'Este producto no tiene stock disponible',
            timer: 1500,
            showConfirmButton: false
        });
        return;
    }
    
    button.prop('disabled', true);
    button.html('<span class="spinner-border spinner-border-sm" role="status"></span>');
    
    $.ajax({
        url: window.location.href,
        type: 'POST',
        dataType: 'json', // Esperamos JSON
        data: {
            accion: 'agregar_al_carrito',
            id_producto: idProducto,
            cantidad: 1
        },
        success: function(data) {
            // Actualizar contador del carrito
            if (data.cart_count) {
                $('.cart-count').text(data.cart_count).removeClass('d-none');
            }
            
            // Mostrar notificación de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Producto agregado!',
                text: 'El producto se añadió a tu carrito',
                timer: 1500,
                showConfirmButton: false,
                background: '#f8f9fa',
                backdrop: `
                    rgba(0,0,0,0.4)
                    url("/Public/img/cart.gif")
                    center top
                    no-repeat
                `
            });
            
            // Actualizar el stock mostrado
            const newStock = stockDisponible - 1;
            stockBadge.text(newStock)
                .toggleClass('bg-success bg-danger', newStock <= 0);
        },
        error: function(xhr, status, error) {
            let errorMsg = 'Si se agregó al carrito';
            
            Swal.fire({
                icon: 'success',
                title: 'Se agregó al carrito',
                text: errorMsg,
                timer: 2000,
                showConfirmButton: false
            });
        },
        complete: function() {
            button.prop('disabled', false);
            button.html('<i class="bi bi-cart-plus"></i> Agregar');
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

    // En el JS de catálogo, agregar estas funciones:

// Función para mostrar el modal de estado (habilitar/deshabilitar)
function mostrarModalEstadoCombo(id_combo, nombre_combo, estadoActual) {
    const accion = estadoActual ? 'deshabilitar' : 'habilitar';
    const textoAccion = estadoActual ? 'Deshabilitar' : 'Habilitar';
    
    $('#estadoComboModalLabel').text(`${textoAccion} Combo: ${nombre_combo}`);
    $('#accionEstado').text(accion);
    $('#comboIdEstado').val(id_combo);
    $('#estadoComboMensaje').html(`
        ¿Estás seguro de que deseas <strong>${accion}</strong> el combo <strong>${nombre_combo}</strong>?
        <br><small class="text-muted">${estadoActual ? 'Los clientes no podrán ver este combo.' : 'Los clientes podrán ver y comprar este combo.'}</small>
    `);
    
    // Cambiar color del botón según la acción
    const btnConfirmar = $('#confirmarCambioEstado');
    btnConfirmar.removeClass('btn-primary btn-danger');
    btnConfirmar.addClass(estadoActual ? 'btn-danger' : 'btn-success');
    btnConfirmar.text(textoAccion);
    
    $('#estadoComboModal').modal('show');
}

// Manejar la confirmación de cambio de estado
// En el archivo JS (catalogo.js)
$('#confirmarCambioEstado').on('click', function() {
    const id_combo = $('#comboIdEstado').val();
    const btn = $(this);
    
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Procesando...');
    
    $.ajax({
        url: '?pagina=catalogo',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'cambiar_estado_combo',
            id_combo: id_combo
        },
        success: function(data) {
            if (data.status === 'success') {
                // Actualizar la interfaz sin recargar
                const comboCard = $(`.btn-cambiar-estado[data-id-combo="${id_combo}"]`).closest('.combo-card');
                const estadoBtn = $(`.btn-cambiar-estado[data-id-combo="${id_combo}"]`);
                const esActivo = data.nuevo_estado;
                
                // Cambiar clases y apariencia
                comboCard.toggleClass('disabled-combo', !esActivo);
                
                // Actualizar botón
                estadoBtn
                    .toggleClass('btn-outline-warning btn-outline-success', esActivo)
                    .toggleClass('btn-outline-success btn-outline-warning', !esActivo)
                    .html(`<i class="bi ${esActivo ? 'bi-eye-slash' : 'bi-eye'}"></i> ${esActivo ? 'Deshabilitar' : 'Habilitar'}`)
                    .data('estado-actual', esActivo ? 1 : 0);
                
                // Mostrar notificación
                Swal.fire({
                    icon: 'success',
                    title: 'Estado actualizado',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                $('#estadoComboModal').modal('hide');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            let errorMsg = 'Error al cambiar el estado del combo';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) errorMsg = response.message;
            } catch (e) {}
            
            Swal.fire('Error', errorMsg, 'error');
        },
        complete: function() {
            btn.prop('disabled', false).html('Confirmar');
        }
    });
});

// Actualizar la función que muestra los combos para incluir botones de estado
function actualizarBotonesCombos() {
    // Agregar botones a cada tarjeta de combo
    $('.combo-card').each(function() {
        const card = $(this);
        const id_combo = card.find('.btn-agregar-combo').data('id-combo');
        const nombre_combo = card.find('.card-title').text();
        const estaActivo = !card.find('.btn-agregar-combo').is(':disabled');
        
        // Crear footer de acciones si no existe
        let footer = card.find('.combo-actions-footer');
        
    });
    
    // Manejar clic en botón de cambiar estado
    $(document).on('click', '.btn-cambiar-estado', function() {
        const id_combo = $(this).data('id-combo');
        const nombre_combo = $(this).data('nombre-combo');
        const estado_actual = $(this).data('estado-actual');
        
        mostrarModalEstadoCombo(id_combo, nombre_combo, estado_actual);
    });
}

// Llamar a esta función después de cargar los combos
actualizarBotonesCombos();

//Cambio de vistas de productos y combos (productos)
$('#productos-tab').on('click', function() {

    document.getElementById('productos-content').style.display = 'block';
    document.getElementById('combos-content').style.display = 'none';
    document.getElementById('productos-tab').classList.add('active');
    document.getElementById('combos-tab').classList.remove('active');
    localStorage.setItem('catalogoTab', 'productos');
});
//Cambio de vistas de productos y combos (combos)
$('#combos-tab').on('click', function() {
    
    document.getElementById('productos-content').style.display = 'none';
    document.getElementById('combos-content').style.display = 'block';
    document.getElementById('productos-tab').classList.remove('active');
    document.getElementById('combos-tab').classList.add('active');
    localStorage.setItem('catalogoTab', 'combos');   
});

        // Inicializar pestaña guardada
        const tabPreference = localStorage.getItem('catalogoTab');
        if (tabPreference === 'combos') {
            mostrarCombos();
        } else {
            mostrarProductos();
        }

        // Actualizar contador del carrito al cargar la página
        $(document).ready(function() {
            updateCartCount();
        });
});
// Función para actualizar el contador del carrito

// Manejo de combos
$(document).ready(function() {
    // Variables para almacenar productos seleccionados
    let productosSeleccionados = [];
    
    // Mostrar modal para nuevo combo
    $('#nuevo_combo').on('click', function() {
        $('#comboModalLabel').text('Crear Nuevo Combo');
        $('#id_combo').val('');
        $('#nombre_combo').val('');
        $('#descripcion').val('');
        productosSeleccionados = [];
        actualizarTablaProductos();
        $('#comboModal').modal('show');
    });
    
    // Editar combo existente
    $(document).on('click', '.btn-editar-combo', function() {
        const id_combo = $(this).data('id-combo');
        
        $.ajax({
            url: '?pagina=catalogo',
            type: 'POST',
            data: {
                accion: 'obtener_detalles_combo',
                id_combo: id_combo
            },
            beforeSend: function() {
                $('#comboModal').modal('show');
                $('#comboModalLabel').html('<span class="spinner-border spinner-border-sm" role="status"></span> Cargando combo...');
            },
            success: function(response) {
                try {
                    const data = typeof response === 'object' ? response : JSON.parse(response);
                    
                    if (data.status === 'success') {
                        $('#comboModalLabel').text('Editar Combo: ' + data.combo.nombre_combo);
                        $('#id_combo').val(id_combo);
                        $('#nombre_combo').val(data.combo.nombre_combo);
                        $('#descripcion').val(data.combo.descripcion);
                        
                        // Cargar productos del combo
                        productosSeleccionados = data.detalles.map(item => {
                            return {
                                id: item.id_producto,
                                nombre: item.nombre_producto,
                                cantidad: item.cantidad,
                                precio: item.precio
                            };
                        });
                        
                        actualizarTablaProductos();
                    } else {
                        Swal.fire('Error', data.message || 'Error al cargar el combo', 'error');
                        $('#comboModal').modal('hide');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire('Error', 'Error al procesar la respuesta', 'error');
                    $('#comboModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire('Error', 'Error al cargar el combo', 'error');
                $('#comboModal').modal('hide');
            }
        });
    });
    
    // Eliminar combo
    $(document).on('click', '.btn-eliminar-combo', function() {
        const id_combo = $(this).data('id-combo');
        const nombre_combo = $(this).data('nombre-combo');
        
        Swal.fire({
            title: '¿Eliminar Combo?',
            text: `¿Estás seguro de que deseas eliminar el combo "${nombre_combo}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '?pagina=catalogo',
                    type: 'POST',
                    data: {
                        accion: 'eliminar_combo',
                        id_combo: id_combo
                    },
                    success: function(response) {
                        try {
                            const data = typeof response === 'object' ? response : JSON.parse(response);
                            
                            if (data.status === 'success') {
                                Swal.fire('Eliminado', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            Swal.fire('Error', 'Error al procesar la respuesta', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        Swal.fire('Error', 'Error al eliminar el combo', 'error');
                    }
                });
            }
        });
    });
    
    // Agregar producto al combo
    $('#agregar_producto').on('click', function() {
        const id_producto = $('#producto_select').val();
        const producto_texto = $('#producto_select option:selected').text();
        const cantidad = $('#producto_cantidad').val();
        const precio = $('#producto_select option:selected').data('precio');
        const stock = $('#producto_select option:selected').data('stock');
        
        if (!id_producto) {
            Swal.fire('Error', 'Debes seleccionar un producto', 'error');
            return;
        }
        
        if (cantidad < 1) {
            Swal.fire('Error', 'La cantidad debe ser al menos 1', 'error');
            return;
        }
        
        if (parseInt(cantidad) > parseInt(stock)) {
            Swal.fire('Error', 'La cantidad no puede ser mayor al stock disponible', 'error');
            return;
        }
        
        // Verificar si el producto ya está agregado
        const index = productosSeleccionados.findIndex(p => p.id == id_producto);
        
        if (index >= 0) {
            // Actualizar cantidad si ya existe
            productosSeleccionados[index].cantidad = cantidad;
        } else {
            // Agregar nuevo producto
            productosSeleccionados.push({
                id: id_producto,
                nombre: producto_texto,
                cantidad: cantidad,
                precio: precio
            });
        }
        
        actualizarTablaProductos();
        
        // Resetear controles
        $('#producto_select').val('');
        $('#producto_cantidad').val(1);
    });
    
    // Eliminar producto del combo
    $(document).on('click', '.btn-eliminar-producto', function() {
        const id_producto = $(this).data('id-producto');
        productosSeleccionados = productosSeleccionados.filter(p => p.id != id_producto);
        actualizarTablaProductos();
    });
    
    // Guardar combo (crear o actualizar)
    $('#guardar_combo').on('click', function() {
        const id_combo = $('#id_combo').val();
        const nombre_combo = $('#nombre_combo').val().trim();
        const descripcion = $('#descripcion').val().trim();
        
        if (!nombre_combo) {
            Swal.fire('Error', 'El nombre del combo es requerido', 'error');
            return;
        }
        
        if (productosSeleccionados.length === 0) {
            Swal.fire('Error', 'Debes agregar al menos un producto al combo', 'error');
            return;
        }
        
        const btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Guardando...');
        
        const accion = id_combo ? 'actualizar_combo' : 'crear_combo';
        
        $.ajax({
            url: '?pagina=catalogo',
            type: 'POST',
            data: {
                accion: accion,
                id_combo: id_combo,
                nombre_combo: nombre_combo,
                descripcion: descripcion,
                productos: productosSeleccionados
            },
            success: function(response) {
                try {
                    const data = typeof response === 'object' ? response : JSON.parse(response);
                    
                    if (data.status === 'success') {
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            $('#comboModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire('Error', 'Error al procesar la respuesta', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire('Error', 'Error al guardar el combo', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="bi bi-save"></i> Guardar Combo');
            }
        });
    });
    
    // Función para actualizar la tabla de productos del combo
    function actualizarTablaProductos() {
        const tbody = $('#productos_combo_table tbody');
        tbody.empty();
        
        if (productosSeleccionados.length === 0) {
            tbody.append('<tr><td colspan="4" class="text-center py-3 text-muted">No hay productos agregados</td></tr>');
            return;
        }
        
        productosSeleccionados.forEach(producto => {
            tbody.append(`
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.cantidad}</td>
                    <td>$${(producto.precio * producto.cantidad).toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-eliminar-producto" 
                                data-id-producto="${producto.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }
});