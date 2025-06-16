$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_categoria").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]*$/, e);
        let nombre = document.getElementById("nombre_categoria");
        nombre.value = space(nombre.value);
    });
    $("#nombre_categoria").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,20}$/,
            $(this),
            $("#snombre_categoria"),
            "*El formato permite letras y números*"
        );
    });

    function validarEnvioCategoria(){
        let nombre = document.getElementById("nombre_categoria");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,20}$/,
            $("#nombre_categoria"),
            $("#snombre_categoria"),
            "*El nombre debe tener letras y/o números*"
        )==0){
            mensajes('error',4000,'Verifique el nombre de la categoria','Debe tener letras y/o números');
            return false;
        }
        return true;
    }

    function validarCaracteristicas() {
    let validacionCorrecta = true;
    let mensajeError = '';

    const regexNombre = /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ]+(?: [a-zA-ZÁÉÍÓÚñÑáéíóúüÜ]+)*$/;

    $('.caracteristica-item').each(function(index, item) {
        const nombre = $(item).find('input[name*="[nombre]"]');
        const tipo = $(item).find('select[name*="[tipo]"]');
        const max = $(item).find('input[name*="[max]"]');

        const nombreVal = $.trim(nombre.val());

        if (nombreVal === '') {
            mensajeError = 'El nombre de una característica está vacío.';
            nombre.focus();
            validacionCorrecta = false;
            return false;
        }

        if (!regexNombre.test(nombreVal)) {
            mensajeError = 'El nombre de la característica solo puede contener letras y un espacio entre palabras.';
            nombre.focus();
            validacionCorrecta = false;
            return false;
        }

        if (tipo.val() === '') {
            mensajeError = 'Debe seleccionar un tipo para cada característica.';
            tipo.focus();
            validacionCorrecta = false;
            return false;
        }

        if ($.trim(max.val()) === '' || parseInt(max.val()) <= 0) {
            mensajeError = 'El campo "Máx. caracteres" debe ser mayor a 0.';
            max.focus();
            validacionCorrecta = false;
            return false;
        }
    });

    if (!validacionCorrecta) {
        mensajes('error', 4000, 'Error de validación', mensajeError);
    }

    return validacionCorrecta;
}

    function agregarFilaCategoria(categoria) {
        const nuevaFila = `
            <tr data-id="${categoria.id_categoria}">
                <td>
                    <Categoria>
                        <div>
                            <button class="btn-modificar"
                                data-id="${categoria.id_categoria}"
                                data-nombre="${categoria.nombre_categoria}">
                                Modificar
                            </button>
                        </div>
                        <div>
                            <button class="btn-eliminar"
                                data-id="${categoria.id_categoria}">
                                Eliminar
                            </button>
                        </div>
                    </Categoria
                </td>
                <td>${categoria.id_categoria}</td>
                <td>${categoria.nombre_categoria}</td>
            </tr>
        `;
        $('#tablaConsultas tbody').append(nuevaFila);
    }

    function resetCategoria() {
        $("#nombre_categoria").val('');
        $("#snombre_categoria").text('');
    }

    $('#btnIncluirCategoria').on('click', function() {
        $('#registrarCategoria')[0].reset();
        $('#snombre_categoria').text('');
        $('#registrarCategoriaModal').modal('show');
    });

    $('#registrarCategoria').on('submit', function(e) {
        e.preventDefault();

        if(validarEnvioCategoria() && validarCaracteristicas()) {
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" || respuesta.resultado === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || respuesta.msg || 'Categoria registrada correctamente'
                    });
                    agregarFilaCategoria(respuesta.categoria);
                    $('#registrarCategoriaModal').modal('hide');    
                    resetCategoria();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || respuesta.msg || 'No se pudo registrar la categoria'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarCategoriaModal .close', function() {
        $('#registrarCategoriaModal').modal('hide');
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
        $('#modificar_id_categoria').val($(this).data('id'));
        $('#modificar_nombre_categoria').val($(this).data('nombre'));
        $('#smnombre_categoria').text('');
        $('#modificarCategoriaModal').modal('show');
    });

    $("#modificar_nombre_categoria").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_categoria");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_categoria").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,20}$/,
            $(this),
            $("#smnombre_categoria"),
            "*El formato permite letras y números*"
        );
    });

    function validarCategoria(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,20}$/.test(datos.nombre_categoria)) {
            errores.push("El nombre debe tener letras y/o números.");
        }
        return errores;
    }

    $('#modificarCategoria').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre_categoria: $('#modificar_nombre_categoria').val()
        };

        const errores = validarCategoria(datos);

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
                    $('#modificarCategoriaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'La categoria se ha modificado correctamente'
                    });

                    const id = $('#modificar_id_categoria').val();
                    const nombre = $('#modificar_nombre_categoria').val();

                    const fila = $('tr[data-id="' + id + '"]');
                    fila.find('td').eq(2).text(nombre);

                    const botonModificar = fila.find('.btn-modificar');
                    botonModificar.data('nombre', nombre);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo modificar la categoria'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al modificar la categoria:', textStatus, errorThrown);
                muestraMensaje('Error al modificar la categoria.');
            }
        });
    });

    $(document).on('click', '#modificarCategoriaModal .close', function() {
        $('#modificarCategoriaModal').modal('hide');
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
                var id_categoria = $(this).data('id');
                var datos = new FormData();
                datos.append('accion', 'eliminar');
                datos.append('id_categoria', id_categoria);
                enviarAjax(datos, function(respuesta){
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'La ccategoria ha sido eliminada.',
                            'success'
                        );
                        eliminarFilaCategoria(id_categoria);
                    } else {
                        Swal.fire('Error', respuesta.message, 'error');
                    }
                });
            }
        });
    });

    function eliminarFilaCategoria(id_categoria) {
        $(`#tablaConsultas tbody tr[data-id="${id_categoria}"]`).remove();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('registrarCategoria');
        const contenedor = document.getElementById('caracteristicasContainer');
        const btnAgregar = document.getElementById('agregarCaracteristica');

        let contador = 0;
        const maxCaracteristicas = 5;

        const crearInputCaracteristica = (id, puedeEliminar = true) => {
            const div = document.createElement('div');
            div.classList.add('caracteristica-item');
            div.dataset.index = id;

            div.innerHTML = `
                <input type="text" name="caracteristicas[${id}][nombre]" placeholder="Nombre" class="form-control" maxlength="20" required>
                <select name="caracteristicas[${id}][tipo]" class="form-select" required>
                    <option value="">Tipo</option>
                    <option value="int">Entero</option>
                    <option value="float">Decimal</option>
                    <option value="string">Texto</option>
                </select>
                <input type="number" name="caracteristicas[${id}][max]" placeholder="Máx. caracteres" class="form-control" min="1" max="255" required>
                ${puedeEliminar ? `<button type="button" class="btn btn-danger btn-eliminar-caracteristicas">✖</button>` : ''}
            `;

            if (puedeEliminar) {
                div.querySelector('.btn-eliminar-caracteristicas').addEventListener('click', () => {
                    contenedor.removeChild(div);
                    contador--;
                    btnAgregar.disabled = false;
                });
            }

            contenedor.appendChild(div);
        };

        crearInputCaracteristica(contador++, false);

        btnAgregar.addEventListener('click', () => {
            if (contador < maxCaracteristicas) {
                crearInputCaracteristica(contador++);
                if (contador === maxCaracteristicas) {
                    btnAgregar.disabled = true;
                }
            }
        });
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
