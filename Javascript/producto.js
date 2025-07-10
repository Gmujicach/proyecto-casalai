$(document).ready(function () {
    // Al abrir el modal de modificar, carga los datos del producto y sus características
$(document).on('click', '.btn-modificar', function () {
    // 1. Datos generales
    $('#modificarIdProducto').val(this.dataset.id);
    $('#modificarNombreProducto').val(this.dataset.nombre);
    $('#modificarDescripcionProducto').val(this.dataset.descripcion);
    $('#modificarModelo').val(this.dataset.modelo);
    $('#modificarStockActual').val(this.dataset.stockactual);
    $('#modificarStockMaximo').val(this.dataset.stockmaximo);
    $('#modificarStockMinimo').val(this.dataset.stockminimo);
    $('#modificarClausulaGarantia').val(this.dataset.clausula);
    $('#modificarSeriales').val(this.dataset.seriales);
    $('#modificarPrecio').val(this.dataset.precio);

    // 2. Categoría y tabla dinámica
    const tablaCategoria = this.dataset.tabla_categoria || this.dataset.categoria;
    $('#modificarCategoria').val(tablaCategoria).trigger('change');
    $('#modificar_tabla_categoria').val(tablaCategoria);

    // 3. Imagen
     const imagen = this.dataset.imagen;
    const preview = document.getElementById('modificarImagenPreview');
    preview.src = imagen;
    preview.style.display = 'block';

    // Espera a que los campos dinámicos se generen y luego coloca los valores
    setTimeout(() => {
        const categoriaObj = categoriasDinamicas.find(cat => cat.tabla === tablaCategoria);
        if (categoriaObj) {
            categoriaObj.caracteristicas.forEach(carac => {
                // camelCase para dataset
                const camelName = carac.nombre.replace(/_([a-z])/g, g => g[1].toUpperCase());
                const valor = this.dataset[camelName];
                if (valor !== undefined) {
                    $(`#modificar_${carac.nombre}`).val(valor);
                }
            });
        }
    }, 200);
    $('#modificarProductoModal').modal('show');
});

function verificarPermisosEnTiempoRealProductos() {
    var datos = new FormData();
    datos.append('accion', 'permisos_tiempo_real');
    enviarAjax(datos, function(permisos) {
        // Si no tiene permiso de consultar
        if (!permisos.consultar) {
            $('#tablaConsultas').hide();
            $('.space-btn-incluir').hide();
            if ($('#mensaje-permiso').length === 0) {
                $('.contenedor-tabla').prepend('<div id="mensaje-permiso" style="color:red; text-align:center; margin:20px 0;">No tiene permiso para consultar los registros.</div>');
            }
            return;
        } else {
            $('#tablaConsultas').show();
            $('.space-btn-incluir').show();
            $('#mensaje-permiso').remove();
        }

        // Mostrar/ocultar botón de incluir
        if (permisos.incluir) {
            $('#btnIncluirProducto').show();
        } else {
            $('#btnIncluirProducto').hide();
        }

        // Mostrar/ocultar botones de modificar/eliminar
        $('.btn-modificar').each(function() {
            if (permisos.modificar) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('.btn-eliminar').each(function() {
            if (permisos.eliminar) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Ocultar columna Acciones si ambos permisos son falsos
        if (!permisos.modificar && !permisos.eliminar) {
            $('#tablaConsultas th:first-child, #tablaConsultas td:first-child').hide();
        } else {
            $('#tablaConsultas th:first-child, #tablaConsultas td:first-child').show();
        }
    });
}

// Llama la función al cargar la página y luego cada 10 segundos
$(document).ready(function() {
    verificarPermisosEnTiempoRealProductos();
    setInterval(verificarPermisosEnTiempoRealProductos, 10000); // 10 segundos
});
    
    

    
    $('#modificarProductoForm').on('submit', function(e) {
        e.preventDefault();
        $('#modificar_tabla_categoria').val($('#modificarCategoria').val());
           let caracteristicasInvalidas = [];
    $('#caracteristicasCategoria input[type="number"]').each(function() {
        if (parseFloat($(this).val()) < 0) {
            caracteristicasInvalidas.push($(this).attr('name'));
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    let caracteristicasTextoInvalidas = [];
$('#caracteristicasCategoriaModificar input[type="text"]').each(function() {
    if (!regexTexto.test($(this).val())) {
        caracteristicasTextoInvalidas.push($(this).attr('name'));
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});
if (caracteristicasTextoInvalidas.length > 0) {
    Swal.fire({
        icon: 'error',
        title: 'Error en características',
        text: 'Las características de texto solo pueden contener letras, números, espacios, @, punto y guion.'
    });
    return;
}
    if (caracteristicasInvalidas.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error en características',
            text: 'Las características numéricas no pueden tener valores negativos.'
        });
        return;
    }

        var formData = new FormData(this);
        formData.append('accion', 'modificar');
    let datos = {};
    for (let [key, value] of formData.entries()) {
        datos[key] = value;
    }
    console.log('Datos enviados al controlador:\n' + JSON.stringify(datos, null, 2))
       
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
    var id_producto = $(this).data('id');
    
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
            datos.append('id_producto', id_producto); // Cambiado a id_producto
            
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
                                'El producto ha sido eliminado.',
                                'success'
                            ).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                respuesta.message || 'Error al eliminar el producto',
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

    $('#btnIncluirProducto').on('click', function() {
        $('#incluirProductoForm')[0].reset();
        $('#registrarProductoModal').modal('show');
    });

    function soloTextoPermitido(e) {
    // Permite: letras, números, espacio, @, . y -
    const regex = /^[a-zA-Z0-9@\.\-\s]+$/;
    let valor = e.target.value;
    // Si el valor no cumple, elimina el último caracter ingresado
    if (!regex.test(valor)) {
        e.target.value = valor.replace(/[^a-zA-Z0-9@\.\-\s]/g, '');
    }
}
    $(document).on('click', '#registrarProductoModal .close', function() {
        $('#registrarProductoModal').modal('hide');
    });

$('#incluirProductoForm').on('submit', function(event) {
    event.preventDefault();
 
 

    // Validaciones antes del envío
    let errores = [];

    const nombre = $('#nombre_producto').val().trim();
    const descripcion = $('#descripcion_producto').val().trim();
    const modelo = $('#modelo').val();
    const stockActual = parseInt($('#Stock_Actual').val());
    const stockMinimo = parseInt($('#Stock_Minimo').val());
    const stockMaximo = parseInt($('#Stock_Maximo').val());
    const categoria = $('#Categoria').val();
    const seriales = $('#Seriales').val().trim();
    const precioInput = $('#Precio').val().trim().replace(',', '.');
    const precio = Number(precioInput);
    const precioRegex = /^\d+(\.\d{0,2})?$/;

    // Solo letras, números y espacios
    const regexTexto = /^[a-zA-Z0-9ÁÉÍÓÚáéíóúñÑ\s]+$/;
    let caracteristicasInvalidas = [];
    $('#caracteristicasCategoria input[type="number"]').each(function() {
        if (parseFloat($(this).val()) < 0) {
            caracteristicasInvalidas.push($(this).attr('name'));
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (caracteristicasInvalidas.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error en características',
            text: 'Las características numéricas no pueden tener valores negativos.'
        });
        return;
    }

    if (!regexTexto.test(nombre)) {
        errores.push("El nombre del producto solo puede contener letras, números y espacios.");
    }
    if (descripcion && !regexTexto.test(descripcion)) {
        errores.push("La descripción solo puede contener letras, números y espacios.");
    }
    if (nombre.length < 3) {
        errores.push("El nombre del producto debe tener al menos 3 caracteres.");
    }

    if (!modelo) {
        errores.push("Debe seleccionar un modelo.");
    }

    if (isNaN(stockActual) || stockActual <= 0) {
        errores.push("El Stock Actual debe ser mayor a 0.");
    }

    if (isNaN(stockMinimo) || stockMinimo <= 0) {
        errores.push("El Stock Mínimo debe ser mayor a 0.");
    }

    if (isNaN(stockMaximo) || stockMaximo <= 0) {
        errores.push("El Stock Máximo debe ser mayor a 0.");
    }

    if (!isNaN(stockMinimo) && !isNaN(stockMaximo) && stockMinimo >= stockMaximo) {
        errores.push("El Stock Mínimo debe ser menor al Stock Máximo.");
    }

    if (isNaN(stockActual) || stockActual < 0) {
    errores.push("El Stock Actual debe ser mayor o igual a 0.");
}

    if (!categoria) {
        errores.push("Debe seleccionar una categoría.");
    }

    if (seriales.length === 0) {
        errores.push("Debe ingresar el código serial.");
    }
    let caracteristicasTextoInvalidas = [];
$('#caracteristicasCategoria input[type="text"]').each(function() {
    if (!regexTexto.test($(this).val())) {
        caracteristicasTextoInvalidas.push($(this).attr('name'));
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});
if (caracteristicasTextoInvalidas.length > 0) {
    Swal.fire({
        icon: 'error',
        title: 'Error en características',
        text: 'Las características de texto solo pueden contener letras, números, espacios, @, punto y guion.'
    });
    return;
}

    if (!precioRegex.test(precioInput)) {
    errores.push("El precio debe ser un número válido con hasta 2 decimales.");
} else if (precio <= 0) {
    errores.push("El precio debe ser mayor a 0.");
}

$('#Precio').val($('#Precio').val().replace(',', '.'));

    // VALIDACIONES ADICIONALES POR CATEGORÍA
 

    if (errores.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Errores en el formulario',
            html: errores.join("<br>"),
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    // Si pasa validación, continuar con el envío AJAX
    const formData = new FormData(this);
    let datos = {};
    for (let [key, value] of formData.entries()) {
        datos[key] = value;
    }
    // Mostrar en consola y en un alert bonito
    console.log("Datos enviados:", datos);
    Swal.fire({
        title: 'Datos enviados',
        html: '<pre style="text-align:left;">' + JSON.stringify(datos, null, 2) + '</pre>',
        width: 600
    });
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
            console.error("Error al registrar producto:", data.message);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'No se pudo registrar el producto'
            });
        }
    } catch (e) {
        console.error("Error al parsear respuesta:", e, response);
    }
},
error: function(xhr, status, error) {
    console.error("Error AJAX:", status, error, xhr.responseText);
}
    });
});

document.getElementById('imagen').addEventListener('change', function (event) {
  const input = event.target;
  const preview = document.getElementById('imagenPreview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = '#';
    preview.style.display = 'none';
  }
});

document.querySelectorAll('.btn-modificar').forEach(btn => {
  btn.addEventListener('click', function () {
    // ...otros campos...
    const imagen = this.dataset.imagen; // ya es la ruta completa
const preview = document.getElementById('modificarImagenPreview');
preview.src = imagen;
preview.style.display = 'block';

    // Limpiar input file
    document.getElementById('modificarImagen').value = '';
    // Limpiar preview si cambia la imagen
    document.getElementById('modificarImagen').onchange = function (event) {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
      } else {
        preview.src = rutaImagen;
      }
    };
    // ...resto del código...
    $('#modificarProductoModal').modal('show');
  });
});

$('#Precio').on('input', function() {
    let precioInput = $(this).val().trim().replace(',', '.');
    const precioRegex = /^\d+(\.\d{0,2})?$/;
    if (!precioRegex.test(precioInput) && precioInput !== "") {
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});
    // Cerrar modal de modificación
    $(document).on('click', '#modificarProductoModal .close', function() {
        $('#modificarProductoModal').modal('hide');
    });
    
    // Delegación para el despliegue de opciones (modificar/eliminar)
    $('#tablaConsultas').on('click', '.vertical', function(e) {
        e.stopPropagation(); // Prevenir cierre inmediato

        // Cerrar todos los menús primero
        $('.desplegable').not($(this).next('.desplegable')).hide();

        // Alternar el menú actual
        const menuActual = $(this).next('.desplegable');
        menuActual.toggle();
    });

    // Cerrar el menú si se hace clic fuera
    $(document).on('click', function() {
        $('.desplegable').hide();
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
            id_producto: idUsuario,
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
function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}