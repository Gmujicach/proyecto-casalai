$(document).ready(function () {

    // Validación en tiempo real para registro
    $("#nombre_modelo").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]*$/, e);
        let nombre = document.getElementById("nombre_modelo");
        nombre.value = space(nombre.value);
    });
    $("#nombre_modelo").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]{1,25}$/,
            $(this),
            $("#snombre_modelo"),
            "*El formato permite letras, números y (-/)*"
        );
    });

    // Validación antes de enviar (registro)
    function validarEnvioModelo(){
        let nombre = document.getElementById("nombre_modelo");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]{1,25}$/,
            $("#nombre_modelo"),
            $("#snombre_modelo"),
            "*El nombre permite letras, números y (-/)*"
        )==0){
            mensajes('error',4000,'Verifique el nombre del modelo','se permite letras, números y (-/)');
            return false;
        }
        return true;
    }

    // Función para agregar una nueva fila a la tabla
function agregarFilaModelo(modelo) {
    const nuevaFila = `
        <tr data-id="${modelo.id_modelo}">
            <td>${modelo.id_modelo}</td>
            <td>${modelo.nombre_marca}</td>
            <td>${modelo.nombre_modelo}</td>
            <td>
                <div class="acciones-boton">
                    <i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                    <div class="desplegable">
                        <ul>
                            <li>
                                <button class="btn btn-primary btn-modificar"
                                    data-id="${modelo.id_modelo}"
                                    data-marcaid="${modelo.id_marca}"
                                    data-nombre="${modelo.nombre_modelo}">
                                    Modificar
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-danger btn-eliminar"
                                    data-id="${modelo.id_modelo}">
                                    Eliminar
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    `;
    const tabla = $('#tablaConsultas').DataTable();
    tabla.row.add($(nuevaFila)).draw(false); // Agrega la fila
    tabla.page('last').draw('page');         // Muestra la última página
}

    // Resetear formulario
    function resetModelo() {
        $("#id_marca").val('');
        $("#nombre_modelo").val('');
        $("#snombre_modelo").text('');
    }

    // Enviar formulario de registro por AJAX
    $('#registrarModelo').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioModelo()){
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Modelo registrado correctamente'
                    });
                    agregarFilaModelo(respuesta.modelo);
                    resetModelo();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar el modelo'
                    });
                }
            });
        }
    });

    // Cargar datos de modelo en el modal al abrir
    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_modelo').val($(this).data('id'));
        llenarSelectMarcasModal($(this).data('marcaid'));
        $('#modificar_nombre_modelo').val($(this).data('nombre'));
        $('#smnombre_modelo').text('');
        $('#modificarModeloModal').modal('show');
    });

    // Validaciones en tiempo real para el modal de modificar
    $("#modificar_nombre_modelo").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_modelo");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_modelo").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]{1,25}$/,
            $(this),
            $("#smnombre_modelo"),
            "*El formato permite letras, números y (-/)*"
        );
    });

    // Enviar modificación por AJAX
    $('#modificarModelo').on('submit', function(e) {
        e.preventDefault();

        let nombreModelo = $("#modificar_nombre_modelo").val().trim();
        let idMarca = $("#modificar_marca_modelo").val();
        let nombreMarca = $("#modificar_marca_modelo option:selected").text();

        if(!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9-/\s\b]{1,25}$/.test(nombreModelo)){
            Swal.fire('Error', 'El nombre solo permite letras, números y (-/)', 'error');
            return;
        }

        var datos = new FormData(this);
        datos.append('accion', 'modificar');
        enviarAjax(datos, function(respuesta){
            if(respuesta.status === "success" || respuesta.resultado === "success"){
                $('#modificarModeloModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Modificado',
                    text: respuesta.message || 'El modelo se ha modificado correctamente'
                });
                // Actualizar la fila en la tabla
                let fila = $(`tr[data-id="${$("#modificar_id_modelo").val()}"]`);
                fila.find('td').eq(1).text(nombreMarca);      // Columna Marca
                fila.find('td').eq(2).text(nombreModelo);     // Columna Modelo
                // Actualizar los data-atributos del botón modificar
                fila.find('.btn-modificar')
                    .data('nombre', nombreModelo)
                    .data('marcaid', idMarca);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.message || 'No se pudo modificar el modelo'
                });
            }
        });
    });

    function llenarSelectMarcasModal(idSeleccionada) {
        let select = $('#modificar_marca_modelo');
        select.empty();
        select.append('<option value="">Seleccione una marca</option>');
        window.marcasDisponibles.forEach(function(marca) {
            let selected = marca.id_marca == idSeleccionada ? 'selected' : '';
            select.append(`<option value="${marca.id_marca}" ${selected}>${marca.nombre_marca}</option>`);
        });
    }

    // Cerrar modal de modificación
    $(document).on('click', '#modificarMarcaModal .close', function() {
        $('#modificarMarcaModal').modal('hide');
    });

    // Eliminar modelo
    $(document).on('click', '.btn-eliminar', function () {
        let id_modelo = $(this).data('id');
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
                datos.append('id_modelo', id_modelo);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire('Eliminado!', 'El modelo ha sido eliminado.', 'success');
                        const tabla = $('#tablaConsultas').DataTable();
                        const fila = $(`#tablaConsultas tbody tr[data-id="${id_modelo}"]`);
                        tabla.row(fila).remove().draw();
                    } else {
                        Swal.fire('Error', respuesta.message, 'error');
                    }
                });
            }
        });
    });

    // Función AJAX genérica
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

    // Funciones utilitarias (puedes copiar las de marcas.js)
    function validarKeyPress(regex, e) {
        let key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (!regex.test(key)) {
            e.preventDefault();
            return false;
        }
        return true;
    }
    function validarKeyUp(regex, input, span, mensaje) {
        if (!regex.test(input.val())) {
            span.text(mensaje);
            return 0;
        } else {
            span.text('');
            return 1;
        }
    }
    function space(text) {
        return text.replace(/\s{2,}/g, ' ');
    }
    function mensajes(tipo, tiempo, titulo, texto) {
        Swal.fire({
            icon: tipo,
            title: titulo,
            text: texto,
            timer: tiempo,
            showConfirmButton: false
        });
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