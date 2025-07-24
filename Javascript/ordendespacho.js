$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/,e);
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value);
    });
    
    $("#correlativo").on("keyup",function(){
        validarKeyUp(/^[0-9]{4,10}$/,$(this),
        $("#scorrelativo"),"Se permite de 4 a 10 dígitos");
        if ($("#correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviarAjax(datos);
		}
    });

    function validarEnvioOrden(){
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value).trim();
        
        if(validarKeyUp(
            /^[0-9]{4,10}$/,
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
        const nuevaFila = [
            `<span class="campo-numeros">${orden.correlativo}</span>`,
            `<span class="campo-nombres">${orden.fecha_despacho}</span>`,
            `<span class="campo-numeros">${orden.activo}</span>`,
            `<ul>
                <div>
                    <button class="btn-modificar"
                        data-id="${orden.id_orden_despachos}"
                        data-correlativo="${orden.correlativo}"
                        data-fecha="${orden.fecha_despacho}"
                        data-factura="${orden.id_factura}">
                        Modificar
                    </button>
                </div>
                <div>
                    <button class="btn-eliminar"
                        data-id="${orden.id_orden_despachos}">
                        Eliminar
                    </button>
                </div>
            </ul>`
        ];
        const tabla = $('#tablaConsultas').DataTable();
        const rowIdx = tabla.row.add(nuevaFila).draw(false).index();
        $(tabla.row(rowIdx).node()).attr('data-id', orden.id_orden_despachos);
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
        $('#ingresarOrdenDespacho')[0].reset();
        $('#scorrelativo').text('');
        $('#sfecha').text('');
        $('#sfactura').text('');
        $('#registrarOrdenModal').modal('show');
    });

    $('#ingresarOrdenDespacho').on('submit', function(e) {
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

    $("#modificar_correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9-\b]*$/,e);
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value);
    });
    
    $("#modificar_correlativo").on("keyup",function(){
        validarKeyUp(/^[0-9-\b]{4,10}$/,$(this),
        $("#smcorrelativo"),"Se permite de 4 a 10 dígitos");
        if ($("#modificar_correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviarAjax(datos);
		}
    });

    function llenarSelectFacturasModal(idSeleccionada) {
        let select = $('#modificar_factura');
        select.empty();
        select.append('<option value="">Seleccione una factura</option>');
        window.facturasDisponibles.forEach(function(orden) {
            let selected = orden.id_factura == idSeleccionada ? 'selected' : '';
            select.append(`<option value="${orden.id_factura}" ${selected}>${orden.factura}</option>`);
        });
    }

    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_orden').val($(this).data('id'));
        $('#modificar_correlativo').val($(this).data('correlativo'));
        $('#modificar_fecha').val($(this).data('fecha'));
        llenarSelectFacturasModal($(this).data('factura'));
        $('#smcorrelativo').text('');
        $('#smfecha').text('');
        $('#smfactura').text('');
        $('#modificarOrdenModal').modal('show');
    });

    $('#modificarOrden').on('submit', function(e) {
        e.preventDefault();

        let correlativo = $("#modificar_correlativo").val().trim();
        let fecha = $("#modificar_fecha").val().trim();
        let idFactura = $("#modificar_factura").val();
        let factura = $("#modificar_factura option:selected").text();

        if(!/^[0-9]{4,10}$/.test(correlativo)){
            Swal.fire('Error', 'Verifique el correlativo','Debe tener solo números');
            return;
        }

        var datos = new FormData(this);
        datos.append('accion', 'modificar');
        enviarAjax(datos, function(respuesta){
            if(respuesta.status === "success" || respuesta.resultado === "success"){
                $('#modificarOrdenModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La orden de despacho se ha modificado correctamente'
                    });
                    // Actualizar la fila en la tabla con el mismo formato
                let orden = respuesta.orden; // El backend debe retornar el modelo actualizado
                let fila = $(`tr[data-id="${orden.id_orden_despachos}"]`);
                const nuevaFila = [
                    `<span class="campo-numeros">${orden.correlativo}</span>`,
                    `<span class="campo-nombres">${orden.fecha_despacho}</span>`,
                    `<span class="campo-numeros">${orden.activo}</span>`,
                    `<ul>
                        <div>
                            <button class="btn-modificar"
                                data-id="${orden.id_orden_despachos}"
                                data-correlativo="${orden.correlativo}"
                                data-fecha="${orden.fecha_despacho}"
                                data-factura="${orden.id_factura}">
                                Modificar
                            </button>
                        </div>
                        <div>
                            <button class="btn-eliminar"
                                data-id="${orden.id_orden_despachos}">
                                Eliminar
                            </button>
                        </div>
                    </ul>`
                ];
                const tabla = $('#tablaConsultas').DataTable();
                const page = tabla.page();
                fila = tabla.row(`tr[data-id="${orden.id_orden_despachos}"]`);
                if (fila.length) {
                    fila.data(nuevaFila).draw(false);
                    tabla.page(page).draw(false);

                    const filaNode = fila.node();
                    const botonModificar = $(filaNode).find(".btn-modificar");
                    botonModificar.data("correlativo", orden.correlativo);
                    botonModificar.data("fecha", orden.fecha_despacho);
                    botonModificar.data("factura", orden.id_factura);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.message || 'No se pudo modificar la orden de despacho'
                });
            }
        });
    });

    $(document).on('click', '.btn-eliminar', function (e) {
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
                mostrarDatosFormData(datos);
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'La orden de despacho ha sido Anulada correctamente.',
                            'success'
                        ).then(function() {
                            eliminarFilaOrden(id);
                        });
                    } else {
                        muestraMensaje(respuesta.message);
                    }
                });
            }
        });
    }

    function eliminarFilaOrden(id) {
        const tabla = $('#tablaConsultas').DataTable();
        tabla.row($(`tr[data-id="${id}"]`)).remove().draw(false);
    }

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

    function validarKeyUp(er, etiqueta, etiquetamensaje, mensaje) {
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

    function mostrarDatosFormData(formData) {
        console.log('Datos enviados en FormData:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
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