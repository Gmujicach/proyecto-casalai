$(document).ready(function () {

    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre_marca").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]*$/, e);
        let nombre = document.getElementById("nombre_marca");
        nombre.value = space(nombre.value);
    });
    $("#nombre_marca").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,25}$/,
            $(this),
            $("#snombre_marca"),
            "*El formato permite letras y números*"
        );
    });

    function validarEnvioMarca(){
        let nombre = document.getElementById("nombre_marca");
        nombre.value = space(nombre.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9\s\b]{2,25}$/,
            $("#nombre_marca"),
            $("#snombre_marca"),
            "*El nombre debe tener letras y/o números*"
        )==0){
            mensajes('error',4000,'Verifique el nombre de la marca','Debe tener letras y/o números');
            return false;
        }
        return true;
    }

    function agregarFilaMarca(marca) {
        const tabla = $('#tablaConsultas').DataTable();
        const nuevaFila = [
            `<ul>
                <div>
                    <button class="btn-modificar"
                        id="btnModificarMarca"
                        data-id="${marca.id_marca}"
                        data-nombre="${marca.nombre_marca}">
                        Modificar
                    </button>
                </div>
                <div>
                    <button class="btn-eliminar"
                        data-id="${marca.id_marca}">
                        Eliminar
                    </button>
                </div>
            </ul>`,
            `<span class="campo-numeros">${marca.id_marca}</span>`,
            `<span class="campo-nombres">${marca.nombre_marca}</span>`
        ];
        const rowNode = tabla.row.add(nuevaFila).draw(false).node();
        $(rowNode).attr('data-id', marca.id_marca);
    }

    function resetMarca() {
        $("#nombre_marca").val('');
        $("#snombre_marca").text('');
    }

    $('#btnIncluirMarca').on('click', function() {
        $('#registrarMarca')[0].reset();
        $('#snombre_marca').text('');
        $('#registrarMarcaModal').modal('show');
    });

    $('#registrarMarca').on('submit', function(e) {
        e.preventDefault();
        if(validarEnvioMarca()){
            var datos = new FormData(this);
            datos.append('accion', 'registrar');
            enviarAjax(datos, function(respuesta){
                if(respuesta.status === "success" && respuesta.marca){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || 'Marca registrada correctamente'
                    });
                    agregarFilaMarca(respuesta.marca);
                    resetMarca();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || 'No se pudo registrar la marca'
                    });
                }
            });
        }
    });

    $(document).on('click', '#registrarMarcaModal .close', function() {
        $('#registrarMarcaModal').modal('hide');
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

    $("#modificar_nombre_marca").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9\s\b]*$/, e);
        let nombre = document.getElementById("modificar_nombre_marca");
        nombre.value = space(nombre.value);
    });
    $("#modificar_nombre_marca").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9\s\b]{2,25}$/,
            $(this),
            $("#smnombre_marca"),
            "*El formato permite letras y números*"
        );
    });

    function validarMarca(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ0-9\s\b]{2,25}$/.test(datos.nombre_marca)) {
            errores.push("El nombre debe tener letras y/o números.");
        }
        return errores;
    }

    $(document).on('click', '#btnModificarMarca', function () {
        $('#modificar_id_marca').val($(this).data('id'));
        $('#modificar_nombre_marca').val($(this).data('nombre'));
        $('#smnombre_marca').text('');
        $('#modificarMarcaModal').modal('show');
    });
    
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

                const tabla = $("#tablaConsultas").DataTable();
                const id = $("#modificar_id_marca").val();
                const fila = tabla.row(`tr[data-id="${id}"]`);
                const marca = response.marca;

                if (fila.length) {
                    fila.data([
                        `<ul>
                            <div>
                                <button class="btn-modificar"
                                    id="btnModificarMarca"
                                    data-id="${marca.id_marca}"
                                    data-nombre="${marca.nombre_marca}">
                                    Modificar
                                </button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                    data-id="${marca.id_marca}">
                                    Eliminar
                                </button>
                            </div>
                        </ul>`,
                        `<span class="campo-numeros">${marca.id_marca}</span>`,
                        `<span class="campo-nombres">${marca.nombre_marca}</span>`
                    ]).draw(false);

                    const filaNode = fila.node();
                    const botonModificar = $(filaNode).find(".btn-modificar");
                    botonModificar.data('nombre', marca.nombre_marca);
                }
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
        const tabla = $('#tablaConsultas').DataTable();
        const fila = $(`#tablaConsultas tbody tr[data-id="${id_marca}"]`);
        tabla.row(fila).remove().draw();
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