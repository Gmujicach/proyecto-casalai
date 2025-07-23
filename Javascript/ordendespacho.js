$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9-\b]*$/,e);
    });
    
    $("#correlativo").on("keyup",function(){
        validarkeyup(/^[0-9-\b]{4,10}$/,$(this),
        $("#scorrelativo"),"Se permite de 4 a 10 carácteres");
        if ($("#correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviaAjax(datos);
		}
    });

    function validarEnvioOrden(){
        if(validarKeyUp(
            /^[0-9-\b]{4,10}$/,
            $("#correlativo"),
            $("#scorrelativo"),
            "*El correlativo debe tener solo números*"
        )==0){
            mensajes('error',4000,'Verifique el correlativo','Debe tener solo números');
            return false;
        }
        return true;
    }

    function agregarFilaOrden(orden) {
        const nuevaFila = `
            <tr data-id="${orden.id_orden_despachos}">
                <td><span class="campo-numeros">${orden.correlativo}</span></td>
                <td><span class="campo-nombres">${orden.fecha_despacho}</span></td>
                <td><span class="campo-factura">${orden.activo}</span></td>
                <td>
                    <ul>
                        <div>
                            <button class="btn-modificar"
                                id="btnModificarOrden"
                                data-id="${orden.id_orden_despachos}"
                                data-fecha="${orden.fecha_despacho}"
                                data-correlativo="${orden.correlativo}"
                                data-factura="${orden.id_factura}">
                                Modificar
                            </button>
                        </div>
                        <div>
                            <button class="btn-eliminar"
                                data-id="${cuenta.id_orden_despachos}">
                                Eliminar
                            </button>
                        </div>
                    </ul>
                </td>
            </tr>
        `;
        const tabla = $('#tablaConsultas').DataTable();
        tabla.row.add($(nuevaFila)).draw(false);
        tabla.page('last').draw('page');
    }

    function resetOrden() {
        $('#correlativo').val('');
        $('#fecha').val('');
        $('#factura').val('');
        $('#scorrelativo').text('');
        $('#sfecha').text('');
        $('#sfactura').text('');
    }

    $('#btnIncluirOrden').on('click', function() {
        $('#ingresarOrdenDepacho')[0].reset();
        $('#scorrelativo').text('');
        $('#sfecha').text('');
        $('#sfactura').text('');
        $('#registrarOrdenModal').modal('show');
    });

    $('#ingresarOrdenDepacho').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioOrden()){
            var datos = new FormData(this);
            datos.append("accion", "ingresar");
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || 'Orden de despacho registrada correctamente'
                    });
                    agregarFilaOrden(respuesta.orden);
                    resetOrden();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || 'No se pudo registrar la orden de despacho'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarOrdenModal .close', function() {
        $('#registrarOrdenModal').modal('hide');
    });
/*
    $(document).on('click', '.modificar', function (e) {
        e.preventDefault(); // Evita que el enlace haga scroll o recargue
    
        var boton = $(this);
    
        // Llenar los campos del modal con los datos del botón
        $('#modificar_id_orden').val(boton.data('id'));
        $('#modificar_fecha').val(boton.data('fecha'));
        $('#modificar_correlativo').val(boton.data('correlativo'));
        $('#modificar_factura').val(boton.data('factura'));
    
        // Mostrar el modal
        $('#modificar_orden_modal').modal('show');
    });
    

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
        const id = $(this).data('id');
        eliminarOrdenDespacho(id);
    });
    
    function eliminarOrdenDespacho(id) {
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
                console.log("ID del despacho a eliminar: ", id); 
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id', id);
                
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'La orden de despacho ha sido eliminada.',
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

    


   
    $('#incluirordendepacho').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Orden de Despacho ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al registrar la orden de despacho',
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
*/
/*
    function enviarAjax(datos, callback) {
        let esFormData = (typeof datos === "object" && typeof datos.append === "function");
        $.ajax({
            url: '',
            type: 'POST',
            data: datos,
            processData: !esFormData ? true : false,
            contentType: !esFormData ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
            dataType: 'json',
            success: function (respuesta) {
                if(callback) callback(respuesta);
            },
            error: function () {
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            }
        });
    }
*/
    function mensajes(icono, tiempo, titulo, mensaje){
        Swal.fire({
            icon: icono,
            timer: tiempo,
            title: titulo,
            text: mensaje,
            showConfirmButton: true,
            confirmButtonText: 'Aceptar',
        });
    }

    function validarkeypress(er, e) {
        key = e.keyCode;
        tecla = String.fromCharCode(key);
        a = er.test(tecla);

        if (!a) {
            e.preventDefault();
        }
    }

    function validarkeyup(er, etiqueta, etiquetamensaje, mensaje) {
        a = er.test(etiqueta.val());

        if (a) {
            etiquetamensaje.text("");
            return 1;
        } else {
            etiquetamensaje.text(mensaje);
            return 0;
        }
    }

    function space(str) {
        const regex = /\s{2,}/g;
        var str = str.replace(regex, ' ');
        return str;
    }
    
    function muestraMensaje(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: mensaje
        });
    }

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
});