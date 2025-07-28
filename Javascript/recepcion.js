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

    $("#proveedor").on("change blur", function() {
        validarkeyup(
            /^.+$/,
            $(this),
            $("#sproveedor"),
            "Debe seleccionar una proveedor"
        );
    });

    $("#codigoproducto").on("keyup",function(){
        var codigo = $(this).val();
        $("#listadop tr").each(function(){
            if(codigo == $(this).find("td:eq(1)").text()){
                colocaproducto($(this));
            }
        });
    });

    function validarEnvioRecepcion() {
        let correlativo = document.getElementById("correlativo");
        correlativo.value = space(correlativo.value).trim();

        if (validarkeyup(
            /^[0-9]{4,10}$/,
            $("#correlativo"),
            $("#scorrelativo"),
            "*El correlativo debe tener de 4 a 10 dígitos*"
        ) == 0) {
            mensajes('error', 'Verifique el correlativo', 'Le faltan dígitos al correlativo');
            return false;
        }

        if ($("#proveedor").val() === null || $("#proveedor").val() === "") {
            $("#sproveedor").text("*Debe seleccionar un proveedor*");
            mensajes('error', 'Verifique el proveedor', 'El campo está vacío');
            return false;
        } else {
            $("#sproveedor").text("");
        }

        // Validación de productos agregados
        if ($("#recepcion1 tr").length === 0) {
            mensajes('error', 'Verifique los productos', 'Debe agregar al menos un producto a la recepción');
            return false;
        }

        return true;
    }

    function carga_productos(){
        var datos = new FormData();
        datos.append('accion','listado');
        enviaAjax(datos);
    }

    function borrar(){
        $("#correlativo").val('');
        $("#proveedor").val("disabled");
        $("#recepcion1 tr").remove();
        $("#descripcion").val('');
    }

    function agregarFilaRecepcion(recepcion) {
        const nuevaFila = [
            `<span class="campo-numeros">${recepcion.fecha}</span>`,
            `<span class="campo-numeros">${recepcion.correlativo}</span>`,
            `<span class="campo-nombres">${recepcion.nombre_proveedor}</span>`,
            `<span class="campo-nombres">${recepcion.nombre_producto}</span>`,
            `<span class="campo-numeros">${recepcion.cantidad}</span>`,
            `<span class="campo-numeros">${recepcion.costo}</span>`,
            `<ul>
                <button class="btn-modificar"
                    data-idrecepcion="${recepcion.id_recepcion}"
                    data-correlativo="${recepcion.correlativo}"
                    data-fecha="${recepcion.fecha}"
                    data-proveedor="${recepcion.id_proveedor}"
                    data-productos='${JSON.stringify(recepcion.productos)}'>
                    Modificar
                </button>
            </ul>`
        ];
        const tabla = $('#tablaConsultas').DataTable();
        const rowIdx = tabla.row.add(nuevaFila).draw(false).index();
        $(tabla.row(rowIdx).node()).attr('data-id', recepcion.id_recepcion);
        tabla.page('last').draw('page');
    }

    function resetRecepcion() {
        $('#correlativo').val('');
        $('#proveedor').val('');
        $('#scorrelativo').text('');
        $('#sproveedor').text('');
        $("#recepcion1 tr").remove();
    }

    $('#btnIncluirRecepcion').on('click', function() {
        $('#ingresarRecepcion')[0].reset();
        $('#scorrelativo').text('');
        $('#sproveedor').text('');
        $('#registrarRecepcionModal').modal('show');
    });
/*
    $("#registrar").on("click",function(){
        if (validarenvio()){
            if(verificaproductos()){
            $('#accion').val('registrar');
    
                var datos = new FormData($('#ingresarRecepcion')[0]);
                
                $('#proveedor').change(function() {
                    var valor = $(this).val();
                    datos.append('proveedor', valor); });
                datos.append("descripcion", $("#descripcion").val());
    
                enviaAjax(datos);
                } else{
                muestraMensaje("info",4000,"Debe colocar algun producto");
            }
        } 
    });*/

    $('#ingresarRecepcion').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioRecepcion()){
            var datos = new FormData(this);
            datos.append("accion", "registrar");
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || 'Recepción registrada correctamente'
                    });
                    agregarFilaRecepcion(respuesta.orden);
                    resetRecepcion();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || 'No se pudo registrar la recepción'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarRecepcionModal .close', function() {
        $('#registrarRecepcionModal').modal('hide');
    });

    $(document).on("click", "#modalp .close-2", function () {
        $("#modalp").modal("hide");
    });

    // Carga inicial de productos
    carga_productos();

    // Evento click para mostrar el modal de productos
    $("#listado").on("click", function () {
        $("#modalp").modal("show");
    });

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

    /*function enviarAjax(datos, callback) {
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
    }*/

    function enviaAjax(datos){
        $.ajax({
            async: true,
            url: '',
            type: 'POST',
            contentType: false,
            data: datos,
            processData: false,
            cache: false,
            beforeSend: function(){
                //pasa antes de enviar pueden colocar un loader
            },
            timeout:10000, //tiempo maximo de espera por la respuesta del servidor
                success: function(respuesta) {//si resulto exitosa la transmision
                    console.log(respuesta); 
                    try{
                        var lee = JSON.parse(respuesta);	
                        console.log(lee.resultado);
                        
                        if(lee.resultado=='listado'){
                            
                            $('#listadop').html(lee.mensaje);
                        }
                        else if(lee.resultado=='registrar'){
                            muestraMensaje('success', 6000, 'REGISTRAR', lee.mensaje);
                            borrar();
                        }else if (lee.resultado == "encontro") {		
                            if (lee.mensaje == 'El numero de correlativo ya existe!') {
                                muestraMensaje('success', 6000,'Atencion', lee.mensaje);
                            }		
                        }else if(lee.resultado=='error'){
                            muestraMensaje('success', 6000,'Error',lee.mensaje);
                        }
                    }
                catch(e){
                    console.log("Error en JSON"+e.name+" !!!");
                }
            },
            complete: function(){
            }
        });
    }

    /*
    $(document).on('submit', '#formularioEdicion', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('accion', 'modificarRecepcion');

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                console.log("Respuesta del servidor (raw):", response);

                try {
                    // Intentar parsear respuesta JSON si es string
                    response = typeof response === "object" ? response : JSON.parse(response);
                } catch (err) {
                    console.error("Error al parsear JSON:", err, "Respuesta recibida:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Respuesta',
                        text: 'La respuesta del servidor no es válida. Revisa la consola para más detalles.'
                    });
                    return;
                }

                if (response.status === 'success') {
                    $('#modalModificar').modal('hide');
                    setTimeout(function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Modificado',
                            text: response.message || 'Recepción modificada correctamente.'
                        }).then(() => {
                            location.reload();
                        });
                    }, 500);
                } else {
                    console.warn("Error desde el backend:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la modificación',
                        text: response.message || 'Ocurrió un error al modificar. Revisa la consola.'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX:");
                console.error("Estado:", status);
                console.error("Código HTTP:", xhr.status);
                console.error("Mensaje:", error);
                console.error("Respuesta del servidor:", xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error de red o servidor',
                    html: `
                        <b>Código HTTP:</b> ${xhr.status}<br>
                        <b>Estado:</b> ${status}<br>
                        <b>Mensaje:</b> ${error}
                    `
                });
            }
        });
    });

    $(document).on('click', '#modalp .close-2', function() {
        $('#modalp').modal('hide');
    });
    */
});

//funcion para colocar los productos
function colocaproducto(linea){
    var id = $(linea).find("td:eq(0)").text();
    var encontro = false;
    
    $("#recepcion1 tr").each(function(){
        if(id*1 == $(this).find("td:eq(1)").text()*1){
            encontro = true
            var t = $(this).find("td:eq(4)").children();
            t.val(t.val()*1+1);
            modificasubtotal(t);
        } 
    });
    
    if(!encontro){
        var l = `
            <tr>
                <td>
                    <button type="button" class="btn-eliminar-pr" onclick="borrarp(this)">Eliminar</button>
                </td>
            <td style="display:none">
                <input type="text" name="producto[]" style="display:none"
                value="`+
                        $(linea).find("td:eq(0)").text()+
                `"/>`+	
                        $(linea).find("td:eq(0)").text()+
            `</td>
            <td>`+
                        $(linea).find("td:eq(1)").text()+
            `</td>
            <td>`+
                        $(linea).find("td:eq(2)").text()+
            `</td>
            <td>`+
                        $(linea).find("td:eq(3)").text()+
            `</td>
                <td>`+
                        $(linea).find("td:eq(4)").text()+
            `</td>
            <td>`+
                        $(linea).find("td:eq(5)").text()+
            `</td>
                <td>
                    <input type="number" class="numerico" name="costo[]" min="0.01" step="0.01" value="1" required>
                </td>
                <td>
                    <input type="number" class="numerico" name="cantidad[]" min="1" step="1" value="1" required>
                </td>
            </tr>`;
        $("#recepcion1").append(l);
    }
}

//funcion para eliminar linea de detalle de ventas
function borrarp(boton){
    $(boton).closest('tr').remove();
}
/*
carga_productos();    //boton para levantar modal de productos
    $("#listado").on("click",function(){
        $("#modalp").modal("show");
    });
    
    
    $("#correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9-\b]*$/,e);
    });
    
    $("#correlativo").on("keyup",function(){
        validarkeyup(/^[0-9]{4,10}$/,$(this),
        $("#scorrelativo"),"Se permite de 4 a 10 carácteres");
        if ($("#correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviaAjax(datos);
		}
    });

    $("#descripcion").on("keypress", function (e) {
        validarkeypress(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]*$/, e);
      });
    
      $("#descripcion").on("keyup", function () {
        validarkeyup(
          /^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{1,200}$/,
          $(this),
          $("#sdescripcion"),
          "No debe estar vacío y se permite un máximo 200 carácteres"
        );
      });
    
    //evento click de boton registrar
    $("#registrar").on("click",function(){
         if (validarenvio()){
            if(verificaproductos()){
            $('#accion').val('registrar');
    
                var datos = new FormData($('#ingresarRecepcion')[0]);
                
                $('#proveedor').change(function() {
                    var valor = $(this).val();
                    datos.append('proveedor', valor); });
                datos.append("descripcion", $("#descripcion").val());
    
                enviaAjax(datos);
                } else{
                muestraMensaje("info",4000,"Debe colocar algun producto");
            }
          } 
           
            
        
    });
        
        function verificarPermisosEnTiempoRealRecepcion() {
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
            $('#btnIncluirRecepcion').show();
        } else {
            $('#btnIncluirRecepcion').hide();
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
    verificarPermisosEnTiempoRealRecepcion();
    setInterval(verificarPermisosEnTiempoRealRecepcion, 10000); // 10 segundos
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
    function validarenvio(){
        
        var proveedorseleccionado = $("#proveedor").val();
        if (proveedorseleccionado === null || proveedorseleccionado === "0") {
            muestraMensaje("info",4000,"Por favor, seleccione un proveedor!"); 
            return false;
        }
        else if(validarkeyup(/^[0-9]{4,10}$/,$("#correlativo"),
            $("#scorrelativo"),"Se permite de 4 a 10 carácteres")==0){
            muestraMensaje("info",4000,"el correlativo debe coincidir con el formato");
                           
            return false;					
        } else if (
            validarkeyup(
                /^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{1,200}$/,
                $("#descripcion"),
                $("#sdescripcion"),
                "No debe contener más de 200 carácteres"
            ) == 0
        ) {
            muestraMensaje(
                "error",
                4000,
                "ERROR!",
               
                    "No debe estar vacío, ni contener más de 200 carácteres"
            );
            return false;
        }
        return true;
    }
    



function muestraMensaje(tipo, tiempo, titulo, mensaje) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        timer: tiempo || 3000
    });
}
    
    //Funcion que muestra el modal con un mensaje
    
    
    
    
    
    //Función para validar por Keypress
    function validarkeypress(er,e){
        
        key = e.keyCode;
        
        
        tecla = String.fromCharCode(key);
        
        
        a = er.test(tecla);
        
        if(!a){
        
            e.preventDefault();
        }
        
        
    }
    //Función para validar por keyup
    function validarkeyup(er,etiqueta,etiquetamensaje,
    mensaje){
        a = er.test(etiqueta.val());
       
        if(a){
            etiquetamensaje.text("");
            return 1;
        }
        else{
            etiquetamensaje.text(mensaje);
            return 0;
        }
    }
*/