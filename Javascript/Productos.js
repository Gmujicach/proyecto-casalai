$(document).ready(function () {
document.querySelectorAll('.btn-modificar').forEach(btn => {
  btn.addEventListener('click', function () {
    document.getElementById('modificarIdProducto').value = this.dataset.id;
    document.getElementById('modificarNombreProducto').value = this.dataset.nombre;
    document.getElementById('modificarDescripcionProducto').value = this.dataset.descripcion;
    document.getElementById('modificarModelo').value = this.dataset.modelo;
    document.getElementById('modificarStockActual').value = this.dataset.stockactual;
    document.getElementById('modificarStockMaximo').value = this.dataset.stockmaximo;
    document.getElementById('modificarStockMinimo').value = this.dataset.stockminimo;
    document.getElementById('modificarClausulaGarantia').value = this.dataset.clausula;
    document.getElementById('modificarSeriales').value = this.dataset.seriales;
    document.getElementById('modificarPrecio').value = this.dataset.precio;
    document.getElementById('modificarCategoria').value = this.dataset.categoria;

    const categoria = this.dataset.categoria;

    const dataExtra = {
      alto: this.dataset.alto,
      ancho: this.dataset.ancho,
      color: this.dataset.color,
      capacidad: this.dataset.capacidad,
      voltaje: this.dataset.voltaje,
      peso: this.dataset.peso,
      largo: this.dataset.largo,
      numero: this.dataset.numero,
      tipo: this.dataset.tipo,
      volumen: this.dataset.volumen,
      tomas: this.dataset.tomas,
      voltaje_entrada: this.dataset.voltaje_entrada,
      voltaje_salida: this.dataset.voltaje_salida,
      capacidad_bateria: this.dataset.capacidad,
      descripcion_otros: this.dataset.descripcion_otros,

    
      // agrega más si es necesario
    };

    mostrarCamposCategoria(categoria, 'modificar', dataExtra);
            // Mostrar el modal
        $('#modificarProductoModal').modal('show');
  });
});

    
    

    
    $('#modificarProductoForm').on('submit', function(e) {
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

    $(document).on('click', '#registrarProductoModal .close', function() {
        $('#registrarProductoModal').modal('hide');
    });

$('#incluirProductoForm').on('submit', function(event) {
    event.preventDefault();

    // Validaciones antes del envío
    let errores = [];

    const nombre = $('#nombre_producto').val().trim();
    const descripcion = $('#descripcion_producto').val().trim();
    const modelo = $('#Modelo').val();
    const stockActual = parseInt($('#Stock_Actual').val());
    const stockMinimo = parseInt($('#Stock_Minimo').val());
    const stockMaximo = parseInt($('#Stock_Maximo').val());
    const categoria = $('#Categoria').val();
    const seriales = $('#Seriales').val().trim();
    const precioInput = $('#Precio').val().trim().replace(',', '.');
    const precio = Number(precioInput);
    const precioRegex = /^\d+(\.\d{0,2})?$/;


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

    if (!categoria) {
        errores.push("Debe seleccionar una categoría.");
    }

    if (seriales.length === 0) {
        errores.push("Debe ingresar el código serial.");
    }

    if (!precioRegex.test(precioInput)) {
    errores.push("El precio debe ser un número válido con hasta 2 decimales.");
} else if (precio <= 0) {
    errores.push("El precio debe ser mayor a 0.");
}

$('#Precio').val($('#Precio').val().replace(',', '.'));

    // VALIDACIONES ADICIONALES POR CATEGORÍA
    switch (categoria) {
        case '1': // IMPRESORA
            const peso = parseFloat($('[name="peso"]').val());
            const alto = parseFloat($('[name="alto"]').val());
            const ancho = parseFloat($('[name="ancho"]').val());
            const largo = parseFloat($('[name="largo"]').val());

            if (isNaN(peso) || peso <= 0) errores.push("El peso debe ser un número mayor a 0.");
            if (isNaN(alto) || alto <= 0) errores.push("El alto debe ser un número mayor a 0.");
            if (isNaN(ancho) || ancho <= 0) errores.push("El ancho debe ser un número mayor a 0.");
            if (isNaN(largo) || largo <= 0) errores.push("El largo debe ser un número mayor a 0.");
            break;

        case '2': // PROTECTOR DE VOLTAJE
            const voltajeEntrada = $('[name="voltaje_entrada"]').val().trim();
            const voltajeSalida = $('[name="voltaje_salida"]').val().trim();
            const tomas = parseInt($('[name="tomas"]').val());
            const capacidad = parseFloat($('[name="capacidad"]').val());

            if (!/^\d+(V|v)$/.test(voltajeEntrada)) errores.push("Voltaje de entrada inválido (ej. 120V).");
            if (!/^\d+(V|v)$/.test(voltajeSalida)) errores.push("Voltaje de salida inválido (ej. 110V).");
            if (isNaN(tomas) || tomas <= 0) errores.push("La cantidad de tomas debe ser un número mayor a 0.");
            if (isNaN(capacidad) || capacidad <= 0) errores.push("La capacidad debe ser un número mayor a 0.");
            break;

        case '3': // TINTA
            const numeroTinta = parseInt($('[name="numero"]').val());
            const colorTinta = $('[name="color"]').val().trim();
            const tipoTinta = $('[name="tipo"]').val().trim();
            const volumen = parseInt($('[name="volumen"]').val());

            if (isNaN(numeroTinta) || numeroTinta < 0) errores.push("El número de tinta debe ser un número válido.");
            if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/.test(colorTinta)) errores.push("El color debe contener solo letras.");
            if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/.test(tipoTinta)) errores.push("El tipo de tinta debe contener solo letras.");
            if (isNaN(volumen) || volumen <= 0) errores.push("El volumen debe ser mayor a 0.");
            break;

        case '4': // CARTUCHO DE TINTA
            const numeroCartucho = parseInt($('[name="numero"]').val());
            const colorCartucho = $('[name="color"]').val().trim();
            const capacidadCartucho = parseInt($('[name="capacidad"]').val());

            if (isNaN(numeroCartucho) || numeroCartucho < 0) errores.push("El número de cartucho debe ser válido.");
            if (!/^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/.test(colorCartucho)) errores.push("El color del cartucho debe contener solo letras.");
            if (isNaN(capacidadCartucho) || capacidadCartucho <= 0) errores.push("La capacidad del cartucho debe ser mayor a 0.");
            break;

        case '5': // OTROS
            const descripcionOtros = $('[name="descripcion_otros"]').val().trim();
            if (descripcionOtros.length < 3) errores.push("La descripción adicional debe tener al menos 3 caracteres.");
            break;
    }

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