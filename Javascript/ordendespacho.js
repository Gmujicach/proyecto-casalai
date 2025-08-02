$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", "Atención", $("#mensajes").html());
    }

    $("#correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/,e);
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value);
    });
    
    $("#correlativo").on("keyup",function(){
        validarkeyup(
            /^[0-9]{4,10}$/,
            $(this),
            $("#scorrelativo"),
            "Se permite de 4 a 10 dígitos"
        );
    });

    let hoy = new Date();
    let yyyy = hoy.getFullYear();
    let mm = String(hoy.getMonth() + 1).padStart(2, '0');
    let dd = String(hoy.getDate()).padStart(2, '0');
    let fechaMax = `${yyyy}-${mm}-${dd}`;
    $("#fecha").attr("max", fechaMax);
    
    $("#fecha").on("change keyup", function() {
        let fechaInput = $(this).val();
        let hoy = new Date();
        let fechaIngresada = new Date(fechaInput);

        hoy.setHours(0,0,0,0);

        if (fechaInput === "") {
            $("#sfecha").text("Debe ingresar una fecha");
        } else if (fechaIngresada > hoy) {
            $("#sfecha").text("No se permite una fecha futura");
            $(this).addClass("input-error");
        } else {
            $("#sfecha").text("");
            $(this).removeClass("input-error");
        }
    });

    $("#factura").on("change blur", function() {
        validarkeyup(
            /^.+$/,
            $(this),
            $("#sfactura"),
            "Debe seleccionar una factura"
        );
    });

    function validarEnvioOrden(){
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value).trim();
        
        let fecha = $("#fecha").val();
        let hoy = new Date();
        let fechaIngresada = new Date(fecha);
        hoy.setHours(0,0,0,0);

        if(validarkeyup(
            /^[0-9]{4,10}$/,
            $("#correlativo"),
            $("#scorrelativo"),
            "*El correlativo debe tener de 4 a 10 dígitos*"
        )==0){
            mensajes('error', 'Verifique el correlativo', 'Le faltan dígitos al correlativo');
            return false;
        }
        else if(validarkeyup(
            /^.+$/,
            $("#fecha"),
            $("#sfecha"),
            "*Debe ingresar una fecha completa (día, mes y año)*"
        )==0){
            mensajes('error', 'Verifique la fecha', 'La fecha está vacía, incompleta o no es válida');
            return false;
        } else if (fechaIngresada > hoy) {
            $("#sfecha").text("*Solo se permite una fecha actual o una fecha anterior*");
            mensajes('error', 'Verifique la fecha', 'No se permiten fechas futuras');
            return false;
        } else {
            $("#sfecha").text("");
        }

        if($("#factura").val() === null || $("#factura").val() === "") {
            $("#sfactura").text("*Debe seleccionar una factura*");
            mensajes('error', 'Verifique la factura', 'El campo esta vacio');
            return false;
        } else {
            $("#sfactura").text("");
        }

        return true;
    }

    function agregarFilaOrden(orden) {
        const nuevaFila = [
            `<span class="campo-numeros">${orden.correlativo}</span>`,
            `<span class="campo-nombres">${orden.fecha_despacho}</span>`,
            `<span class="campo-numeros">${orden.id_factura}</span>`,
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
                        Anular
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
        validarkeyup(/^[0-9-\b]{4,10}$/,$(this),
        $("#smcorrelativo"),"Se permite de 4 a 10 dígitos");
        if ($("#modificar_correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviarAjax(datos);
		}
    });

    $("#modificar_correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/,e);
        let correlativo = document.getElementById("modificar_correlativo");
        correlativo.value = space(correlativo.value);
    });
    
    $("#modificar_correlativo").on("keyup",function(){
        validarkeyup(
            /^[0-9]{4,10}$/,
            $(this),
            $("#smcorrelativo"),
            "Se permite de 4 a 10 dígitos"
        );
    });

    $("#modificar_fecha").attr("max", fechaMax);
    
    $("#modificar_fecha").on("change keyup", function() {
        let fechaInput = $(this).val();
        let hoy = new Date();
        let fechaIngresada = new Date(fechaInput);

        hoy.setHours(0,0,0,0);

        if (fechaInput === "") {
            $("#smfecha").text("Debe ingresar una fecha");
        } else if (fechaIngresada > hoy) {
            $("#smfecha").text("No se permite una fecha futura");
            $(this).addClass("input-error");
        } else {
            $("#smfecha").text("");
            $(this).removeClass("input-error");
        }
    });

    $("#modificar_factura").on("change blur", function() {
        validarkeyup(
            /^.+$/,
            $(this),
            $("#smfactura"),
            "Debe seleccionar una factura"
        );
    });

    function validarOrden(datos) {
        let errores = [];
        let correlativo = document.getElementById("modificar_correlativo");
        correlativo.value = space(correlativo.value).trim();

        let fecha = $("#modificar_fecha").val();
        let hoy = new Date();
        let fechaIngresada = new Date(fecha);
        hoy.setHours(0,0,0,0);

        if (!/^[0-9]{4,10}$/.test(datos.correlativo)) {
            errores.push("El correlativo debe tener de 4 a 10 dígitos.");
        }
        if (datos.fecha === "") {
            errores.push("Debe ingresar una fecha completa (día, mes y año).");
        } else if (fechaIngresada > hoy) {
            errores.push("Solo se permite una fecha actual o una fecha anterior.");
        }
        if (datos.factura === null || datos.factura === "") {
            errores.push("Debe seleccionar una factura.");
        }
        return errores;
    }

    function llenarSelectFacturasModal(idSeleccionada) {
        let select = $('#modificar_factura');
        select.empty();
        select.append('<option value="">Seleccione una orden de compra</option>');
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

        const datos = {
            correlativo: $('#modificar_correlativo').val(),
            fecha: $('#modificar_fecha').val(),
            factura: $('#modificar_factura').val()
        };

        const errores = validarOrden(datos);

        if (errores.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Su modificación no es valida',
                html: errores.join('<br>')
            });
            return;
        }

        var formData = new FormData(this);
        formData.append('accion', 'modificar');

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#modificarOrdenModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La orden de despacho se ha modificado correctamente'
                    });

                    const tabla = $("#tablaConsultas").DataTable();
                    const id = $("#modificar_id_orden").val();
                    const fila = tabla.row(`tr[data-id="${id}"]`);
                    const orden = response.orden;
                
                    if (fila.length) {
                        fila.data([
                            `<span class="campo-numeros">${orden.correlativo}</span>`,
                            `<span class="campo-nombres">${orden.fecha_despacho}</span>`,
                            `<span class="campo-numeros">${orden.id_factura}</span>`,
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
                                        Anular
                                    </button>
                                </div>
                            </ul>`
                        ]).draw(false);

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
                        text: response.message || 'No se pudo modificar la orden de despacho'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la orden de despacho:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la orden de despacho.');
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

    function mensajes(icono, titulo, mensaje){
        Swal.fire({
            icon: icono,
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