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
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,20}$/,
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
    let hayString = false;

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

        if (tipo.val() === 'string') {
            hayString = true;
            if ($.trim(max.val()) === '' || parseInt(max.val()) <= 0) {
                mensajeError = 'El campo "Máx. caracteres" debe ser mayor a 0.';
                max.focus();
                validacionCorrecta = false;
                return false;
            }
        }
    });

    // Si no hay ninguna característica tipo string, no validar el campo max
    if (!hayString) {
        // No hacer nada, no hay validación extra
    }

    if (!validacionCorrecta) {
        mensajes('error', 4000, 'Error de validación', mensajeError);
    }

    return validacionCorrecta;
}

    function agregarFilaCategoria(categoria) {
        const tabla = $('#tablaConsultas').DataTable();
        const nuevaFila = [
            `<ul>
                <div>
                    <button class="btn-modificar"
                        id="btnModificarCategoria"
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
            </ul>`,
            `<span class="campo-numeros">${categoria.id_categoria}</span>`,
            `<span class="campo-nombres">${categoria.nombre_categoria}</span>`
        ];
        const rowNode = tabla.row.add(nuevaFila).draw(false).node();
        $(rowNode).attr('data-id', categoria.id_categoria);
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

    $("#modificar_nombre_categoria").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_categoria");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_categoria").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,20}$/,
            $(this),
            $("#smnombre_categoria"),
            "*El formato permite letras y números*"
        );
    });

    function validarCategoria(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,20}$/.test(datos.nombre_categoria)) {
            errores.push("El nombre debe tener letras y/o números.");
        }
        return errores;
    }

    $(document).on('click', '#btnModificarCategoria', function () {
        $('#modificar_id_categoria').val($(this).data('id'));
        $('#modificar_nombre_categoria').val($(this).data('nombre'));
        $('#smnombre_categoria').text('');
        $('#modificarCategoriaModal').modal('show');
    });

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

                    const tabla = $("#tablaConsultas").DataTable();
                    const id = $("#modificar_id_categoria").val();
                    const fila = tabla.row(`tr[data-id="${id}"]`);
                    const categoria = response.categoria;

                    if (fila.length) {
                        fila.data([
                            `<ul>
                                <div>
                                    <button class="btn-modificar"
                                        id="btnModificarCategoria"
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
                            </ul>`,
                            `<span class="campo-numeros">${categoria.id_categoria}</span>`,
                            `<span class="campo-nombres">${categoria.nombre_categoria}</span>`
                        ]).draw(false);

                        const filaNode = fila.node();
                        const botonModificar = $(filaNode).find(".btn-modificar");
                        botonModificar.data('nombre', categoria.nombre_categoria);
                    }
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
        const tabla = $('#tablaConsultas').DataTable();
        const fila = $(`#tablaConsultas tbody tr[data-id="${id_categoria}"]`);
        tabla.row(fila).remove().draw();
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
        <select name="caracteristicas[${id}][tipo]" class="form-select tipo-caracteristica" required>
            <option value="" disable hidden>Tipo</option>
            <option value="int">Entero</option>
            <option value="float">Decimal</option>
            <option value="string">Texto</option>
        </select>
        <input type="number" name="caracteristicas[${id}][max]" placeholder="Máx. caracteres" class="form-control max-caracteres" min="1" max="255" style="display:none;">
        ${puedeEliminar ? `<button type="button" class="btn btn-danger btn-eliminar-caracteristicas">✖</button>` : ''}
    `;

    // Mostrar/ocultar el campo de max según el tipo
    const selectTipo = div.querySelector('.tipo-caracteristica');
    const inputMax = div.querySelector('.max-caracteres');
    selectTipo.addEventListener('change', function() {
        if (this.value === 'string') {
            inputMax.style.display = '';
            inputMax.required = true;
        } else {
            inputMax.style.display = 'none';
            inputMax.value = '';
            inputMax.required = false;
        }
    });

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
    // ...código existente...

// Utilidad para crear inputs de características en el modal de modificar
function crearInputCaracteristicaMod(id, nombre = '', tipo = '', max = '', puedeEliminar = true) {
    const div = document.createElement('div');
    div.classList.add('caracteristica-item');
    div.dataset.index = id;

    div.innerHTML = `
        <input type="text" name="caracteristicas[${id}][nombre]" placeholder="Nombre" class="form-control" maxlength="20" required value="${nombre}">
        <select name="caracteristicas[${id}][tipo]" class="form-select tipo-caracteristica" required>
            <option value="" disable hidden>Tipo</option>
            <option value="int" ${tipo === 'int' ? 'selected' : ''}>Entero</option>
            <option value="float" ${tipo === 'float' ? 'selected' : ''}>Decimal</option>
            <option value="string" ${tipo === 'string' ? 'selected' : ''}>Texto</option>
        </select>
        <input type="number" name="caracteristicas[${id}][max]" placeholder="Máx. caracteres" class="form-control max-caracteres" min="1" max="255" value="${tipo === 'string' ? max : ''}" style="${tipo === 'string' ? '' : 'display:none;'}">
        ${puedeEliminar ? `<button type="button" class="btn btn-danger btn-eliminar-caracteristicas">✖</button>` : ''}
    `;

    // Mostrar/ocultar el campo de max según el tipo
    const selectTipo = div.querySelector('.tipo-caracteristica');
    const inputMax = div.querySelector('.max-caracteres');
    selectTipo.addEventListener('change', function() {
        if (this.value === 'string') {
            inputMax.style.display = '';
            inputMax.required = true;
        } else {
            inputMax.style.display = 'none';
            inputMax.value = '';
            inputMax.required = false;
        }
    });

    if (puedeEliminar) {
        div.querySelector('.btn-eliminar-caracteristicas').addEventListener('click', () => {
            div.parentNode.removeChild(div);
            modificarContador--;
            modificarBtnAgregar.disabled = false;
        });
    }

    return div;
}

let modificarContador = 0;
const modificarMaxCaracteristicas = 5;
let modificarBtnAgregar = null;

// Abrir modal de modificar y cargar datos
$(document).on('click', '.btn-modificar', function () {
    const id = $(this).data('id');
    $('#modificar_id_categoria').val(id);
    $('#smnombre_categoria').text('');

    // AJAX para obtener datos de la categoría y sus características
    const datos = new FormData();
    datos.append('accion', 'obtener_categoria');
    datos.append('id_categoria', id);

    $.ajax({
        url: '',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (categoria) {
            $('#modificar_nombre_categoria').val(categoria.nombre_categoria);

            // Limpiar y cargar características
            const contenedor = document.getElementById('modificar_caracteristicasContainer');
            contenedor.innerHTML = '';
            modificarContador = 0;

            // Si tu backend retorna un array de características, úsalo aquí
            if (categoria.caracteristicas && Array.isArray(categoria.caracteristicas)) {
                categoria.caracteristicas.forEach((carac, idx) => {
                    const puedeEliminar = idx !== 0;
                    contenedor.appendChild(crearInputCaracteristicaMod(modificarContador++, carac.nombre, carac.tipo, carac.max, puedeEliminar));
                });
            } else {
                // Si no hay características, agrega una vacía no eliminable
                contenedor.appendChild(crearInputCaracteristicaMod(modificarContador++, '', '', '', false));
            }

            // Habilitar o deshabilitar el botón de agregar
            modificarBtnAgregar = document.getElementById('modificar_agregarCaracteristica');
            modificarBtnAgregar.disabled = modificarContador >= modificarMaxCaracteristicas;

            $('#modificarCategoriaModal').modal('show');
        },
        error: function () {
            Swal.fire('Error', 'No se pudo obtener la categoría.', 'error');
        }
    });
});

// Agregar característica en el modal de modificar
$(document).on('click', '#modificar_agregarCaracteristica', function () {
    const contenedor = document.getElementById('modificar_caracteristicasContainer');
    if (modificarContador < modificarMaxCaracteristicas) {
        contenedor.appendChild(crearInputCaracteristicaMod(modificarContador++));
        if (modificarContador === modificarMaxCaracteristicas) {
            this.disabled = true;
        }
    }
});

// Enviar modificación por AJAX
$('#modificarCategoria').on('submit', function (e) {
    e.preventDefault();

    // Validación similar a la de registrar
    let validacionCorrecta = true;
    let mensajeError = '';
    const regexNombre = /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ]+(?: [a-zA-ZÁÉÍÓÚñÑáéíóúüÜ]+)*$/;

    $('#modificar_caracteristicasContainer .caracteristica-item').each(function(index, item) {
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
        
        
       if (tipo.val() === 'string') {
    if ($.trim(max.val()) === '' || parseInt(max.val()) <= 0) {
        mensajeError = 'El campo "Máx. caracteres" debe ser mayor a 0.';
        max.focus();
        validacionCorrecta = false;
        return false;
    }
}
    });

    if (!validacionCorrecta) {
        Swal.fire('Error de validación', mensajeError, 'error');
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
                    text: 'La categoría se ha modificado correctamente'
                });

                    const tabla = $("#tablaConsultas").DataTable();
                    const id = $("#modificar_id_categoria").val();
                    const fila = tabla.row(`tr[data-id="${id}"]`);
                    const categoria = response.categoria;

                    if (fila.length) {
                        fila.data([
                            `<ul>
                                <div>
                                    <button class="btn-modificar"
                                        id="btnModificarCategoria"
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
                            </ul>`,
                            `<span class="campo-numeros">${categoria.id_categoria}</span>`,
                            `<span class="campo-nombres">${categoria.nombre_categoria}</span>`
                        ]).draw(false);

                        const filaNode = fila.node();
                        const botonModificar = $(filaNode).find(".btn-modificar");
                        botonModificar.data('nombre', categoria.nombre_categoria);
                    }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No se pudo modificar la categoría'
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error', 'Error al modificar la categoría.', 'error');
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
