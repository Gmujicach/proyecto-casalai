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

    function verificarPermisosEnTiempoRealModelos() {
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
            $('#btnIncluirModelo').show();
        } else {
            $('#btnIncluirModelo').hide();
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
    verificarPermisosEnTiempoRealModelos();
    setInterval(verificarPermisosEnTiempoRealModelos, 10000); // 10 segundos
});

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

    function agregarFilaModelo(modelo) {
        const nuevaFila = `
            <tr data-id="${modelo.id_modelo}">
                <td>
                    <ul>
                        <div>
                            <button class="btn-modificar"
                                id="btnModificarModelo"
                                data-id="${modelo.id_modelo}"
                                data-marcaid="${modelo.id_marca}"
                                data-nombre="${modelo.nombre_modelo}">
                                Modificar
                            </button>
                            <button class="btn-eliminar"
                                data-id="${modelo.id_modelo}">
                                Eliminar
                            </button>
                        </div>
                    </ul>
                </td>
                <td><span class="campo-numeros">${modelo.id_modelo}</span></td>
                <td><span class="campo-nombres">${modelo.nombre_marca}</span></td>
                <td><span class="campo-nombres">${modelo.nombre_modelo}</span></td>
            </tr>
        `;
        const tabla = $('#tablaConsultas').DataTable();
        tabla.row.add($(nuevaFila)).draw(false);
        tabla.page('last').draw('page');
    }

    function resetModelo() {
        $("#id_marca").val('');
        $("#nombre_modelo").val('');
        $("#snombre_modelo").text('');
    }

    $('#btnIncluirModelo').on('click', function() {
        $('#registrarModelo')[0].reset();
        $('#snombre_modelo').text('');
        $('#registrarModeloModal').modal('show');
    });

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
                        text: respuesta.message || respuesta.msg || 'modelo registrado correctamente'
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

    $(document).on('click', '#registrarModeloModal .close', function() {
        $('#registrarModeloModal').modal('hide');
    });

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

    $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_modelo').val($(this).data('id'));
        llenarSelectMarcasModal($(this).data('marcaid'));
        $('#modificar_nombre_modelo').val($(this).data('nombre'));
        $('#smnombre_modelo').text('');
        $('#modificarModeloModal').modal('show');
    });

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
                    // Actualizar la fila en la tabla con el mismo formato
                let modelo = respuesta.modelo; // El backend debe retornar el modelo actualizado
                let fila = $(`tr[data-id="${modelo.id_modelo}"]`);
const nuevaFila = [
    `<ul>
        <div>
            <button class="btn-modificar"
                data-id="${modelo.id_modelo}"
                data-marcaid="${modelo.id_marca}"
                data-nombre="${modelo.nombre_modelo}">
                Modificar
            </button>
            <button class="btn-eliminar"
                data-id="${modelo.id_modelo}">
                Eliminar
            </button>
        </div>
    </ul>`,
    `<span class="campo-numeros">${modelo.id_modelo}</span>`,
    `<span class="campo-nombres">${modelo.nombre_marca}</span>`,
    `<span class="campo-nombres">${modelo.nombre_modelo}</span>`
];
const tabla = $('#tablaConsultas').DataTable();
const page = tabla.page();
fila = tabla.row(`tr[data-id="${modelo.id_modelo}"]`);
if (fila.length) {
    fila.data(nuevaFila).draw(false);
    tabla.page(page).draw(false);

    const filaNode = fila.node();
    const botonModificar = $(filaNode).find(".btn-modificar");
    botonModificar.data("marcaid", modelo.id_marca);
    botonModificar.data("nombre", modelo.nombre_modelo);
}
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.message || 'No se pudo modificar el modelo'
                });
            }
        });
    });

    $(document).on('click', '#modificarModeloModal .close', function() {
        $('#modificarModeloModal').modal('hide');
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

    $(document).on('click', '#modificarMarcaModal .close', function() {
        $('#modificarMarcaModal').modal('hide');
    });

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
});