$(document).ready(function () {

    // MENSAJE //
    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
        let nombre = document.getElementById("nombre");
        nombre.value = space(nombre.value);
    });
    $("#nombre").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
            $(this),
            $("#snombre"),
            "*Solo letras, de 2 a 30 caracteres*"
        );
    });

    $("#apellido").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
        let nombre = document.getElementById("apellido");
        nombre.value = space(nombre.value);
    });
    $("#apellido").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
            $(this),
            $("#sapellido"),
            "*Solo letras, de 2 a 30 caracteres*"
        );
    });

    $("#nombre_usuario").on("keypress", function(e){
        validarKeyPress(/^[a-zA-Z0-9_]*$/, e);
    });
    $("#nombre_usuario").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-Z0-9_]{4,20}$/,
            $(this),
            $("#snombre_usuario"),
            "*El usuario debe tener entre 4 y 20 caracteres alfanuméricos*"
        );
    });

    // TELÉFONO
    $("#telefono_usuario").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });

    $("#telefono_usuario").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono_usuario"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });

    // CORREO ELECTRÓNICO
    $("#correo_usuario").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });

    $("#correo_usuario").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_usuario"),
            "*Formato válido: example@gmail.com*"
        );
    });

    $("#clave_usuario").on("keypress", function(e){
        validarKeyPress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/, e);
    });
    $("#clave_usuario").on("keyup", function(){
        validarKeyUp(
            /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{4,15}$/,
            $(this),
            $("#sclave_usuario"),
            "*Solo letras y números, de 3 a 15 caracteres*"
        );
    });

    $("#clave_confirmar").on("keypress", function(e){
        validarKeyPress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/, e);
    });
    $("#clave_confirmar").on("keyup", function(){
        validarKeyUp(
            /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{4,15}$/,
            $(this),
            $("#sclave_confirmar"),
            "*Solo letras y números, de 3 a 15 caracteres*"
        );
    });

    function validarEnvioUsuario() {
        let valido = true;

        // Nombre
        let nombre = $("#nombre");
        nombre.val(space(nombre.val()).trim());
        if (validarKeyUp(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/, nombre, $("#snombre"), "*Solo letras, de 2 a 30 caracteres*") == 0) {
            valido = false;
        }

        // Apellido
        let apellido = $("#apellido");
        apellido.val(space(apellido.val()).trim());
        if (validarKeyUp(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/, apellido, $("#sapellido"), "*Solo letras, de 2 a 30 caracteres*") == 0) {
            valido = false;
        }

        // Nombre de usuario
        let nombre_usuario = $("#nombre_usuario");
        nombre_usuario.val(space(nombre_usuario.val()).trim());
        if (validarKeyUp(/^[a-zA-Z0-9_]{4,20}$/, nombre_usuario, $("#snombre_usuario"), "*El usuario debe tener entre 4 y 20 caracteres alfanuméricos*") == 0) {
            valido = false;
        }

        // Teléfono
        let telefono_usuario = $("#telefono_usuario");
        if (validarKeyUp(/^\d{4}-\d{3}-\d{4}$/, telefono_usuario, $("#stelefono_usuario"), "*Formato válido: 04XX-XXX-XXXX*") == 0) {
            valido = false;
        }

        // Correo electrónico
        let correo_usuario = $("#correo_usuario");
        if (validarKeyUp(/^[^\s@]+@[^\s@]+\.[^\s@]+$/, correo_usuario, $("#scorreo_usuario"), "*Formato válido: example@gmail.com*") == 0) {
            valido = false;
        }

        // Clave
        let clave_usuario = $("#clave_usuario");
        if (validarKeyUp(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{4,15}$/, clave_usuario, $("#sclave_usuario"), "*Solo letras y números, de 3 a 15 caracteres*") == 0) {
            valido = false;
        }

        // Confirmar clave
        let clave_confirmar = $("#clave_confirmar");
        if (validarKeyUp(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{4,15}$/, clave_confirmar, $("#sclave_confirmar"), "*Solo letras y números, de 3 a 15 caracteres*") == 0) {
            valido = false;
        }

        // Confirmación de clave igual
        if (clave_usuario.val() !== clave_confirmar.val()) {
            $("#sclave_confirmar").text("*Las contraseñas no coinciden*");
            valido = false;
        }

        if (!valido) {
            mensajes('error', 4000, 'Verifique los campos', 'Corrija los errores antes de continuar');
        }
        return valido;
    }

    function agregarFilaUsuario(usuario) {
        const nuevaFila = `
            <tr data-id="${usuario.id_usuario}">
                <td>${usuario.username}</td>
                <td>${usuario.nombres}</td>
                <td>${usuario.apellidos}</td>
                <td>${usuario.correo}</td>
                <td>${usuario.telefono}</td>
                <td>${usuario.rango}</td>
                <td>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li>
                                    <button class="btn btn-primary btn-modificar"
                                        data-id="${usuario.id_usuario}"
                                        data-username="${usuario.username}"
                                        data-nombres="${usuario.nombres}"
                                        data-apellidos="${usuario.apellidos}"
                                        data-correo="${usuario.correo}"
                                        data-telefono="${usuario.telefono}"
                                        data-clave="${usuario.password}"
                                        data-rango="${usuario.rango}">
                                        Modificar
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-danger btn-eliminar"
                                        data-id="${usuario.id_usuario}">
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

    // Resetear formulario de usuario
    function resetUsuario() {
        $("#username").val('');
        $("#susername").text('');
        $("#nombres").val('');
        $("#snombres").text('');
        $("#apellidos").val('');
        $("#sapellidos").text('');
        $("#correo").val('');
        $("#scorreo").text('');
        $("#telefono").val('');
        $("#stelefono").text('');
        $("#clave").val('');
        $("#sclave").text('');
        $("#rango").val('');
    }

    // Enviar formulario de registro de usuario por AJAX
    $('#incluirusuario').on('submit', function(e) {
        e.preventDefault();

        if (validarEnvioUsuario()) {
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Usuario registrado correctamente'
                    });
                    agregarFilaUsuario(respuesta.usuario);
                    resetUsuario();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar el usuario'
                    });
                }
            });
        }
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
                if (callback) callback(respuesta);
            },
            error: function () {
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            }
        });
    }

    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_usuario').val($(this).data('id_usuario'));
        $('#modificarnombre_usuario').val($(this).data('username'));
        $('#modificarnombre').val($(this).data('nombres'));
        $('#modificarapellido_usuario').val($(this).data('apellidos'));
        $('#modificarcorreo_usuario').val($(this).data('correo'));
        $('#modificartelefono_usuario').val($(this).data('telefono'));
        $('#rango').val($(this).data('rango'));
        // Limpia los spans de validación si los tienes
        $('#smodificarnombre_usuario').text('');
        $('#smodificarnombre').text('');
        $('#smodificarapellido_usuario').text('');
        $('#smodificarcorreo_usuario').text('');
        $('#smodificartelefono_usuario').text('');
        $('#smodificarclave_usuario').text('');
        $('#modificar_usuario_modal').modal('show');
    });

    // Validación antes de enviar (modal modificar usuario)
    /*function validarEnvioUsuarioModificar() {
        let errores = [];

        // Username
        let username = $("#modificar_username");
        username.val(space(username.val()).trim());
        if (validarKeyUp(/^[a-zA-Z0-9_]{4,20}$/, username, $("#smodificar_username"), "*El usuario debe tener entre 4 y 20 caracteres alfanuméricos*") == 0) {
            valido = false;
        }

        // Nombres
        let nombres = $("#modificar_nombres");
        nombres.val(space(nombres.val()).trim());
        if (validarKeyUp(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/, nombres, $("#smodificar_nombres"), "*Solo letras, mínimo 2 caracteres*") == 0) {
            valido = false;
        }

        // Apellidos
        let apellidos = $("#modificar_apellidos");
        apellidos.val(space(apellidos.val()).trim());
        if (validarKeyUp(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/, apellidos, $("#smodificar_apellidos"), "*Solo letras, mínimo 2 caracteres*") == 0) {
            valido = false;
        }

        // Correo
        let correo = $("#modificar_correo");
        if (validarKeyUp(/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/, correo, $("#smodificar_correo"), "*Correo electrónico no válido*") == 0) {
            valido = false;
        }

        // Teléfono
        let telefono = $("#modificar_telefono");
        if (validarKeyUp(/^[0-9]{7,15}$/, telefono, $("#smodificar_telefono"), "*Solo números, mínimo 7 dígitos*") == 0) {
            valido = false;
        }

        // Contraseña (opcional en modificar)
        let clave = $("#modificar_clave");
        if (clave.val().length > 0 && validarKeyUp(/^.{6,20}$/, clave, $("#smodificar_clave"), "*La contraseña debe tener entre 6 y 20 caracteres*") == 0) {
            valido = false;
        }

        if (!valido) {
            mensajes('error', 4000, 'Verifique los campos', 'Corrija los errores antes de continuar');
        }
        return valido;
    }*/

    // Enviar modificación de usuario por AJAX
    $('#modificarusuario').on('submit', function(e) {
        e.preventDefault();

        // Validación antes de enviar
        const datos = {
            username: $('#modificarnombre_usuario').val(),
            nombres: $('#modificarnombre').val(),
            apellidos: $('#modificarapellido_usuario').val(),
            correo: $('#modificarcorreo_usuario').val(),
            telefono: $('#modificartelefono_usuario').val(),
            rango: $('#rango').val()
        };

        const errores = [];
        if (!/^[a-zA-Z0-9_]{4,20}$/.test(datos.username)) {
            errores.push("El usuario debe tener entre 4 y 20 caracteres alfanuméricos.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.nombres)) {
            errores.push("Nombres: solo letras, de 2 a 30 caracteres.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.apellidos)) {
            errores.push("Apellidos: solo letras, de 2 a 30 caracteres.");
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo)) {
            errores.push("Formato correcto: example@gmail.com.");
        }
        if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono)) {
            errores.push("Formato correcto: 04XX-XXX-XXXX.");
        }

        // Contraseña solo si se va a cambiar
        let clave = $('#modificarclave_usuario').val();
        if (clave.length > 0 && !/^.{6,20}$/.test(clave)) {
            errores.push("La contraseña debe tener entre 6 y 20 caracteres.");
        }

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
        enviarAjax(formData, function(response) {
            if (response.status === 'success') {
                $('#modificar_usuario_modal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Modificado',
                    text: 'El usuario se ha modificado correctamente'
                });

                const id = $('#modificar_id_usuario').val();
                const fila = $(`#tablaConsultas tbody tr[data-id="${id}"]`);
                fila.find('td').eq(0).text($('#modificarnombre').val());
                fila.find('td').eq(1).text($('#modificarapellido_usuario').val());
                fila.find('td').eq(2).text($('#modificarcorreo_usuario').val());
                fila.find('td').eq(3).text($('#modificartelefono_usuario').val());
                fila.find('td').eq(4).text($('#rango').val());

                // Actualiza los data-atributos del botón modificar
                const botonModificar = fila.find('.btn-modificar');
                botonModificar.data('nombres', $('#modificarnombre').val());
                botonModificar.data('apellidos', $('#modificarapellido_usuario').val());
                botonModificar.data('correo', $('#modificarcorreo_usuario').val());
                botonModificar.data('telefono', $('#modificartelefono_usuario').val());
                botonModificar.data('rango', $('#rango').val());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No se pudo modificar el usuario'
                });
            }
        });
    });

    /*$('#formModificarUsuario').on('submit', function(e) {
        e.preventDefault();

        // Validación antes de enviar
        const datos = {
            username: $('#modificar_username').val(),
            nombres: $('#modificar_nombres').val(),
            apellidos: $('#modificar_apellidos').val(),
            correo: $('#modificar_correo').val(),
            telefono: $('#modificar_telefono').val(),
            rango: $('#modificar_rango').val()
        };

        const errores = [];
        if (!/^[a-zA-Z0-9_]{4,20}$/.test(datos.username)) {
            errores.push("El usuario debe tener entre 4 y 20 caracteres alfanuméricos.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.nombres)) {
            errores.push("Nombres: solo letras, mínimo 2 caracteres.");
        }
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.apellidos)) {
            errores.push("Apellidos: solo letras, mínimo 2 caracteres.");
        }
        if (!/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/.test(datos.correo)) {
            errores.push("Correo electrónico no válido.");
        }
        if (!/^[0-9]{7,15}$/.test(datos.telefono)) {
            errores.push("Teléfono: solo números, mínimo 7 dígitos.");
        }

        // Contraseña solo si se va a cambiar
        let clave = $('#modificar_clave').val();
        if (clave.length > 0 && !/^.{6,20}$/.test(clave)) {
            errores.push("La contraseña debe tener entre 6 y 20 caracteres.");
        }

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
                $('#modalModificarUsuario').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Modificado',
                    text: 'El usuario se ha modificado correctamente'
                });

                const id = $('#modificar_id_usuario').val();
                const fila = $(`#tablaUsuarios tbody tr[data-id="${id}"]`);
                fila.find('td').eq(0).text($('#modificar_username').val());
                fila.find('td').eq(1).text($('#modificar_nombres').val());
                fila.find('td').eq(2).text($('#modificar_apellidos').val());
                fila.find('td').eq(3).text($('#modificar_correo').val());
                fila.find('td').eq(4).text($('#modificar_telefono').val());
                fila.find('td').eq(5).text($('#modificar_rango').val());

                // Actualiza los data-atributos del botón modificar
                const botonModificar = fila.find('.btn-modificar');
                botonModificar.data('username', $('#modificar_username').val());
                botonModificar.data('nombres', $('#modificar_nombres').val());
                botonModificar.data('apellidos', $('#modificar_apellidos').val());
                botonModificar.data('correo', $('#modificar_correo').val());
                botonModificar.data('telefono', $('#modificar_telefono').val());
                botonModificar.data('rango', $('#modificar_rango').val());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No se pudo modificar el usuario'
                });
            }
        },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la marca:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la marca.');
            }
        });
    });*/

    // Cerrar modal de modificación
    $(document).on('click', '#modificar_usuario_modal .close', function() {
        $('#modificar_usuario_modal').modal('hide');
    });
    
    // Función para eliminar el producto
    $(document).on('click', '.btn-eliminar', function (e) {
        e.preventDefault();
        let id_usuario = $(this).data('id_usuario');
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
                datos.append('id_usuario', id_usuario);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire('Eliminado!', 'El usuario ha sido eliminado.', 'success');
                        $(`#tablaConsultas tbody tr[data-id="${id_usuario}"]`).remove();
                    } else {
                        Swal.fire('Error', respuesta.message || 'No se pudo eliminar el usuario', 'error');
                    }
                });
            }
        });
    });
    /*
    // Función para incluir un nuevo producto
    $('#incluirusuario').on('submit', function(event) {
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
                            text: 'Usuario ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al ingresar la Marca',
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
    });*/

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

    // Cambio de estado
    $(document).on('click', '.campo-estatus', function() {
        const id_usuario = $(this).data('id_usuario');
        cambiarEstatus(id_usuario);
    });

    function cambiarEstatus(id_usuario) {
        const span = $(`span.campo-estatus[data-id="${id_usuario}"]`);
        const estatusActual = span.text().trim();
        const nuevoEstatus = estatusActual === 'habilitado' ? 'inhabilitado' : 'habilitado';
        
        // Feedback visual inmediato
        span.addClass('cambiando');
        
        $.ajax({
            url: '',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'cambiar_estatus',
                id_usuario: id_usuario,
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
                    // Revertir visualmente
                    span.text(estatusActual);
                    span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                    Swal.fire('Error', data.message || 'Error al cambiar el estatus', 'error');
                }
            },
            error: function(xhr, status, error) {
                span.removeClass('cambiando');
                // Revertir visualmente
                span.text(estatusActual);
                span.removeClass('habilitado inhabilitado').addClass(estatusActual);
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    }

    $(document).ready(function() {
        // Manejar clic en flechas
        $(document).on('click', '.flecha-izquierda, .flecha-derecha', function(e) {
            e.preventDefault();
            const url = $(this).closest('a').attr('href');
            if(url) {
                cambiarPagina(url.split('pagina=')[1]);
            }
        });

        // Manejar cambio en filas por página
        $('#filasPorPagina').change(function() {
            cambiarFilasPorPagina(this.value);
        });
    });

    function cambiarPagina(pagina) {
        const filas = $('#filasPorPagina').val();
        
        $.ajax({
            url: '',
            type: 'GET',
            data: {
                pagina: pagina,
                filas: filas,
                ajax: true
            },
            success: function(data) {
                $('#tabla-usuarios').replaceWith($(data).find('#tabla-usuarios'));
                actualizarParametrosURL(pagina, filas);
            }
        });
    }

    function actualizarParametrosURL(pagina, filas) {
        const url = new URL(window.location);
        url.searchParams.set('pagina', pagina);
        url.searchParams.set('filas', filas);
        window.history.pushState({}, '', url);
    }
});