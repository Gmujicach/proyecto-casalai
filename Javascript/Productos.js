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