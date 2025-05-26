$(document).ready(function () {

    // MENSAJE //
    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    // NOMBRE DE LA MARCA
    $("#nombre_marca").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre_marca");
        nombre.value = space(nombre.value);
    });
    $("#nombre_marca").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $(this),
            $("#snombre_marca"),
            "*El formato solo permite letras*"
        );
    });

    // Validación antes de enviar (registro)
    function validarEnvioMarca(){
        let nombre = document.getElementById("nombre_marca");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $("#nombre_marca"),
            $("#snombre_marca"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre de la marca','Debe tener solo letras');
            return false;
        }
        return true;
    }

    // Función para agregar la fila a la tabla
    function agregarFilaMarca(marca) {
        const nuevaFila = `
            <tr data-id="${marca.id_marca}">
                <td>${marca.nombre_marca}</td>
                <td>
                    <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                        <div class="desplegable">
                            <ul>
                                <li>
                                    <button class="btn btn-primary btn-modificar"
                                        data-id="${marca.id_marca}"
                                        data-nombre="${marca.nombre_marca}">
                                        Modificar
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-danger btn-eliminar"
                                        data-id="${marca.id_marca}">
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

    // Resetear formulario
    function resetMarca() {
        $("#nombre_marca").val('');
        $("#snombre_marca").text('');
    }

    // Enviar formulario de registro por AJAX
    $('#registrarMarca').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioMarca()){
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Marca registrada correctamente'
                    });
                    agregarFilaMarca(respuesta.marca);
                    resetMarca();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar la marca'
                    });
                }
            });
        }
    });

    // Función genérica para enviar AJAX
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

    // Cargar datos de la marca en el modal al abrir
    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_marca').val($(this).data('id'));
        $('#modificar_nombre_marca').val($(this).data('nombre'));
        $('#smnombre_marca').text('');
        $('#modificarMarcaModal').modal('show');
    });

    // Validaciones en tiempo real para el modal de modificar
    $("#modificar_nombre_marca").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_marca");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_marca").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/,
            $(this),
            $("#smnombre_marca"),
            "*El formato solo permite letras*"
        );
    });

    // Validación para modificar
    function validarMarca(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s\b]{2,25}$/.test(datos.nombre_marca)) {
            errores.push("El nombre debe tener solo letras.");
        }
        return errores;
    }

    // Enviar modificación por AJAX
    $('#modificarMarca').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre_marca: $('#modificar_nombre_marca').val()
        };

        const errores = validarMarca(datos);

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
                    $('#modificarMarcaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La marca se ha modificado correctamente'
                    });

                    const id = $('#modificar_id_marca').val();
                    const nombre = $('#modificar_nombre_marca').val();

                    const fila = $('tr[data-id="' + id + '"]');
                    fila.find('td').eq(1).text(nombre);

                    const botonModificar = fila.find('.btn-modificar');
                    botonModificar.data('nombre', nombre);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo modificar la marca'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la marca:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la marca.');
            }
        });
    });

    // Cerrar modal de modificación
    $(document).on('click', '#modificarMarcaModal .close', function() {
        $('#modificarMarcaModal').modal('hide');
    });

    // Eliminar marca
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
                var id_marca = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_marca', id_marca);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'La marca ha sido eliminada.',
                            'success'
                        );
                        eliminarFilaMarca(id_marca);
                    } else {
                        Swal.fire('Error', respuesta.message, 'error');
                    }
                });
            }
        });
    });

    function eliminarFilaMarca(id_marca) {
        $(`#tablaConsultas tbody tr[data-id="${id_marca}"]`).remove();
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

    // Delegación para el despliegue de opciones (modificar/eliminar)
    $('#tablaConsultas').on('click', '.vertical', function(e) {
        e.stopPropagation(); // Prevenir cierre inmediato

        // Cerrar todos los menús primero
        $('.desplegable').not($(this).next('.desplegable')).hide();

        // Alternar el menú actual
        const menuActual = $(this).next('.desplegable');
        menuActual.toggle();
    });

    // Cerrar el menú si se hace clic fuera
    $(document).on('click', function() {
        $('.desplegable').hide();
    });
});