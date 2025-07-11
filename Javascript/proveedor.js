$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s]*$/, e);
        let nombre_p = document.getElementById("nombre_proveedor");
        nombre_p.value = space(nombre_p.value);
    });
    $("#nombre_proveedor").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s]{2,50}$/,
        $(this),
        $("#snombre_proveedor"),
        "*Solo letras, de 2 a 50 caracteres*"
        );
    });

    $("#rif_proveedor").on("keypress", function(e){
        validarKeyPress(/^[vejpg0-9-\b]*$/i, e);
    });
    $("#rif_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
            $(this),
            $("#srif_proveedor"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#rif_proveedor").on("input", function() {
        let valor_rp = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado_rp = '';
        if (valor_rp.length > 0) {
            let letra_rp = valor_rp.charAt(0);
            if ('VEJPG'.includes(letra_rp)) {
                resultado_rp = letra_rp;
            } else {
                resultado_rp = '';
            }

            let numeros_rp = valor_rp.substring(1).replace(/\D/g, '');

            if (numeros_rp.length > 0) {
                resultado_rp += '-' + numeros_rp.substring(0, 8);
                if (numeros_rp.length > 8) {
                    resultado_rp += '-' + numeros_rp.substring(8, 9);
                }
            }
        }
        $(this).val(resultado_rp);
    });

    $("#nombre_representante").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
        let nombre_r = document.getElementById("nombre_representante");
        nombre_r.value = space(nombre_r.value);
    });
    $("#nombre_representante").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/,
        $(this),
        $("#snombre_representante"),
        "*Solo letras, de 2 a 50 caracteres*"
        );
    });

    $("#rif_representante").on("keypress", function(e){
        validarKeyPress(/^[VEJPG0-9-\b]*$/i, e);
    });
    $("#rif_representante").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
            $(this),
            $("#srif_representante"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#rif_representante").on("input", function() {
        let valor_rr = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado_rr = '';
        if (valor_rr.length > 0) {
            let letra_rr = valor_rr.charAt(0);
            if ('VEJPG'.includes(letra_rr)) {
                resultado_rr = letra_rr;
            } else {
                resultado_rr = '';
            }

            let numeros_rr = valor_rr.substring(1).replace(/\D/g, '');

            if (numeros_rr.length > 0) {
                resultado_rr += '-' + numeros_rr.substring(0, 8);
                if (numeros_rr.length > 8) {
                    resultado_rr += '-' + numeros_rr.substring(8, 9);
                }
            }
        }
        $(this).val(resultado_rr);
    });

    $("#correo_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });
    $("#correo_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_proveedor"),
            "*Formato válido: example@gmail.com*"
        );
    });

    $("#direccion_proveedor").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let direccion = document.getElementById("direccion_proveedor");
        direccion.value = space(direccion.value);
    });
    $("#direccion_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#sdireccion_proveedor"),
            "*El formato permite letras y números*"
        );
    });

    $("#telefono_1").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#telefono_1").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono_1"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });
    $("#telefono_1").on("input", function() {
        let valor_t1 = $(this).val().replace(/\D/g, '');
        if(valor_t1.length > 4 && valor_t1.length <= 7)
            valor_t1 = valor_t1.slice(0,4) + '-' + valor_t1.slice(4);
        else if(valor_t1.length > 7)
            valor_t1 = valor_t1.slice(0,4) + '-' + valor_t1.slice(4,7) + '-' + valor_t1.slice(7,11);
        $(this).val(valor_t1);
    });

    $("#telefono_2").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#telefono_2").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono_2"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });
    $("#telefono_2").on("input", function() {
        let valor_t2 = $(this).val().replace(/\D/g, '');
        if(valor_t2.length > 4 && valor_t2.length <= 7)
            valor_t2 = valor_t2.slice(0,4) + '-' + valor_t2.slice(4);
        else if(valor_t2.length > 7)
            valor_t2 = valor_t2.slice(0,4) + '-' + valor_t2.slice(4,7) + '-' + valor_t2.slice(7,11);
        $(this).val(valor_t2);
    });

    $("#observacion").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let observacion = document.getElementById("observacion");
        observacion.value = space(observacion.value);
    });
    $("#observacion").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#sobservacion"),
            "*El formato permite letras y números*"
        );
    });
function verificarPermisosEnTiempoRealProveedores() {
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
            $('#btnIncluirProveedor').show();
        } else {
            $('#btnIncluirProveedor').hide();
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
    verificarPermisosEnTiempoRealProveedores();
    setInterval(verificarPermisosEnTiempoRealProveedores, 10000); // 10 segundos
});
    function validarEnvioProveedor(){
        let nombre_p = document.getElementById("nombre_proveedor");
        nombre_p.value = space(nombre_p.value).trim();

        let nombre_r = document.getElementById("nombre_representante");
        nombre_r.value = space(nombre_r.value).trim();

        let direccion = document.getElementById("direccion_proveedor");
        direccion.value = space(direccion.value).trim();

        let observacion = document.getElementById("observacion");
        observacion.value = space(observacion.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{3,20}$/,
            $("#nombre_proveedor"),
            $("#snombre_proveedor"),
            "*El nombre debe tener letras y/o números*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del proveedor','Debe tener letras y/o números');
            return false;
        }

        else if(validarKeyUp(
            /^[VEJPG]-\d{8}-\d{1}$/,
            $("#rif_proveedor"),
            $("#srif_proveedor"),
            "*Formato correcto: J-12345678-9*"
        )==0){
            mensajes('error',4000,'Verifique el RIF','Formato incorrecto');
            return false;
        }

        else if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/,
            $("#nombre_representante"),
            $("#snombre_representante"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del representante','Debe tener solo letras');
            return false;
        }

        else if(validarKeyUp(
            /^[VEJPG]-\d{8}-\d{1}$/,
            $("#rif_representante"),
            $("#srif_representante"),
            "*Formato correcto: J-12345678-9*"
        )==0){
            mensajes('error',4000,'Verifique el RIF','Formato incorrecto');
            return false;
        }

        else if(validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $("#correo_proveedor"),
            $("#scorreo_proveedor"),
            "*Formato correcto: example@gmail.com*"
        )==0){
            mensajes('error',4000,'Verifique el correo','Correo no válido');
            return false;
        }

        else if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $("#direccion_proveedor"),
            $("#sdireccion_proveedor"),
            "*Puede haber letras y números*"
        )==0){
            mensajes('error',4000,'Verifique la dirección','Debe tener solo letras y números');
            return false;
        }

        else if(validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $("#telefono_1"),
            $("#stelefono_1"),
            "*Formato correcto: 04XX-XXX-XXXX*"
        )==0){
            mensajes('error',4000,'Verifique el teléfono','Debe tener 11 dígitos');
            return false;
        }

        else if(validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $("#telefono_2"),
            $("#stelefono_2"),
            "*Formato correcto: 04XX-XXX-XXXX*"
        )==0){
            mensajes('error',4000,'Verifique el teléfono','Debe tener 11 dígitos');
            return false;
        }
        else if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $("#observacion"),
            $("#sobservacion"),
            "*Puede haber letras y números*"
        )==0){
            mensajes('error',4000,'Verifique la observación','Debe tener solo letras y números');
            return false;
        }
        return true;
    }

    function agregarFilaProveedor(proveedor) {
        const tabla = $('#tablaConsultas').DataTable();
        const nuevaFila = [
            `<ul>
                <div>
                    <button class="btn-modificar"
                        id="btnModificarProveedor"
                        data-id="${proveedor.id_proveedor}"
                        data-nombre-proveedor="${proveedor.nombre_proveedor}"
                        data-rif-proveedor="${proveedor.rif_proveedor}"
                        data-nombre-representante="${proveedor.nombre_representante}"
                        data-rif-representante="${proveedor.rif_representante}"
                        data-correo-proveedor="${proveedor.correo_proveedor}"
                        data-direccion-proveedor="${proveedor.direccion_proveedor}"
                        data-telefono-1="${proveedor.telefono_1}"
                        data-telefono-2="${proveedor.telefono_2}"
                        data-observacion="${proveedor.observacion}">
                        Modificar
                    </button>
                </div>
                <div>
                    <button class="btn-eliminar"
                        data-id="${proveedor.id_proveedor}">
                        Eliminar
                    </button>
                </div>
            </ul>`,
            `<span class="campo-nombres">${proveedor.nombre_proveedor}</span>`,
            `<span class="campo-rif-correo">${proveedor.rif_proveedor}</span>`,
            `<span class="campo-nombres">${proveedor.nombre_representante}</span>`,
            `<span class="campo-rif-correo">${proveedor.rif_representante}</span>`,
            `<span class="campo-rif-correo">${proveedor.correo_proveedor}</span>`,
            `<span class="campo-nombres">${proveedor.direccion_proveedor}</span>`,
            `<span class="campo-numeros">${proveedor.telefono_1}</span>`,
            `<span class="campo-numeros">${proveedor.telefono_2}</span>`,
            `<span class="campo-nombres">${proveedor.observacion}</span>`,
            `<span class="campo-estatus ${proveedor.estado === "habilitado" ? "habilitado" : "inhabilitado"}"
                data-id="${proveedor.id_proveedor}" 
                style="cursor: pointer;">
                ${proveedor.estado}
            </span>`
        ];
        const rowNode = tabla.row.add(nuevaFila).draw(false).node();
        $(rowNode).attr('data-id', proveedor.id_proveedor);
    }

    function resetProveedor() {
        $("#nombre_proveedor").val('');
        $("#rif_proveedor").val('');
        $("#nombre_representante").val('');
        $("#rif_representante").val('');
        $("#correo_proveedor").val('');
        $("#direccion_proveedor").val('');
        $("#telefono_1").val('');
        $("#telefono_2").val('');
        $("#observacion").val('');
        $("#snombre_proveedor").text('');
        $("#srif_proveedor").text('');
        $("#snombre_representante").text('');
        $("#srif_representante").text('');
        $("#scorreo_proveedor").text('');
        $("#sdireccion_proveedor").text('');
        $("#stelefono_1").text('');
        $("#stelefono_2").text('');
        $("#sobservacion").text('');
    }

    $('#btnIncluirProveedor').on('click', function() {
        $('#incluirproveedor')[0].reset();
        $("#snombre_proveedor").text('');
        $("#srif_proveedor").text('');
        $("#snombre_representante").text('');
        $("#srif_representante").text('');
        $("#scorreo_proveedor").text('');
        $("#sdireccion_proveedor").text('');
        $("#stelefono_1").text('');
        $("#stelefono_2").text('');
        $("#sobservacion").text('');
        $('#registrarProveedorModal').modal('show');
    });

    $('#incluirproveedor').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioProveedor()){
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Proveedor registrado correctamente'
                    });
                    agregarFilaProveedor(respuesta.proveedor);
                    resetProveedor();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar el proveedor'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarProveedorModal .close', function() {
        $('#registrarProveedorModal').modal('hide');
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

    $("#modificar_nombre_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s]*$/, e);
        let nombre_p = document.getElementById("modificar_nombre_proveedor");
        nombre_p.value = space(nombre_p.value);
    });
    $("#modificar_nombre_proveedor").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s]{2,50}$/,
        $(this),
        $("#smnombre_proveedor"),
        "*Solo letras, de 2 a 50 caracteres*"
        );
    });

    $("#modificar_rif_proveedor").on("keypress", function(e){
        validarKeyPress(/^[vejpg0-9-\b]*$/i, e);
    });
    $("#modificar_rif_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
            $(this),
            $("#smrif_proveedor"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#modificar_rif_proveedor").on("input", function() {
        let valor_rp = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado_rp = '';
        if (valor_rp.length > 0) {
            let letra_rp = valor_rp.charAt(0);
            if ('VEJPG'.includes(letra_rp)) {
                resultado_rp = letra_rp;
            } else {
                resultado_rp = '';
            }

            let numeros_rp = valor_rp.substring(1).replace(/\D/g, '');

            if (numeros_rp.length > 0) {
                resultado_rp += '-' + numeros_rp.substring(0, 8);
                if (numeros_rp.length > 8) {
                    resultado_rp += '-' + numeros_rp.substring(8, 9);
                }
            }
        }
        $(this).val(resultado_rp);
    });

    $("#modificar_nombre_representante").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
        let nombre_r = document.getElementById("modificar_nombre_representante");
        nombre_r.value = space(nombre_r.value);
    });
    $("#modificar_nombre_representante").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/,
        $(this),
        $("#smnombre_representante"),
        "*Solo letras, de 2 a 50 caracteres*"
        );
    });

    $("#modificar_rif_representante").on("keypress", function(e){
        validarKeyPress(/^[VEJPG0-9-\b]*$/i, e);
    });
    $("#modificar_rif_representante").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
            $(this),
            $("#smrif_representante"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#modificar_rif_representante").on("input", function() {
        let valor_rr = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado_rr = '';
        if (valor_rr.length > 0) {
            let letra_rr = valor_rr.charAt(0);
            if ('VEJPG'.includes(letra_rr)) {
                resultado_rr = letra_rr;
            } else {
                resultado_rr = '';
            }

            let numeros_rr = valor_rr.substring(1).replace(/\D/g, '');

            if (numeros_rr.length > 0) {
                resultado_rr += '-' + numeros_rr.substring(0, 8);
                if (numeros_rr.length > 8) {
                    resultado_rr += '-' + numeros_rr.substring(8, 9);
                }
            }
        }
        $(this).val(resultado_rr);
    });

    $("#modificar_correo_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });
    $("#modificar_correo_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_proveedor"),
            "*Formato válido: example@gmail.com*"
        );
    });

    $("#modificar_direccion_proveedor").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let direccion = document.getElementById("modificar_direccion_proveedor");
        direccion.value = space(direccion.value);
    });
    $("#modificar_direccion_proveedor").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#smdireccion_proveedor"),
            "*El formato permite letras y números*"
        );
    });

    $("#modificar_telefono_1").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#modificar_telefono_1").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#smtelefono_1"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });
    $("#modificar_telefono_1").on("input", function() {
        let valor_t1 = $(this).val().replace(/\D/g, '');
        if(valor_t1.length > 4 && valor_t1.length <= 7)
            valor_t1 = valor_t1.slice(0,4) + '-' + valor_t1.slice(4);
        else if(valor_t1.length > 7)
            valor_t1 = valor_t1.slice(0,4) + '-' + valor_t1.slice(4,7) + '-' + valor_t1.slice(7,11);
        $(this).val(valor_t1);
    });

    $("#modificar_telefono_2").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#modificar_telefono_2").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#smtelefono_2"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });
    $("#modificar_telefono_2").on("input", function() {
        let valor_t2 = $(this).val().replace(/\D/g, '');
        if(valor_t2.length > 4 && valor_t2.length <= 7)
            valor_t2 = valor_t2.slice(0,4) + '-' + valor_t2.slice(4);
        else if(valor_t2.length > 7)
            valor_t2 = valor_t2.slice(0,4) + '-' + valor_t2.slice(4,7) + '-' + valor_t2.slice(7,11);
        $(this).val(valor_t2);
    });

    $("#modificar_observacion").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let observacion = document.getElementById("modificar_observacion");
        observacion.value = space(observacion.value);
    });
    $("#modificar_observacion").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#smobservacion"),
            "*El formato permite letras y números*"
        );
    });

    function validarProveedor(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s]{2,50}$/.test(datos.nombre_proveedor)) {
            errores.push("El nombre debe tener letras y/o números.");
        }
        if (!/^[VEJPG]-\d{8}-\d$/.test(datos.rif_proveedor)) {
            errores.push("Formato válido: J-12345678-9.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/.test(datos.nombre_representante)) {
            errores.push("El nombre debe tener solo letras.");
        }
        if (!/^[VEJPG]-\d{8}-\d$/.test(datos.rif_representante)) {
            errores.push("Formato válido: J-12345678-9.");
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo_proveedor)) {
            errores.push("Formato válido: example@gmail.com");
        }
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/.test(datos.direccion_proveedor)) {
            errores.push("La dirección debe tener letras y/o números.");
        }
        if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono_1)) {
            errores.push("Formato válido: 04XX-XXX-XXXX.");
        }
        if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono_2)) {
            errores.push("Formato válido: 04XX-XXX-XXXX.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/.test(datos.observacion)) {
            errores.push("La observación debe tener letras y/o números.");
        }
        return errores;
    }

    $(document).on('click', '#btnModificarProveedor', function () {
        $('#modificar_id_proveedor').val($(this).data('id'));
        $('#modificar_nombre_proveedor').val($(this).data('nombre-proveedor'));
        $('#modificar_rif_proveedor').val($(this).data('rif-proveedor'));
        $('#modificar_nombre_representante').val($(this).data('nombre-representante'));
        $('#modificar_rif_representante').val($(this).data('rif-representante'));
        $('#modificar_correo_proveedor').val($(this).data('correo-proveedor'));
        $('#modificar_direccion_proveedor').val($(this).data('direccion-proveedor'));
        $('#modificar_telefono_1').val($(this).data('telefono-1'));
        $('#modificar_telefono_2').val($(this).data('telefono-2'));
        $('#modificar_observacion').val($(this).data('observacion'));
        
        $('#smnombre_proveedor').text('');
        $('#smrif_proveedor').text('');
        $('#smnombre_representante').text('');
        $('#smrif_representante').text('');
        $('#smcorreo_proveedor').text('');
        $('#smdireccion_proveedor').text('');
        $('#smtelefono_1').text('');
        $('#smtelefono_2').text('');
        $('#smobservacion').text('');
        $('#modificarProveedorModal').modal('show');
    });

    $('#FormModificarProveedor').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre_proveedor: $('#modificar_nombre_proveedor').val(),
            rif_proveedor: $('#modificar_rif_proveedor').val(),
            nombre_representante: $('#modificar_nombre_representante').val(),
            rif_representante: $('#modificar_rif_representante').val(),
            correo_proveedor: $('#modificar_correo_proveedor').val(),
            direccion_proveedor: $('#modificar_direccion_proveedor').val(),
            telefono_1: $('#modificar_telefono_1').val(),
            telefono_2: $('#modificar_telefono_2').val(),
            observacion: $('#modificar_observacion').val()
        };

        const errores = validarProveedor(datos);

        if (errores.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
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
                    $('#modificarProveedorModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El proveedor se ha modificado correctamente'
                    });

                    const tabla = $("#tablaConsultas").DataTable();
                    const id = $("#modificar_id_proveedor").val();
                    const fila = tabla.row(`tr[data-id="${id}"]`);
                    const proveedor = response.proveedor;

                    if (fila.length) {
                        fila.data([
                            `<ul>
                                <div>
                                    <button class="btn-modificar"
                                        id="btnModificarProveedor"
                                        data-id="${proveedor.id_proveedor}"
                                        data-nombre-proveedor="${proveedor.nombre_proveedor}"
                                        data-rif-proveedor="${proveedor.rif_proveedor}"
                                        data-nombre-representante="${proveedor.nombre_representante}"
                                        data-rif-representante="${proveedor.rif_representante}"
                                        data-correo-proveedor="${proveedor.correo_proveedor}"
                                        data-direccion-proveedor="${proveedor.direccion_proveedor}"
                                        data-telefono-1="${proveedor.telefono_1}"
                                        data-telefono-2="${proveedor.telefono_2}"
                                        data-observacion="${proveedor.observacion}">
                                        Modificar
                                    </button>
                                </div>
                                <div>
                                    <button class="btn-eliminar"
                                        data-id="${proveedor.id_proveedor}">
                                        Eliminar
                                    </button>
                                </div>
                            </ul>`,
                            `<span class="campo-nombres">${proveedor.nombre_proveedor}</span>`,
                            `<span class="campo-rif-correo">${proveedor.rif_proveedor}</span>`,
                            `<span class="campo-nombres">${proveedor.nombre_representante}</span>`,
                            `<span class="campo-rif-correo">${proveedor.rif_representante}</span>`,
                            `<span class="campo-rif-correo">${proveedor.correo_proveedor}</span>`,
                            `<span class="campo-nombres">${proveedor.direccion_proveedor}</span>`,
                            `<span class="campo-numeros">${proveedor.telefono_1}</span>`,
                            `<span class="campo-numeros">${proveedor.telefono_2}</span>`,
                            `<span class="campo-nombres">${proveedor.observacion}</span>`,
                            `<span class="campo-estatus ${proveedor.estado === "habilitado" ? "habilitado" : "inhabilitado"}"
                                data-id="${proveedor.id_proveedor}" 
                                style="cursor: pointer;">
                                ${proveedor.estado}
                            </span>`,
                        ]).draw(false);

                        const filaNode = fila.node();
                        const botonModificar = $(filaNode).find(".btn-modificar");
                        botonModificar.data('nombre_proveedor', proveedor.nombre_proveedor);
                        botonModificar.data('rif_proveedor', proveedor.rif_proveedor);
                        botonModificar.data('nombre_representante', proveedor.nombre_representante);
                        botonModificar.data('rif_representante', proveedor.rif_representante);
                        botonModificar.data('correo_proveedor', proveedor.correo_proveedor);
                        botonModificar.data('direccion_proveedor', proveedor.direccion_proveedor);
                        botonModificar.data('telefono_1', proveedor.telefono_1);
                        botonModificar.data('telefono_2', proveedor.telefono_2);
                        botonModificar.data('observacion', proveedor.observacion);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo modificar el proveedor'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el porveedor:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el proveedor.');
            }
        });
    });

    $(document).on('click', '#modificarProveedorModal .close', function() {
        $('#modificarProveedorModal').modal('hide');
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
            confirmButtonText: 'Sí, eliminarla!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id_proveedor = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_proveedor', id_proveedor);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'El proveedor ha sido eliminada.',
                            'success'
                        );
                        eliminarFilaProveedor(id_proveedor);
                    } else {
                        Swal.fire('Error', respuesta.message, 'error');
                    }
                });
            }
        });
    });

    function eliminarFilaProveedor(id_proveedor) {
        const tabla = $('#tablaConsultas').DataTable();
        const fila = $(`#tablaConsultas tbody tr[data-id="${id_proveedor}"]`);
        tabla.row(fila).remove().draw();
    }

    $(document).on('click', '.campo-estatus', function() {
        const id_proveedor = $(this).data('id');
        cambiarEstatus(id_proveedor);
    });

    function cambiarEstatus(id_proveedor) {
        const span = $(`span.campo-estatus[data-id="${id_proveedor}"]`);
        const estatusActual = span.text().trim();
        const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';
        
        span.addClass('cambiando');
            
        $.ajax({
            url: '',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'cambiar_estado',
                id_proveedor: id_proveedor,
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
                    span.text(estatusActual);
                    span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                    Swal.fire('Error', data.message || 'Error al cambiar el estatus', 'error');
                }
            },
            error: function(xhr, status, error) {
                span.removeClass('cambiando');
                span.text(estatusActual);
                span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    }

    $(document).on('click', '#btnPedidoProducto', function() {
        var boton = $(this);
    
        $('#modificarIdProducto').val(boton.data('id'));
        $('#modificarNombreProducto').val(boton.data('nombre'));
        $('#modificarModelo').val(boton.data('modelo'));
        $('#modificarStockMinimo').val(boton.data('stockminimo'));
    
        $('#PedidoProductoModal').modal('show');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('PedidoProductoModal');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            // Obtener datos del botón
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const modelo = button.closest('tr').children[2].textContent; // Usa la celda de la tabla

            // Llenar el modal
            document.getElementById('modificarIdProducto').value = id;
            document.getElementById('modificarNombreProducto').value = nombre;
            document.getElementById('modificarModelo').value = modelo;
        });
    });

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#FormPedidoProducto').on('submit', function(e) {
        e.preventDefault();

        // Crear un objeto FormData con los datos del formulario
        var formData = new FormData(this);
        formData.append('accion', 'modificar');

        // Enviar la solicitud AJAX al controlador PHP
        $.ajax({
            url: '',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El pedido se realizó correctamente'
                    }).then(function() {
                        
                        if (response.proveedor) {
                            actualizarFilaProveedor(response.proveedor);
                        }
                        $('#modificar_usuario_modal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo realizar el pedido al proveedor'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al realizar el pedido:', textStatus, errorThrown);
                muestraMensaje('Error al realizar el pedido.');
            }
        });
    });

    $(document).on('click', '#PedidoProductoModal .close', function() {
        $('#PedidoProductoModal').modal('hide');
    });

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

    function validarKeyPress(er, e) {
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
});