$(document).ready(function () {

    // MENSAJE //
    if($.trim($("#mensajes").text()) != ""){
        mensajes("warning", 4000, "Atención", $("#mensajes").html());
    }

    $("#nombre").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre");
        nombre.value = space(nombre.value);
    });

    $("#nombre").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,100}$/,
            $(this),
            $("#snombre"),
            "*El formato solo permite letras*"
        );
    });

    $("#cedula").on("keypress", function(e){
        validarKeyPress(/^[VEJPG0-9-.\b]*$/, e);
    });

    $("#cedula").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG0-9-.\b]{6,12}$/,
            $(this),
            $("#scedula"),
            "*El formato solo permite números y (V,E,J,P,G,-.)*"
        );
    });

    // TELÉFONO
    $("#telefono").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });

    $("#telefono").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });

    $("#direccion").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let direccion = document.getElementById("direccion");
        direccion.value = space(direccion.value);
    });

    $("#direccion").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#sdireccion"),
            "*El formato permite letras y números*"
        );
    });

    $("#correo").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });

    $("#correo").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo"),
            "*Formato válido: example@gmail.com*"
        );
    });

    function validarEnvioCliente(){
        let nombre = document.getElementById("nombre");
        nombre.value = space(nombre.value).trim();

        let direccion = document.getElementById("direccion");
        direccion.value = space(direccion.value).trim();

        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,100}$/,
            $("#nombre"),
            $("#snombre"),
            "*El nombre debe tener solo letras*"
        )==0){
            mensajes('error',4000,'Verifique el nombre','Debe tener solo letras');
            return false;
        }
        else if(validarKeyUp(
            /^[VEJPG0-9-.\b]{6,12}$/,
            $("#cedula"),
            $("#scedula"),
            "*El formato solo permite números y (V,E,J,P,G,-.)*"
        )==0){
            mensajes('error',4000,'Verifique el número de cedula/RIF','El formato solo permite números y (V,E,J,P,G,-.)');
            return false;
        }
        else if(validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $("#telefono"),
            $("#stelefono"),
            "*Formato correcto: 04XX-XXX-XXXX*"
        )==0){
            mensajes('error',4000,'Verifique el teléfono','Debe tener 11 dígitos separados por "-"');
            return false;
        }
        if(validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $("#direccion"),
            $("#sdireccion"),
            "*Puede haber letras y números*"
        )==0){
            mensajes('error',4000,'Verifique la dirección','Debe tener solo letras y números');
            return false;
        }
        else if(validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $("#correo"),
            $("#scorreo"),
            "*Formato correcto: example@gmail.com*"
        )==0){
            mensajes('error',4000,'Verifique el correo','Correo no válido');
            return false;
        }
        return true;
    }

    function agregarFilaCliente(cliente) {
    // Verificar si DataTables está inicializado
    const tabla = $('#tablaConsultas').DataTable();
    
    // Crear la nueva fila como un array de datos (en el mismo orden que las columnas)
    const nuevaFila = [
        cliente.nombre,
        cliente.cedula,
        cliente.direccion,
        cliente.telefono,
        cliente.correo,
        `<div class="acciones-boton">
            <i class="vertical">
                <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
            </i>
            <div class="desplegable">
                <ul>
                    <li>
                        <button class="btn btn-primary btn-modificar"
                            data-id="${cliente.id_clientes}"
                            data-nombre="${cliente.nombre}"
                            data-cedula="${cliente.cedula}"
                            data-direccion="${cliente.direccion}"
                            data-telefono="${cliente.telefono}"
                            data-correo="${cliente.correo}">
                            Modificar
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-danger btn-eliminar"
                            data-id="${cliente.id_clientes}">
                            Eliminar
                        </button>
                    </li>
                </ul>
            </div>
        </div>`
    ];

    // Agregar la nueva fila al DataTable y redibujar
    tabla.row.add(nuevaFila).draw(false);
    
    // Opcional: ordenar por la columna 0 (nombre) de forma ascendente
    tabla.order([0, 'asc']).draw();
}
    // Resetear formulario
    function resetCliente() {
        $("#nombre").val('');
        $("#cedula").val('');
        $("#direccion").val('');
        $("#telefono").val('');
        $("#correo").val('');
        $("#snombre").text('');
        $("#scedula").text('');
        $("#sdireccion").text('');
        $("#stelefono").text('');
        $("#scorreo").text('');
    }

    // Enviar formulario de registro por AJAX
    $('#ingresarclientes').on('submit', function(e) {
    e.preventDefault();

    if(validarEnvioCliente()){
        var datos = new FormData(this);
        datos.append('accion', 'registrar');
        
        $.ajax({
            url: '',
            type: 'POST',
            data: datos,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta){
                if(respuesta.status === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.message || 'Cliente registrado correctamente'
                    }).then(() => {
                        // Agregar la nueva fila a DataTables
                        if(respuesta.cliente) {
                            agregarFilaCliente(respuesta.cliente);
                        }
                        resetCliente();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.message || 'Error al registrar el cliente'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Ocurrió un error al comunicarse con el servidor'
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

    // Cargar datos del clientes en el modal al abrir
        $(document).on('click', '.btn-modificar', function () {
        $('#modificar_id_clientes').val($(this).data('id'));
        $('#modificarnombre').val($(this).data('nombre'));
        $('#modificarcedula').val($(this).data('cedula'));
        $('#modificardireccion').val($(this).data('direccion'));
        $('#modificartelefono').val($(this).data('telefono'));
        $('#modificarcorreo').val($(this).data('correo'));
        $('#smodificarnombre').text('');
        $('#smodificarcedula').text('');
        $('#smodificardireccion').text('');
        $('#smodificartelefono').text('');
        $('#smodificarcorreo').text('');
        $('#modificar_clientes_modal').modal('show');
    });

    $("#modificarnombre").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]*$/, e);
        let nombre = document.getElementById("nombre");
        nombre.value = space(nombre.value);
    });

    $("#modificarnombre").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,100}$/,
            $(this),
            $("#smodificarnombre"),
            "*El formato solo permite letras*"
        );
    });

    $("#modificarcedula").on("keypress", function(e){
        validarKeyPress(/^[VEJPG0-9-.\b]*$/, e);
    });

    $("#modificarcedula").on("keyup", function(){
        validarKeyUp(
            /^[VEJPG0-9-.\b]{6,12}$/,
            $(this),
            $("#smodificarcedula"),
            "*El formato solo permite números y (V,E,J,P,G,-.)*"
        );
    });

    // TELÉFONO
    $("#modificartelefono").on("keypress", function(e){
        validarKeyPress(/^[0-9-]*$/, e);
    });

    $("#modificartelefono").on("keyup", function(){
        validarKeyUp(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#smodificartelefono"),
            "*Formato válido: 04XX-XXX-XXXX*"
        );
    });

    $("#modificardireccion").on("keypress", function(e){
        validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
        let direccion = document.getElementById("direccion");
        direccion.value = space(direccion.value);
    });

    $("#modificardireccion").on("keyup", function(){
        validarKeyUp(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
            $(this),
            $("#smodificardireccion"),
            "*El formato permite letras y números*"
        );
    });

    $("#modificarcorreo").on("keypress", function (e) {
        validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
    });

    $("#modificarcorreo").on("keyup", function(){
        validarKeyUp(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#smodificarcorreo"),
            "*Formato válido: example@gmail.com*"
        );
    });

    function validarCliente(datos) {
        let errores = [];
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s\b]{2,100}$/.test(datos.nombre)) {
            errores.push("El nombre debe tener solo letras.");
        }
        if (!/^[VEJPG0-9-.\b]*$/.test(datos.cedula)) {
            errores.push("El formato solo permite números y (V,E,J,P,G,-.)");
        }
        if (!/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/.test(datos.direccion)) {
            errores.push("El formato permite letras y números.");
        }
        if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono)) {
            errores.push("Formato correcto: 04XX-XXX-XXXX.");
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo)) {
            errores.push("Formato correcto: example@gmail.com.");
        }
        return errores;
    }

    // Enviar datos de modificación por AJAX al controlador PHP
    $('#modificarclientes').on('submit', function(e) {
        e.preventDefault();

        const datos = {
            nombre: $('#modificarnombre').val(),
            cedula: $('#modificarcedula').val(),
            direccion: $('#modificardireccion').val(),
            telefono: $('#modificartelefono').val(),
            correo: $('#modificarcorreo').val()
        }

        const errores = validarCliente(datos);

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
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            dataType: 'json', // <-- Asegúrate de esto
            success: function(response) {
                if (response.status === 'success') {
                    $('#modificar_clientes_modal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Modificado',
                        text: 'El Cliente se ha modificado correctamente'
                    });

                    const id = $('#modificar_id_clientes').val();
                    const nombre = $('#modificarnombre').val();
                    const cedula = $('#modificarcedula').val();
                    const direccion = $('#modificardireccion').val();
                    const telefono = $('#modificartelefono').val();
                    const correo = $('#modificarcorreo').val();

                    const fila = $('tr[data-id="' + id + '"]');
                    fila.find('td').eq(0).text(nombre);
                    fila.find('td').eq(1).text(cedula);
                    fila.find('td').eq(2).text(direccion);
                    fila.find('td').eq(3).text(telefono);
                    fila.find('td').eq(4).text(correo);

                    const botonModificar = fila.find('.btn-modificar');
                    botonModificar.data('nombre', nombre);
                    botonModificar.data('cedula', cedula);
                    botonModificar.data('direccion', direccion);
                    botonModificar.data('telefono', telefono);
                    botonModificar.data('correo', correo);
                } else {
                    muestraMensaje(response.message || 'No se pudo modificar el cliente');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                muestraMensaje('Error al modificar el Cliente.');
            }
        });
    });

    // Cerrar modal de modificación
    $(document).on('click', '#modificar_clientes_modal .close', function() {
        $('#modificar_clientes_modal').modal('hide');
    });

    // Función para eliminar el producto
    $(document).on('click', '.btn-eliminar', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    
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
            datos.append('id_clientes', id); // Cambiado de 'id' a 'id_clientes'
            
            $.ajax({
                url: '',
                type: 'POST',
                data: datos,
                processData: false,
                contentType: false,
                success: function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El cliente ha sido eliminado.',
                            'success'
                        );
                        eliminarFilaCliente(id);
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

    function eliminarFilaCliente(id_clientes) {
        const tabla = $('#tablaConsultas').DataTable();
        const fila = $(`#tablaConsultas tbody tr[data-id="${id_clientes}"]`);
        tabla.row(fila).remove().draw();
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

