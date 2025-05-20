$(document).ready(function () {

    // MENSAJE //
    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    // NOMBRE DEL BANCO
    $("#nombre_banco").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre_banco");
        nombre.value = space(nombre.value);
    });

    $("#nombre_banco").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{3,20}$/,
            $(this),
            $("#snombre_banco"),
            "*El formato solo permite letras*"
        );
    });

    // NÚMERO DE CUENTA
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

    // RIF
    $("#rif_cuenta").on("keypress", function(e){
        validarKeyPress(/^[VEJPG0-9-\b]*$/, e);
    });

    $("#rif_cuenta").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
            $(this),
            $("#srif_cuenta"),
            "*Formato válido: J-12345678-9*"
        );
    });

    // TELÉFONO
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

    // CORREO ELECTRÓNICO
    $("#correo_cuenta").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_cuenta"),
            "*Formato válido: example@gmail.com*"
        );
    });

    // Enviar formulario de registro
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
                    agregarFilaCuenta(respuesta.cuenta);
                    resetCuenta();
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

    // Cargar datos de la cuenta en el modal al abrir
    $(document).on('click', '.btn-modificar', function () {
        var fila = $(this).closest('tr');
        var celdas = fila.find('td');
        $('#modificar_id_cuenta').val(celdas.eq(0).text().trim());
        $('#modificar_nombre_banco').val(celdas.eq(1).text().trim());
        $('#modificar_numero_cuenta').val(celdas.eq(2).text().trim());
        $('#modificar_rif_cuenta').val(celdas.eq(3).text().trim());
        $('#modificar_telefono_cuenta').val(celdas.eq(4).text().trim());
        $('#modificar_correo_cuenta').val(celdas.eq(5).text().trim());
        $('#modificarCuentaModal').modal('show');
    });

    // Enviar datos de modificación por AJAX al controlador PHP
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
                title: 'Errores de validación',
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

                    const id = $('#modificar_id_cuenta').val();
                    const nombre = $('#modificar_nombre_banco').val();
                    const numero = $('#modificar_numero_cuenta').val();
                    const rif = $('#modificar_rif_cuenta').val();
                    const telefono = $('#modificar_telefono_cuenta').val();
                    const correo = $('#modificar_correo_cuenta').val();

                    const fila = $('tr[data-id="' + id + '"]');
                    fila.find('td').eq(1).text(nombre);
                    fila.find('td').eq(2).text(numero);
                    fila.find('td').eq(3).text(rif);
                    fila.find('td').eq(4).text(telefono);
                    fila.find('td').eq(5).text(correo);

                    const botonModificar = fila.find('.btn-modificar');
                    botonModificar.data('nombre', nombre);
                    botonModificar.data('numero', numero);
                    botonModificar.data('rif', rif);
                    botonModificar.data('telefono', telefono);
                    botonModificar.data('correo', correo);

                } else {
                    muestraMensaje(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la Cuenta:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la Cuenta.');
            }
        });
    });

    // Eliminar cuenta
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

    // Cambio de estado
    $(document).on('click', '.campo-estatus', function() {
        const id_cuenta = $(this).data('id');
        cambiarEstado(id_cuenta);
    });

    // Resetear formulario
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

    // Validación antes de enviar (registro)
    function validarEnvioCuenta(){
        let nombre = document.getElementById("nombre_banco");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{3,20}$/,
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
            mensajes('error',4000,'Verifique el número de cuenta','Debe tener 20 dígitos separados por "-"');
            return false;
        }
        else if(validarKeyUp(
            /^[VEJPG]-\d{8}-\d$/,
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
            mensajes('error',4000,'Verifique el teléfono','Debe tener 11 dígitos separados por "-"');
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

    // Validación para modificar
    function validarCuenta(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{3,20}$/.test(datos.nombre_banco)) {
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

    // Función genérica para enviar AJAX
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

    // Función para agregar una nueva fila a la tabla
    function agregarFilaCuenta(cuenta) {
        const nuevaFila = `
            <tr data-id="${cuenta.id_cuenta}">
                <td>${cuenta.id_cuenta}</td>
                <td>${cuenta.nombre_banco}</td>
                <td>${cuenta.numero_cuenta}</td>
                <td>${cuenta.rif_cuenta}</td>
                <td>${cuenta.telefono_cuenta}</td>
                <td>${cuenta.correo_cuenta}</td>
                <td>
                    <span 
                        class="campo-estatus ${cuenta.estado === 'habilitado' ? 'habilitado' : 'inhabilitado'}" 
                        data-id="${cuenta.id_cuenta}" 
                        style="cursor: pointer;">
                        ${cuenta.estado}
                    </span>
                </td>
                <td>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li>
                                    <button class="btn btn-primary btn-modificar"
                                        data-id="${cuenta.id_cuenta}"
                                        data-nombre="${cuenta.nombre_banco}"
                                        data-numero="${cuenta.numero_cuenta}"
                                        data-rif="${cuenta.rif_cuenta}"
                                        data-telefono="${cuenta.telefono_cuenta}"
                                        data-correo="${cuenta.correo_cuenta}">
                                        Modificar
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-danger btn-eliminar"
                                        data-id="${cuenta.id_cuenta}">
                                        Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        `;
        $('#tablaConsultas tbody').append(nuevaFila);
    }

    // Función para eliminar una fila de la tabla
    function eliminarFilaCuenta(id_cuenta) {
        $(`#tablaConsultas tbody tr[data-id="${id_cuenta}"]`).remove();
    }

    // Función para cambiar el estado de la cuenta
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

    // Función genérica para mostrar mensajes
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

    // Utilidades de validación
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

document.addEventListener("DOMContentLoaded", function () {
    // Delegación de eventos para cada botón
    document.querySelectorAll('.acciones-boton i').forEach(function (icono) {
        icono.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevenir que se cierre inmediatamente por el click global

            // Cerrar todos los menús primero
            document.querySelectorAll('.desplegable').forEach(function (menu) {
                if (menu !== icono.nextElementSibling) {
                    menu.style.display = 'none';
                }
            });

            // Alternar el menú actual
            const menuActual = icono.nextElementSibling;
            if (menuActual.style.display === 'block') {
                menuActual.style.display = 'none';
            } else {
                menuActual.style.display = 'block';
            }
        });
    });

    // Cerrar el menú si se hace clic fuera
    document.addEventListener('click', function () {
        document.querySelectorAll('.desplegable').forEach(function (menu) {
            menu.style.display = 'none';
        });
    });
});