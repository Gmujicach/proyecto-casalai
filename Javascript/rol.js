$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_rol").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre_rol");
        nombre.value = space(nombre.value);
    });
    $("#nombre_rol").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $(this),
            $("#snombre_rol"),
            "*El formato solo permite letras*"
        );
    });

    function validarEnvioRol(){
        let nombre = document.getElementById("nombre_rol");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $("#nombre_rol"),
            $("#snombre_rol"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del rol','Debe tener solo letras');
            return false;
        }
        return true;
    }

    function agregarFilaRol(rol) {
        const nuevaFila = `
            <tr data-id="${rol.id_rol}">
                <td>
                    <ul>
                        <li>
                            <button class="btn btn-primary btn-modificar"
                                data-id="${rol.id_rol}"
                                data-nombre="${rol.nombre_rol}">
                                Modificar
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-danger btn-eliminar"
                                data-id="${rol.id_rol}">
                                Eliminar
                            </button>
                        </li>
                    </ul>
                </td>
                <td>${rol.id_rol}</td>
                <td>${rol.nombre_rol}</td>
            </tr>
        `;
        $('#tablaConsultas tbody').append(nuevaFila);
    }

    function resetRol() {
        $("#nombre_rol").val('');
        $("#snombre_rol").text('');
    }

    $('#registrarRol').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioRol()){
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Rol registrado correctamente'
                    });
                    agregarFilaRol(respuesta.rol);
                    resetRol();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar el rol'
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
                if(callback) callback(respuesta);
            },
            error: function () {
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            }
        });
    }

    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_rol').val($(this).data('id'));
        $('#modificar_nombre_rol').val($(this).data('nombre'));
        $('#smnombre_rol').text('');
        $('#modificarRolModal').modal('show');
    });

    $("#modificar_nombre_rol").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_rol");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_rol").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $(this),
            $("#smnombre_rol"),
            "*El formato solo permite letras*"
        );
    });

    function validarRol(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/.test(datos.nombre_rol)) {
            errores.push("El nombre debe tener solo letras.");
        }
        return errores;
    }

    $('#modificarRol').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre_marca: $('#modificar_nombre_rol').val()
        };

        const errores = validarRol(datos);

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
                    $('#modificarRolModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El rol se ha modificado correctamente'
                    });

                    const id = $('#modificar_id_rol').val();
                    const nombre = $('#modificar_nombre_rol').val();

                    const fila = $('tr[data-id="' + id + '"]');
                    fila.find('td').eq(1).text(nombre);

                    const botonModificar = fila.find('.btn-modificar');
                    botonModificar.data('nombre', nombre);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo modificar el rol'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar el rol:', textStatus, errorThrown);
                muestraMensaje('Error al modificar el rol.');
            }
        });
    });

    $(document).on('click', '#modificarMarcaModal .close', function() {
        $('#modificarMarcaModal').modal('hide');
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
                var id_rol = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_rol', id_rol);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'El rol ha sido eliminada.',
                            'success'
                        );
                        eliminarFilaRol(id_rol);
                    } else {
                        Swal.fire('Error', respuesta.message, 'error');
                    }
                });
            }
        });
    });

    function eliminarFilaRol(id_rol) {
        $(`#tablaConsultas tbody tr[data-id="${id_rol}"]`).remove();
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
});