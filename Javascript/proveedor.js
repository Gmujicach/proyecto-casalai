$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
        let nombre_p = document.getElementById("nombre_proveedor");
        nombre_p.value = space(nombre_p.value);
    });
    $("#nombre_proveedor").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/,
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
    $("#rif_representante").on("input", function() {
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
        else if(valor_t1.length > 7)
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
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/,
            $("#nombre_proveedor"),
            $("#snombre_proveedor"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del proveedor','Debe tener solo letras');
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
    const nuevaFila = `
        <tr data-id="${proveedor.id_proveedor}">
            <td>
                <ul>
                    <div>
                        <button class="btn-modificar"
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
                </ul>
            </td>
            <td><span class="campo-nombres">${proveedor.nombre_proveedor}</span></td>
            <td><span class="campo-nombres">${proveedor.rif_proveedor}</span></td>
            <td><span class="campo-nombres">${proveedor.nombre_representante}</span></td>
            <td><span class="campo-nombres">${proveedor.rif_representante}</span></td>
            <td><span class="campo-correo">${proveedor.correo_proveedor}</span></td>
            <td><span class="campo-nombres">${proveedor.direccion_proveedor}</span></td>
            <td><span class="campo-telefono">${proveedor.telefono_1}</span></td>
            <td><span class="campo-telefono">${proveedor.telefono_2}</span></td>
            <td><span class="campo-nombres">${proveedor.observacion}</span></td>
            <td class="campo-estado">
            <span 
                class="campo-estatus ${proveedor.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
                data-id="${proveedor.id_proveedor}" 
                style="cursor: pointer;">
                ${proveedor.estado}
            </span>
            </td>
        </tr>
    `;
        $('#tablaConsultas tbody').append(nuevaFila);
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

    $('#registrarRol').on('submit', function(e) {
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

    $(document).on('click', '.btn-modificar', function () {
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

    $("#nombre_proveedor").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
        let nombre_p = document.getElementById("nombre_proveedor");
        nombre_p.value = space(nombre_p.value);
    });
    $("#nombre_proveedor").on("keyup", function () {
        validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/,
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
    $("#rif_representante").on("input", function() {
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
        else if(valor_t1.length > 7)
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

///////
    
    $(document).on('click', '.modificar', function() {
    var boton = $(this);

    $('#modificar_id_proveedor').val(boton.data('id'));
    $('#modificar_nombre_proveedor').val(boton.data('nombre'));
    $('#modificar_persona_contacto').val(boton.data('persona-contacto'));
    $('#modificar_direccion').val(boton.data('direccion'));
    $('#modificar_telefono').val(boton.data('telefono'));
    $('#modificar_correo').val(boton.data('correo'));
    $('#modificar_telefono_secundario').val(boton.data('telefono-secundario'));
    $('#modificar_rif_proveedor').val(boton.data('rif-proveedor'));
    $('#modificar_rif_representante').val(boton.data('rif-representante'));
    $('#modificar_observaciones').val(boton.data('observaciones'));

    $('#modificar_usuario_modal').modal('show');
});

    // Cargar datos del marcas en el modal al abrir
        $(document).on('click', '#modificarProductoBtn', function() {
        var boton = $(this);
    
        // Llenar los campos del formulario con los datos del botón
        $('#modificarIdProducto').val(boton.data('id'));
        $('#modificarNombreProducto').val(boton.data('nombre'));
        $('#modificarModelo').val(boton.data('modelo'));
        $('#modificarStockMinimo').val(boton.data('stockminimo'));
    
        // Mostrar el modal
        $('#modificarProductoModal').modal('show');
    });
    document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modificarProductoModal');
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

    $(document).on('click', '.btn-modificar', function() {
        var id_proveedor = $(this).data('id');

        // Establecer el id_producto en el campo oculto del formulario de modificación
        $('#modificar_id_proveedor').val(id_proveedor);

        // Realizar una solicitud AJAX para obtener los datos del marcas desde la base de datos
        $.ajax({
            url: '', // Ruta al controlador PHP que maneja las peticiones
            type: 'POST',
            dataType: 'json',
            data: { id_proveedor: id_proveedor, accion: 'obtener_proveedor' },
            success: function(proveedores) {
                console.log('Datos del Proveedor obtenidos:', proveedores);
                // Llenar los campos del formulario con los datos obtenidos del marcas
                $('#modificarnombre_proveedor').val(proveedores.nombre);
                $('#modificarrif_proveedor').val(proveedores.rif_proveedor);
                $('#modificarnombre_representante').val(proveedores.presona_contacto);
                $('#modificarrif_representante').val(proveedores.rif_representante);
                $('#modificardireccion_proveedor').val(proveedores.direccion);
                $('#modificartelefono_1').val(proveedores.telefono);
                $('#modificartelefono_2').val(proveedores.telefono_secundario);
                $('#modificarcorreo_proveedor').val(proveedores.correo);
                $('#modificarobservacion').val(proveedores.observaciones);
                
                // Ajustar la imagen si se maneja la carga de imágenes
                // $('#modificarImagen').val(marcas.imagen);

                // Mostrar el modal de modificación después de llenar los datos
                $('#modificar_proveedor_modal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                muestraMensaje('Error al cargar los datos del Proveedor.');
            }
        });
    });

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarProveedorForm').on('submit', function(e) {
        e.preventDefault();

        // Crear un objeto FormData con los datos del formulario
        var formData = new FormData(this);
        formData.append('accion', 'modificar');

        // Enviar la solicitud AJAX al controlador PHP
        $.ajax({
            url: '', // Asegúrate de que la URL sea correcta
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
            text: 'El Proveedor se ha modificado correctamente'
        }).then(function() {
            // Supón que el backend retorna el proveedor modificado en response.proveedor
            if (response.proveedor) {
                actualizarFilaProveedor(response.proveedor);
            }
            $('#modificar_usuario_modal').modal('hide');
$('.modal-backdrop').remove();
$('body').removeClass('modal-open');
$('body').css('padding-right', '');
        });
    } else {
        muestraMensaje(response.message);
    }
},
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el Proveedor:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el Proveedor.');
            }
        });
    });

function actualizarFilaProveedor(proveedor) {
    const tabla = $('#tablaConsultas').DataTable();
    $('#tablaConsultas tbody tr').each(function() {
        if ($(this).attr('data-id') == proveedor.id_proveedor) {
            tabla.row(this).data([
                `<div class="acciones-boton">
                    <button type="button" class="btn btn-primary btn-modificar modificar" 
                        data-id="${proveedor.id_proveedor}"
                        data-nombre="${proveedor.nombre}"
                        data-persona-contacto="${proveedor.presona_contacto}"
                        data-direccion="${proveedor.direccion}"
                        data-telefono="${proveedor.telefono}"
                        data-correo="${proveedor.correo}"
                        data-telefono-secundario="${proveedor.telefono_secundario}"
                        data-rif-proveedor="${proveedor.rif_proveedor}"
                        data-rif-representante="${proveedor.rif_representante}"
                        data-observaciones="${proveedor.observaciones}"
                        data-toggle="modal" 
                        data-target="#modificar_usuario_modal">
                        Modificar
                    </button>
                    <button type="button" class="btn btn-danger btn-eliminar eliminar" data-id="${proveedor.id_proveedor}">Eliminar</button>
                </div>`,
                `<span class="campo-nombres">${proveedor.nombre}</span>`,
                `<span class="campo-correo">${proveedor.correo}</span>`,
                `<span class="campo-nombres">${proveedor.rif_proveedor}</span>`,
                `<span class="campo-telefono">${proveedor.telefono}</span>`,
                `<span class="campo-estatus ${proveedor.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
                    data-id="${proveedor.id_proveedor}"
                    onclick="cambiarEstatus(${proveedor.id_proveedor}, '${proveedor.estado}')"
                    style="cursor: pointer;">
                    ${proveedor.estado}
                </span>`
            ]).draw(false);
        }
    });
}

$(document).on('click', '.acciones-boton .vertical', function(e) {
    e.stopPropagation();
    $('.desplegable').not($(this).siblings('.desplegable')).hide();
    $(this).siblings('.desplegable').toggle();
});

$(document).on('click', function() {
    $('.desplegable').hide();
});

    // Función para eliminar el proveedor
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault();
    var id_proveedor = $(this).data('id');
    
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
            datos.append('id_proveedor', id_proveedor);
            
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
                                'El proveedor ha sido eliminado.',
                                'success'
                            );
                            // Elimina la fila de la tabla y actualiza el paginador
                            const tabla = $('#tablaConsultas').DataTable();
                            $('#tablaConsultas tbody tr').each(function() {
                                if ($(this).attr('data-id') == id_proveedor) {
                                    tabla.row(this).remove().draw(false);
                                }
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                respuesta.message || 'Error al eliminar el proveedor',
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

    // Función para incluir un nuevo producto
    $('#incluirproveedor').on('submit', function(event) {
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
                text: 'Proveedor ingresado exitosamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Supón que el backend retorna el proveedor insertado en data.proveedor
                if (data.proveedor) {
                    agregarFilaProveedor(data.proveedor);
                }
                $('#incluirproveedor')[0].reset();
                $('#incluirproveedor input, #incluirproveedor textarea').val('');
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al ingresar el Proveedor',
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
});

function agregarFilaProveedor(proveedor) {
    const tabla = $('#tablaConsultas').DataTable();
    const nuevaFila = tabla.row.add([
        `<div class="acciones-boton">
            <button type="button" class="btn btn-primary btn-modificar modificar" 
                data-id="${proveedor.id_proveedor}"
                data-nombre="${proveedor.nombre}"
                data-persona-contacto="${proveedor.presona_contacto}"
                data-direccion="${proveedor.direccion}"
                data-telefono="${proveedor.telefono}"
                data-correo="${proveedor.correo}"
                data-telefono-secundario="${proveedor.telefono_secundario}"
                data-rif-proveedor="${proveedor.rif_proveedor}"
                data-rif-representante="${proveedor.rif_representante}"
                data-observaciones="${proveedor.observaciones}"
                data-toggle="modal" 
                data-target="#modificar_usuario_modal">
                Modificar
            </button>
            <button type="button" class="btn btn-danger btn-eliminar eliminar" data-id="${proveedor.id_proveedor}">Eliminar</button>
        </div>`,
        `<span class="campo-nombres">${proveedor.nombre}</span>`,
        `<span class="campo-correo">${proveedor.correo}</span>`,
        `<span class="campo-nombres">${proveedor.rif_proveedor}</span>`,
        `<span class="campo-telefono">${proveedor.telefono}</span>`,
        `<span class="campo-estatus ${proveedor.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
            data-id="${proveedor.id_proveedor}"
            onclick="cambiarEstatus(${proveedor.id_proveedor}, '${proveedor.estado}')"
            style="cursor: pointer;">
            ${proveedor.estado}
        </span>`
    ]).draw(false).node();
    $(nuevaFila).attr('data-id', proveedor.id_proveedor);
}

// Función genérica para enviar AJAX
function enviarAjax(datos, callback) {
    console.log("Enviando datos AJAX: ", datos); // Punto de depuración
    $.ajax({
        url: '', // Asegúrate de que la URL apunte al controlador correcto
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta) {
            console.log("Respuesta del servidor: ", respuesta); // Punto de depuración
            callback(JSON.parse(respuesta));
        },
        error: function () {
            console.error('Error en la solicitud AJAX');
            muestraMensaje('Error en la solicitud AJAX');
        }
    });
}

function cambiarEstatus(idUsuario) {
    const span = $(`span.campo-estatus[data-id="${idUsuario}"]`);
    const estatusActual = span.text().trim().toLowerCase();
    const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';

    span.addClass('cambiando');

    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'cambiar_estado',
            id_proveedor: idUsuario,
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
// Función genérica para mostrar mensajes
function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}