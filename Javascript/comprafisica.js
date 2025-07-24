$(document).ready(function () {
$(document).on('submit', '#formularioEdicion', function(e) {
    e.preventDefault(); // ← Esto es crucial

    var formData = new FormData(this);
    formData.append('accion', 'modificarRecepcion');

    $.ajax({
        url: '', // misma página
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            try {
                response = typeof response === "object" ? response : JSON.parse(response);
            } catch (e) {
                Swal.fire('Error', 'Respuesta inesperada del servidor', 'error');
                return;
            }

            if (response.status === 'success') {
                $('#modalModificar').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            if (response.tbody) {
                $('#tablaConsultas tbody').html(response.tbody);
            }
            Swal.fire({
                icon: 'success',
                title: 'Modificado',
                text: response.message
            });
} else {
    Swal.fire('Error', response.message, 'error');
}
        },
        error: function() {
            Swal.fire('Error', 'Error al modificar la recepción.', 'error');
        }
    });
});

    $('#btnIncluirDespacho').on('click', function() {
        $('#f')[0].reset();
        $('#scorrelativo').text('');
        $('#registrarDespachoModal').modal('show');
    });

    $(document).on('click', '#registrarDespachoModal .close', function() {
        $('#registrarDespachoModal').modal('hide');
    });

    $(document).on('click', '#modalp .close-2', function() {
        $('#modalp').modal('hide');
    });
});

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
    
    //evento keyup de input codigoproducto
    $("#codigoproducto").on("keyup",function(){
        var codigo = $(this).val();
        $("#listadop tr").each(function(){
            if(codigo == $(this).find("td:eq(1)").text()){
                colocaproducto($(this));
            }
        });
    });	
    
    //evento click de boton registrar
    $("#registrar").on("click",function(){
        if (validarenvio()){
            if(verificaproductos()){
            $('#accion').val('registrar');
    
                var datos = new FormData($('#f')[0]);
                
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
            $('#btnIncluirDespacho').show();
        } else {
            $('#btnIncluirDespacho').hide();
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
    
    function carga_productos(){
        
        
        var datos = new FormData();
        
        datos.append('accion','listado'); //le digo que me muestre un listado de aulas
        
        enviaAjax(datos);
    }
    
    //function para saber si selecciono algun productos
    function verificaproductos(){
        var existe = false;
    
        if($("#recepcion1 tr").length > 0){
            existe = true;
            
        }
    
        return existe;
    }
    function borrar(){
        $("#correlativo").val('');
        $("#proveedor").val("disabled");
        $("#recepcion1 tr").remove();
        $("#descripcion").val('');
        
        }

    
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
                    <input type="number" class="numerico" name="cantidad[]" min="1" step="1" value="1" required>
                </td>
               </tr>`;
            $("#recepcion1").append(l);
        }
    }
    
 
    //fin de funcion modifica subtotal
 

    
    //funcion para eliminar linea de detalle de ventas
    function borrarp(boton){
        $(boton).closest('tr').remove();
    }


function muestraMensaje(tipo = 'success', tiempo = 4000, titulo = '', mensaje = '') {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        timer: tiempo,
        showConfirmButton: false
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

   $(document).ready(function() {
    $('.select2-cliente').select2({
        placeholder: "Buscar cliente por nombre o cédula",
        allowClear: true,
        language: {
            noResults: function() {
                return "No se encontraron clientes";
            }
        },
        matcher: function(params, data) {
            // Buscar tanto en nombre como en cédula
            if ($.trim(params.term) === '') {
                return data;
            }
            
            if (typeof data.text === 'undefined') {
                return null;
            }
            
            // Buscar en el texto visible (nombre - cédula)
            if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
                return data;
            }
            
            // Buscar específicamente en la cédula (atributo data)
            if ($(data.element).data('cedula') && 
                $(data.element).data('cedula').toString().indexOf(params.term) > -1) {
                return data;
            }
            
            return null;
        }
    });
});
    
    
    
    
    function enviaAjax(datos){
        
        $.ajax({
            async: true,
                url: '', //la pagina a donde se envia por estar en mvc, se omite la ruta ya que siempre estaremos en la misma pagina
                type: 'POST',//tipo de envio 
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
    // Ajusta el tamaño del modal según la sugerencia del backend
    $('#modalp .modal-dialog').removeClass('modal-md modal-lg modal-xl').addClass(lee.modalSize);
}
                    else if(lee.resultado=='registrar'){
    muestraMensaje('success', 6000,'REGISTRAR', lee.mensaje);
    if (lee.tbody) {
        $('#tablaConsultas tbody').html(lee.tbody);
    }
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
   