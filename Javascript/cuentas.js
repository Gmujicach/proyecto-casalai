$(document).ready(function () {

    // Validación para registro y modificación de cuentas
    function validarCuenta(datos) {
        let errores = [];

        // Validar nombre del banco
        if (!datos.nombre_banco || datos.nombre_banco.trim().length < 3) {
            errores.push("El nombre del banco es obligatorio y debe tener al menos 3 caracteres.");
        }

        // Validar número de cuenta (20 dígitos numéricos)
        if (!/^\d{20}$/.test(datos.numero_cuenta)) {
            errores.push("El número de cuenta debe tener exactamente 20 dígitos numéricos.");
        }

        // Validar RIF (ejemplo: J-12345678-9)
        if (!/^[VEJPG]-\d{8}-\d$/.test(datos.rif_cuenta)) {
            errores.push("El RIF debe tener el formato correcto (ej: J-12345678-9).");
        }

        // Validar teléfono (11 dígitos numéricos)
        if (!/^\d{11}$/.test(datos.telefono_cuenta)) {
            errores.push("El teléfono debe tener exactamente 11 dígitos numéricos.");
        }

        // Validar correo electrónico
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo_cuenta)) {
            errores.push("El correo electrónico no es válido.");
        }

        return errores;
    }

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
            cache: false,
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

    // Función para eliminar la cuenta
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
                enviarAjax(datos, function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire(
                            'Eliminada!',
                            'La Cuenta ha sido eliminada.',
                            'success'
                        );
                        eliminarFilaCuenta(id_cuenta);
                    } else {
                        muestraMensaje(respuesta.message);
                    }
                });
            }
        });
    });

    // Función para incluir una nueva cuenta
    $('#registrarCuenta').on('submit', function(event) {
        event.preventDefault();

        const datos = {
            nombre_banco: $('#nombre_banco').val(),
            numero_cuenta: $('#numero_cuenta').val(),
            rif_cuenta: $('#rif_cuenta').val(),
            telefono_cuenta: $('#telefono_cuenta').val(),
            correo_cuenta: $('#correo_cuenta').val()
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

        const formData = new FormData(this);
        formData.set('accion', 'registrar');

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
                            text: data.message || 'Cuenta ingresada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });

                        agregarFilaCuenta(data.cuenta);
                        document.getElementById('registrarCuenta').reset();
                    } else {
                        Swal.fire({
                            title: 'Error del servidor',
                            html: `<strong>Mensaje:</strong> ${data.message || 'Error al ingresar la cuenta'}<br>
                                <strong>Detalle:</strong> ${data.detail || 'No se proporcionó detalle adicional'}`,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error inesperado',
                        html: `<strong>Respuesta no válida del servidor.</strong><br><code>${response}</code>`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                    console.error('Respuesta no válida:', response);
                }
            },
            error: function(xhr, status, error) {
                let mensajeError = `Error en la solicitud AJAX: ${status} - ${error}`;

                if (xhr.responseText) {
                    mensajeError += `<br><strong>Respuesta del servidor:</strong><br><code>${xhr.responseText}</code>`;
                }

                Swal.fire({
                    title: 'Error en la conexión',
                    html: mensajeError,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });

                console.error('Detalles del error AJAX:', {
                    status: xhr.status,
                    responseText: xhr.responseText,
                    readyState: xhr.readyState,
                    errorThrown: error
                });
            }
        });
    });

    // Manejador de clic para cambiar el estado de la cuenta
    $(document).on('click', '.campo-estatus', function() {
        const id_cuenta = $(this).data('id');
        cambiarEstado(id_cuenta);
    });

    $(document).on('click', '.acciones-boton .vertical', function(e) {
        e.stopPropagation();
        const $acciones = $(this).closest('.acciones-boton');
        if ($acciones.hasClass('active')) {
            $acciones.removeClass('active');
        } else {
            $('.acciones-boton').removeClass('active');
            $acciones.addClass('active');
        }
    });

    // Cierra el menú si haces clic fuera
    $(document).on('click', function() {
        $('.acciones-boton').removeClass('active');
    });
});

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

// Función para actualizar una fila existente en la tabla
function actualizarFilaCuenta(cuenta) {
    const fila = $(`#tablaConsultas tbody tr[data-id="${cuenta.id_cuenta}"]`);
    fila.find('td:nth-child(2)').text(cuenta.nombre_banco);
    fila.find('td:nth-child(3)').text(cuenta.numero_cuenta);
    fila.find('td:nth-child(4)').text(cuenta.rif_cuenta);
    fila.find('td:nth-child(5)').text(cuenta.telefono_cuenta);
    fila.find('td:nth-child(6)').text(cuenta.correo_cuenta);
    fila.find('td:nth-child(7)').text(cuenta.estado);
}

// Función para eliminar una fila de la tabla
function eliminarFilaCuenta(id_cuenta) {
    $(`#tablaConsultas tbody tr[data-id="${id_cuenta}"]`).remove();
}

// Función genérica para enviar AJAX
function enviarAjax(datos, callback) {
    $.ajax({
        url: '',
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta) {
            callback(JSON.parse(respuesta));
        },
        error: function () {
            muestraMensaje('Error en la solicitud AJAX');
        }
    });
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
function muestraMensaje(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
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