$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_banco").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre_banco");
        nombre.value = space(nombre.value);
    });

    $("#nombre_banco").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/,
            $(this),
            $("#snombre_banco"),
            "*El formato solo permite letras*"
        );
    });

    $("#numero_cuenta").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#numero_cuenta").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{4}-\d{2}-\d{10}$/,
            $(this),
            $("#snumero_cuenta"),
            "*Formato válido: 01XX-XXXX-XX-XXXXXXXXXX*"
        );
    });
    $("#numero_cuenta").on("input", function() {
        let valor_nc = $(this).val().replace(/\D/g, '');
        if(valor_nc.length > 4 && valor_nc.length <= 8)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4);
        else if(valor_nc.length > 8 && valor_nc.length <= 10)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4,8) + '-' + valor_nc.slice(8,10);
        else if(valor_nc.length > 10)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4,8) + '-' + valor_nc.slice(8,10) + '-' + valor_nc.slice(10,20);
        $(this).val(valor_nc);
    });

    $("#rif_cuenta").on("keypress", function(e){ 
        validarKeyPress(/^[VEJPG0-9]$/i, e); 
    });
    $("#rif_cuenta").on("keyup", function(){ 
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d{1}$/,
            $(this),
            $("#srif_cuenta"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#rif_cuenta").on("input", function() {
        let valor = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado = '';
        if (valor.length > 0) {
            let letra = valor.charAt(0);
            if ('VEJPG'.includes(letra)) {
                resultado = letra;
            } else {
                resultado = '';
            }

            let numeros = valor.substring(1).replace(/\D/g, '');

            if (numeros.length > 0) {
                resultado += '-' + numeros.substring(0, 8);
                if (numeros.length > 8) {
                    resultado += '-' + numeros.substring(8, 9);
                }
            }
        }
        $(this).val(resultado);
    });

    $("#telefono_cuenta").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#telefono_cuenta").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono_cuenta"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });
    $("#telefono_cuenta").on("input", function() {
        let valor = $(this).val().replace(/\D/g, '');
        if(valor.length > 4 && valor.length <= 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4);
        else if(valor.length > 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4,7) + '-' + valor.slice(7,11);
        $(this).val(valor);
    });

    $("#correo_cuenta").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });

    $("#correo_cuenta").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_cuenta"),
            "*Formato válido: example@gmail.com*"
        );
    });

    function validarEnvioCuenta(){
        let nombre = document.getElementById("nombre_banco");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/,
            $("#nombre_banco"),
            $("#snombre_banco"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del banco','Debe tener solo letras');
            return false;
        }
        else if(validarKeyUp(
            /^\d{4}-\d{4}-\d{2}-\d{10}$/,
            $("#numero_cuenta"),
            $("#snumero_cuenta"),
            "*Formato correcto: 01XX-XXXX-XX-XXXXXXXXXX*"
        )==0){
            mensajes('error',4000,'Verifique el número de cuenta','Debe tener 20 dígitos');
            return false;
        }
        else if(validarKeyUp(
            /^[VEJPG]-\d{8}-\d{1}$/,
            $("#rif_cuenta"),
            $("#srif_cuenta"),
            "*Formato correcto: J-12345678-9*"
        )==0){
            mensajes('error',4000,'Verifique el RIF','Formato incorrecto');
            return false;
        }
        else if(validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $("#telefono_cuenta"),
            $("#stelefono_cuenta"),
            "*Formato correcto: 04XX-XXX-XXXX*"
        )==0){
            mensajes('error',4000,'Verifique el teléfono','Debe tener 11 dígitos');
            return false;
        }
        else if(validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $("#correo_cuenta"),
            $("#scorreo_cuenta"),
            "*Formato correcto: example@gmail.com*"
        )==0){
            mensajes('error',4000,'Verifique el correo','Correo no válido');
            return false;
        }
        return true;
    }

    function agregarFilaCuenta(cuenta) {
        const tabla = $('#tablaConsultas').DataTable();
        const nuevaFila = [
            `<ul>
                <div>
                    <button class="btn-modificar"
                        id="btnModificarCuenta"
                        data-id="${cuenta.id_cuenta}"
                        data-nombre="${cuenta.nombre_banco}"
                        data-numero="${cuenta.numero_cuenta}"
                        data-rif="${cuenta.rif_cuenta}"
                        data-telefono="${cuenta.telefono_cuenta}"
                        data-correo="${cuenta.correo_cuenta}">
                        Modificar
                    </button>
                </div>
                <div>
                    <button class="btn-eliminar"
                        data-id="${cuenta.id_cuenta}">
                        Eliminar
                    </button>
                </div>
            </ul>`,
            `<span class="campo-numeros">${cuenta.id_cuenta}</span>`,
            `<span class="campo-nombres">${cuenta.nombre_banco}</span>`,
            `<span class="campo-numeros">${cuenta.numero_cuenta}</span>`,
            `<span class="campo-rif-correo">${cuenta.rif_cuenta}</span>`,
            `<span class="campo-numeros">${cuenta.telefono_cuenta}</span>`,
            `<span class="campo-rif-correo">${cuenta.correo_cuenta}</span>`,
            `<span 
                class="campo-estatus ${cuenta.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
                data-id="${cuenta.id_cuenta}" 
                style="cursor: pointer;">
                ${cuenta.estado}
            </span>`
        ];
        const rowNode = tabla.row.add(nuevaFila).draw(false).node();
        $(rowNode).attr('data-id', cuenta.id_cuenta);
    }

    function resetCuenta() {
        $('#nombre_banco').val('');
        $('#numero_cuenta').val('');
        $('#rif_cuenta').val('');
        $('#telefono_cuenta').val('');
        $('#correo_cuenta').val('');
        $('#snombre_banco').text('');
        $('#snumero_cuenta').text('');
        $('#srif_cuenta').text('');
        $('#stelefono_cuenta').text('');
        $('#scorreo_cuenta').text('');
    }

    $('#btnIncluirCuenta').on('click', function() {
        $('#registrarCuenta')[0].reset();
        $('#snombre_banco').text('');
        $('#snumero_cuenta').text('');
        $('#srif_cuenta').text('');
        $('#stelefono_cuenta').text('');
        $('#scorreo_cuenta').text('');
        $('#registrarCuentaModal').modal('show');
    });

    $('#registrarCuenta').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioCuenta()){
            var datos = {
                nombre_banco: $("#nombre_banco").val(),
                numero_cuenta: $("#numero_cuenta").val(),
                rif_cuenta: $("#rif_cuenta").val(),
                telefono_cuenta: $("#telefono_cuenta").val(),
                correo_cuenta: $("#correo_cuenta").val(),
                accion: "registrar"
            };
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Cuenta registrada correctamente'
                    });
                    if(respuesta.status === "success" && respuesta.cuenta){
                        agregarFilaCuenta(respuesta.cuenta);
                        resetCuenta();
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar la cuenta'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarCuentaModal .close', function() {
        $('#registrarCuentaModal').modal('hide');
    });

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

    $("#modificar_nombre_banco").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_banco");
        nombre.value = Espacios(nombre.value);
    });
    $("#modificar_nombre_banco").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/,
            $(this),
            $("#smnombre_banco"),
            "*El formato solo permite letras y mínimo 3 caracteres*"
        );
    });

    $("#modificar_numero_cuenta").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });
    $("#modificar_numero_cuenta").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{4}-\d{2}-\d{10}$/,
            $(this),
            $("#smnumero_cuenta"),
            "*Formato válido: 01XX-XXXX-XX-XXXXXXXXXX*"
        );
    });
    $("#modificar_numero_cuenta").on("input", function() {
        let valor_nc = $(this).val().replace(/\D/g, '');
        if(valor_nc.length > 4 && valor_nc.length <= 8)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4);
        else if(valor_nc.length > 8 && valor_nc.length <= 10)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4,8) + '-' + valor_nc.slice(8,10);
        else if(valor_nc.length > 10)
            valor_nc = valor_nc.slice(0,4) + '-' + valor_nc.slice(4,8) + '-' + valor_nc.slice(8,10) + '-' + valor_nc.slice(10,20);
        $(this).val(valor_nc);
    });

    $("#modificar_rif_cuenta").on("keypress", function(e){
        validarKeyPress(/^[vejpg0-9-\b]*$/i, e);
    });
    $("#modificar_rif_cuenta").on("keyup", function(){
        validarKeyUp(
            /^[vejpg0-9-\b]*$/i,
            $(this),
            $("#smrif_cuenta"),
            "*Formato válido: J-12345678-9*"
        );
    });
    $("#modificar_rif_cuenta").on("input", function() {
        let valor = $(this).val().toUpperCase().replace(/[^A-Z0-9]/g, '');

        let resultado = '';
        if (valor.length > 0) {
            let letra = valor.charAt(0);
            if ('VEJPG'.includes(letra)) {
                resultado = letra;
            } else {
                resultado = '';
            }

            let numeros = valor.substring(1).replace(/\D/g, '');

            if (numeros.length > 0) {
                resultado += '-' + numeros.substring(0, 8);
                if (numeros.length > 8) {
                    resultado += '-' + numeros.substring(8, 9);
                }
            }
        }
        $(this).val(resultado);
    });

    $("#modificar_telefono_cuenta").on("keypress", function(e){
        validarKeyPress(/^[0-9]*$/, e);
    });
    $("#modificar_telefono_cuenta").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#smtelefono_cuenta"),
            "*El teléfono debe tener exactamente 11 dígitos*"
        );
    });
    $("#modificar_telefono_cuenta").on("input", function() {
        let valor = $(this).val().replace(/\D/g, '');
        if(valor.length > 4 && valor.length <= 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4);
        else if(valor.length > 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4,7) + '-' + valor.slice(7,11);
        $(this).val(valor);
    });

    $("#modificar_correo_cuenta").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });

    $("#modificar_correo_cuenta").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#smcorreo_cuenta"),
            "*El correo electrónico no es válido*"
        );
    });

    function validarCuenta(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{3,20}$/.test(datos.nombre_banco)) {
            errores.push("El nombre debe tener solo letras.");
        }
        if (!/^\d{4}-\d{4}-\d{2}-\d{10}$/.test(datos.numero_cuenta)) {
            errores.push("Formato correcto: 01XX-XXXX-XX-XXXXXXXXXX.");
        }
        if (!/^[VEJPG]-\d{8}-\d$/.test(datos.rif_cuenta)) {
            errores.push("Formato de RIF inválido (ej: J-12345678-9).");
        }
        if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono_cuenta)) {
            errores.push("Formato correcto: 04XX-XXX-XXXX.");
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo_cuenta)) {
            errores.push("Formato correcto: example@gmail.com.");
        }
        return errores;
    }

    $(document).on('click', '#btnModificarCuenta', function () {
        $('#modificar_id_cuenta').val($(this).data('id'));
        $('#modificar_nombre_banco').val($(this).data('nombre'));
        $('#modificar_numero_cuenta').val($(this).data('numero'));
        $('#modificar_rif_cuenta').val($(this).data('rif'));
        $('#modificar_telefono_cuenta').val($(this).data('telefono'));
        $('#modificar_correo_cuenta').val($(this).data('correo'));
        
        $('#smnombre_banco').text('');
        $('#smnumero_cuenta').text('');
        $('#smrif_cuenta').text('');
        $('#smtelefono_cuenta').text('');
        $('#smcorreo_cuenta').text('');
        $('#modificarCuentaModal').modal('show');
    });

    $('#modificarCuenta').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre_banco: $('#modificar_nombre_banco').val(),
            numero_cuenta: $('#modificar_numero_cuenta').val(),
            rif_cuenta: $('#modificar_rif_cuenta').val(),
            telefono_cuenta: $('#modificar_telefono_cuenta').val(),
            correo_cuenta: $('#modificar_correo_cuenta').val()
        };

        const errores = validarCuenta(datos);

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
                    $('#modificarCuentaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La cuenta se ha modificado correctamente'
                    });

                    const tabla = $("#tablaConsultas").DataTable();
                    const id = $("#modificar_id_cuenta").val();
                    const fila = tabla.row(`tr[data-id="${id}"]`);
                    const cuenta = response.cuenta;

                    if (fila.length) {
                        fila.data([
                            `<ul>
                                <div>
                                    <button class="btn-modificar"
                                        id="btnModificarCuenta"
                                        data-id="${cuenta.id_cuenta}"
                                        data-nombre="${cuenta.nombre_banco}"
                                        data-numero="${cuenta.numero_cuenta}"
                                        data-rif="${cuenta.rif_cuenta}"
                                        data-telefono="${cuenta.telefono_cuenta}"
                                        data-correo="${cuenta.correo_cuenta}">
                                        Modificar
                                    </button>
                                </div>
                                <div>
                                    <button class="btn-eliminar"
                                        data-id="${cuenta.id_cuenta}">
                                        Eliminar
                                    </button>
                                </div>
                            </ul>`,
                            `<span class="campo-numeros">${cuenta.id_cuenta}</span>`,
                            `<span class="campo-nombres">${cuenta.nombre_banco}</span>`,
                            `<span class="campo-numeros">${cuenta.numero_cuenta}</span>`,
                            `<span class="campo-rif-correo">${cuenta.rif_cuenta}</span>`,
                            `<span class="campo-numeros">${cuenta.telefono_cuenta}</span>`,
                            `<span class="campo-rif_correo">${cuenta.correo_cuenta}</span>`,
                            `<span 
                                class="campo-estatus ${cuenta.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
                                data-id="${cuenta.id_cuenta}" 
                                style="cursor: pointer;">
                                ${cuenta.estado}
                            </span>`
                        ]).draw(false);

                        const filaNode = fila.node();
                        const botonModificar = $(filaNode).find(".btn-modificar");
                        botonModificar.data('nombre_banco', cuenta.nombre_banco);
                        botonModificar.data('numero_cuenta', cuenta.numero_cuenta);
                        botonModificar.data('rif_cuenta', cuenta.rif_cuenta);
                        botonModificar.data('telefono_cuenta', cuenta.telefono_cuenta);
                        botonModificar.data('correo_cuenta', cuenta.correo_cuenta);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo modificar la cuenta'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la Cuenta:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la Cuenta.');
            }
        });
    });

    $(document).on('click', '#modificarCuentaModal .close', function() {
        $('#modificarCuentaModal').modal('hide');
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
                var id_cuenta = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_cuenta', id_cuenta);
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: datos,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.status === 'success') {
                            Swal.fire(
                                'Eliminada!',
                                'La cuenta ha sido eliminada.',
                                'success'
                            );
                            eliminarFilaCuenta(id_cuenta);
                        } else {
                            muestraMensaje(respuesta.message);
                        }
                    },
                    error: function () {
                        muestraMensaje('Error en la solicitud AJAX');
                    }
                });
            }
        });
    });

    function eliminarFilaCuenta(id_cuenta) {
        const tabla = $('#tablaConsultas').DataTable();
        const fila = $(`#tablaConsultas tbody tr[data-id="${id_cuenta}"]`);
        tabla.row(fila).remove().draw();
    }

    $(document).on('click', '.campo-estatus', function() {
        const id_cuenta = $(this).data('id');
        cambiarEstado(id_cuenta);
    });

    function cambiarEstado(id_cuenta) {
        const span = $(`span.campo-estatus[data-id="${id_cuenta}"]`);
        const estadoActual = span.text().trim();
        const nuevoEstado = estadoActual === 'habilitado' ? 'inhabilitado' : 'habilitado';
        
        span.addClass('cambiando');
            
        $.ajax({
            url: '',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'cambiar_estado',
                id_cuenta: id_cuenta,
                estado: nuevoEstado
            },
            success: function(data) {
                span.removeClass('cambiando');
                if (data.status === 'success') {
                    span.text(nuevoEstado);
                    span.removeClass('habilitado inhabilitado').addClass(nuevoEstado);
                    Swal.fire({
                        icon: 'success',
                        title: '¡Estatus actualizado!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    span.text(estadoActual);
                    span.removeClass('habilitado inhabilitado').addClass(estadoActual);
                    Swal.fire('Error', data.message || 'Error al cambiar el estatus', 'error');
                }
            },
            error: function(xhr, status, error) {
                span.removeClass('cambiando');
                span.text(estadoActual);
                span.removeClass('habilitado inhabilitado').addClass(estadoActual);
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
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
    
    function muestraMensaje(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: mensaje
        });
    }
});