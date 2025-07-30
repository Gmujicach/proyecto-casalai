$(document).ready(function () {
$(document).on('submit', '#formularioEdicion', function (e) {
    e.preventDefault();
    e.stopPropagation();

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
    // Cierra el modal con jQuery (Bootstrap 4)
    $('#modalModificar').modal('hide');

    // Quitar manualmente backdrop en caso de quedar atascado
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css({ 'padding-right': '', 'overflow': '' });

    setTimeout(function () {
        Swal.fire({
            icon: 'success',
            title: 'Modificado',
            text: response.message || 'Recepción modificada correctamente.'
        }).then(() => {
            console.log("Recargando tabla de consultas...");
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

    $('#btnIncluirRecepcion').on('click', function() {
        $('#f')[0].reset();
        $('#scorrelativo').text('');
        $('#registrarRecepcionModal').modal('show');
    });

    $(document).on('click', '#registrarRecepcionModal .close', function() {
        $('#registrarRecepcionModal').modal('hide');
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
                    <input type="number" class="numerico" name="costo[]" min="0.01" step="0.01" value="1" required>
                </td>
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
    e.stopPropagation();
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
    
    
    
    
function enviaAjax(datos) {
    fetch('', {
        method: 'POST',
        body: datos
    })
    .then(res => res.text())
    .then(respuesta => {
        try {
            let lee = JSON.parse(respuesta);
            console.log(lee);

            if (lee.resultado == 'listado') {
                document.querySelector('#listadop').innerHTML = lee.mensaje;

            } else if (lee.resultado === 'registrar') {
                muestraMensaje('success', 6000, 'REGISTRAR', lee.mensaje);
                borrar();
                cerrarModales(); // 🔹 Cerramos modales y backdrop
                if (lee.data) insertarFilaTabla(lee.data);

            } else if (lee.resultado === 'modificarRecepcion') {
                muestraMensaje('success', 6000, 'MODIFICAR', lee.mensaje);
                cerrarModales(); // 🔹 Cerramos modales y backdrop
                if (lee.data) actualizarFilaTabla(lee.data);

            } else if (lee.resultado === 'encontro') {
                muestraMensaje('warning', 6000, 'Atención', lee.mensaje);

            } else if (lee.resultado === 'error') {
                muestraMensaje('error', 6000, 'Error', lee.mensaje);
            }

        } catch (e) {
            console.error("Error en JSON: " + e.message);
        }
    })
    .catch(err => console.error("Error AJAX:", err));
}


// Función mejorada para cerrar modales y eliminar pantallas negras
function cerrarModales() {
    // Cerrar todos los modales visibles
    document.querySelectorAll('.modal.show').forEach(modal => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) {
            bsModal.hide();
        } else {
            // Fallback si no hay instancia
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
    });

    // Eliminar backdrops después de un breve retraso
    setTimeout(() => {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
        
        // Restaurar estado del body
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
        document.body.style.overflow = '';
    }, 150);
}

// Inicialización de modales
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos los modales
    document.querySelectorAll('.modal').forEach(modal => {
        new bootstrap.Modal(modal);
    });

    // Manejar cierre manual
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
        btn.addEventListener('click', cerrarModales);
    });
});

function actualizarFilaTabla(data) {
    // Buscar el botón que abre el modal de esta recepción
    let btn = document.querySelector(`.btn-modificar[data-idrecepcion="${data.id_recepcion}"]`);
    if (!btn) return;

    // Buscar la fila principal
    let filaPrincipal = btn.closest("tr");

    // Obtener tbody
    let tbody = filaPrincipal.closest("tbody");

    // Borrar todas las filas relacionadas a esa recepción
    let filasRelacionadas = tbody.querySelectorAll(`.btn-modificar[data-idrecepcion="${data.id_recepcion}"]`);
    filasRelacionadas.forEach(b => {
        let tr = b.closest("tr");
        tbody.removeChild(tr);
    });

    // Insertar nuevamente con datos nuevos
    insertarFilaTabla(data);
}


function insertarFilaTabla(data) {
    let tabla = document.querySelector("#tablaConsultas tbody");

    data.productos.forEach((prod, index) => {
        let tr = document.createElement("tr");

        // Solo la primera fila lleva fecha, correlativo y proveedor
        if (index === 0) {
            tr.innerHTML = `
                <td rowspan="${data.productos.length}">${data.fecha}</td>
                <td rowspan="${data.productos.length}">${data.correlativo}</td>
                <td rowspan="${data.productos.length}">${data.proveedor}</td>
                <td>${data.nombre_producto}</td>
                <td>${prod.cantidad}</td>
                <td>${prod.costo}</td>
                <td rowspan="${data.productos.length}">
                    <button class="btn-modificar"
                        data-bs-toggle="modal"
                        data-bs-target="#modalModificar"
                        data-idrecepcion="${data.id_recepcion}"
                        data-correlativo="${data.correlativo}"
                        data-fecha="${data.fecha}"
                        data-proveedor="${data.proveedor}"
                        data-productos='${JSON.stringify(data.productos)}'>
                        Modificar
                    </button>
                </td>
            `;
        } else {
            tr.innerHTML = `
                <td>${prod.nombre_producto}</td>
                <td>${prod.cantidad}</td>
                <td>${prod.costo}</td>
            `;
        }

        tabla.appendChild(tr);
    });
}

   
   