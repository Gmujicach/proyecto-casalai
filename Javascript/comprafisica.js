$(document).ready(function () {
    // Inicialización de Select2 para el select de clientes (eliminé la duplicación)
    if ($(".select2-cliente").length > 0) {
        $(".select2-cliente").select2({
            placeholder: "Buscar cliente por nombre o cédula",
            allowClear: true,
            language: {
                noResults: function () {
                    return "No se encontraron clientes";
                },
            },
            matcher: function (params, data) {
                if ($.trim(params.term) === "") {
                    return data;
                }
                if (typeof data.text === "undefined") {
                    return null;
                }
                if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
                    return data;
                }
                if (
                    $(data.element).data("cedula") &&
                    $(data.element).data("cedula").toString().indexOf(params.term) > -1
                ) {
                    return data;
                }
                return null;
            },
        });
    }

    
    
    // Evento click para el botón de incluir despacho
    $("#btnIncluirDespacho").on("click", function () {
        $("#f")[0].reset();
        $("#scorrelativo").text("");
        $("#registrarCompraFisicaModal").modal("show");
    });

    // Eventos para cerrar modales
    $(document).on("click", "#registrarCompraFisicaModal .close", function () {
        $("#registrarCompraFisicaModal").modal("hide");
    });

    $(document).on("click", "#modalp .close-2", function () {
        $("#modalp").modal("hide");
    });

    // Carga inicial de productos
    carga_productos();

    // Evento click para mostrar el modal de productos
    $("#listado").on("click", function () {
        $("#modalp").modal("show");
    });

    // Validación del campo correlativo
    $("#correlativo").on("keypress", function (e) {
        validarkeypress(/^[0-9-\b]*$/, e);
    });

    $("#correlativo").on("keyup", function () {
        validarkeyup(
            /^[0-9]{4,10}$/,
            $(this),
            $("#scorrelativo"),
            "Se permite de 4 a 10 carácteres"
        );
        if ($("#correlativo").val().length <= 9) {
            var datos = new FormData();
            datos.append("accion", "buscar");
            datos.append("correlativo", $(this).val());
            enviaAjax(datos);
        }
    });

    // Validación del campo descripción
    $("#descripcion").on("keypress", function (e) {
        validarkeypress(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]*$/, e);
    });

    $("#descripcion").on("keyup", function () {
        validarkeyup(
            /^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{1,200}$/,
            $(this),
            $("#sdescripcion"),
            "No debe estar vacío y se permite un máximo 200 carácteres"
        );
    });

    // Evento keyup para buscar producto por código
    $("#codigoproducto").on("keyup", function () {
        var codigo = $(this).val();
        $("#listadop tr").each(function () {
            if (codigo == $(this).find("td:eq(1)").text()) {
                colocaproducto($(this));
            }
        });
    });

    // Función para filtrar clientes
    $("#buscarCliente").on("keyup", function () {
        var searchText = $(this).val().toLowerCase();

        $("#cliente option").each(function () {
            var optionText = $(this).text().toLowerCase();
            var matches = optionText.includes(searchText);
            $(this).toggle(matches);
        });

        // Mostrar el placeholder si está vacío
        if (searchText === "") {
            $('#cliente option[value="disabled"]').show();
        } else {
            $('#cliente option[value="disabled"]').hide();
        }
    });

    // Asegurar que el placeholder sea seleccionable
    $("#cliente").on("change", function () {
        if ($(this).val() === "disabled") {
            $(this).val("");
        }
    });

    // Evento click para el botón registrar
    $("#registrar").on("click", function () {
        if (validarFormularioRegistro()) {
            if (verificaproductos()) {
                $("#accion").val("registrar");
                var datos = new FormData($("#f")[0]);

                $("#proveedor").change(function () {
                    var valor = $(this).val();
                    datos.append("proveedor", valor);
                });
                datos.append("descripcion", $("#descripcion").val());

                enviaAjax(datos);
            } else {
                muestraMensaje("info", 4000, "Debe colocar algun producto");
            }
        }
    });

    // Función para verificar permisos en tiempo real
    function verificarPermisosEnTiempoRealRecepcion() {
        var datos = new FormData();
        datos.append("accion", "permisos_tiempo_real");
        enviarAjax(datos, function (permisos) {
            if (!permisos.consultar) {
                $("#tablaConsultas").hide();
                $(".space-btn-incluir").hide();
                if ($("#mensaje-permiso").length === 0) {
                    $(".contenedor-tabla").prepend(
                        '<div id="mensaje-permiso" style="color:red; text-align:center; margin:20px 0;">No tiene permiso para consultar los registros.</div>'
                    );
                }
                return;
            } else {
                $("#tablaConsultas").show();
                $(".space-btn-incluir").show();
                $("#mensaje-permiso").remove();
            }

            if (permisos.incluir) {
                $("#btnIncluirDespacho").show();
            } else {
                $("#btnIncluirDespacho").hide();
            }

            $(".btn-modificar").each(function () {
                if (permisos.modificar) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $(".btn-eliminar").each(function () {
                if (permisos.eliminar) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            if (!permisos.modificar && !permisos.eliminar) {
                $("#tablaConsultas th:first-child, #tablaConsultas td:first-child").hide();
            } else {
                $("#tablaConsultas th:first-child, #tablaConsultas td:first-child").show();
            }
        });
    }

    // Verificar permisos al cargar y cada 10 segundos
    verificarPermisosEnTiempoRealRecepcion();
    setInterval(verificarPermisosEnTiempoRealRecepcion, 10000);

    // Manejo de los métodos de pago
    $(document).on('change', 'input[name="metodo_pago"]', function() {
        // Ocultar todos los campos primero
        $('.metodo-campos').removeClass('active');
        
        // Mostrar solo los campos del método seleccionado
        const metodo = $(this).val();
        $(`#campos-${metodo}`).addClass('active');
    });

    // Calcular cambio para efectivo
    $(document).on('input', '#monto_efectivo', function() {
        const montoRecibido = parseFloat($(this).val()) || 0;
        const totalCompra = parseFloat($('#totalCompra').val().replace('Bs. ', '')) || 0;
        const cambio = montoRecibido - totalCompra;
        
        $('#cambio_efectivo').val(cambio.toFixed(2));
    });

    // Ocultar todos los campos de métodos de pago al cargar
    $('.metodo-campos').removeClass('active');

    // Evento para calcular total cuando cambia la cantidad de productos
    $(document).on('input change', 'input[name="cantidad[]"]', function() {
    calcularTotal();
});

    // Función para enviar AJAX
    function enviarAjax(datos, callback) {
        $.ajax({
            async: true,
            url: "",
            type: "POST",
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
                Swal.fire("Error", "Error en la solicitud AJAX", "error");
            },
        });
    }

    // Función para validar el envío del formulario
function validarFormularioRegistro() {
    let formValido = true;
    let mensajesError = [];

    // 📌 1. Validar campos obligatorios básicos
    const camposRequeridos = [
        {id: 'correlativo', nombre: 'Correlativo'},
        {id: 'cliente', nombre: 'Cliente'}
    ];

    camposRequeridos.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (!elemento || !elemento.value.trim()) {
            mensajesError.push(`El campo "${campo.nombre}" es obligatorio.`);
            formValido = false;
        }
    });

    // 📌 2. Validar que hay al menos un producto en la tabla
    const filasProductos = document.querySelectorAll("#recepcion1 tr");
    if (filasProductos.length === 0) {
        mensajesError.push("Debe agregar al menos un producto a la compra.");
        formValido = false;
    }

    // 📌 3. Validar pagos (similar a la función original)
    let montoTotal = parseFloat(document.querySelector("#monto_total").value) || 0;
    let montoPagado = 0;
    let pagoCompleto = false;

    document.querySelectorAll(".bloque-pago").forEach((bloque, idx) => {
        const tipo = bloque.querySelector(`.tipo-pago`)?.value.trim();
        const cuenta = bloque.querySelector(`.cuenta-pago`)?.value.trim();
        const referencia = bloque.querySelector(`input[name="pagos[${idx}][referencia]`)?.value.trim();
        const monto = parseFloat(bloque.querySelector(`input[name="pagos[${idx}][monto]"]`)?.value) || 0;
        const comprobante = bloque.querySelector(`input[name="pagos[${idx}][comprobante]`);

        // Validar campos según tipo de pago
        if (tipo) {
            if (!cuenta) {
                mensajesError.push(`En el pago ${idx + 1}: Debe seleccionar una cuenta.`);
                formValido = false;
            }

            if (monto <= 0) {
                mensajesError.push(`En el pago ${idx + 1}: El monto debe ser mayor que 0.`);
                formValido = false;
            }

            if ((tipo === "Pago Movil" || tipo === "Transferencia") && !referencia) {
                mensajesError.push(`En el pago ${idx + 1}: La referencia es obligatoria para ${tipo}.`);
                formValido = false;
            }

            if (tipo === "Pago Movil" && comprobante && !comprobante.files[0]) {
                mensajesError.push(`En el pago ${idx + 1}: El comprobante es obligatorio para Pago Móvil.`);
                formValido = false;
            }

            montoPagado += monto;
            
            if (tipo && cuenta && monto > 0 && (tipo !== "Pago Movil" || comprobante?.files[0])) {
                if (tipo === "Pago Movil" || tipo === "Transferencia") {
                    if (referencia) pagoCompleto = true;
                } else {
                    pagoCompleto = true;
                }
            }
        }
    });

    // 📌 4. Validar que monto pagado sea igual o mayor al monto total
    if (montoPagado < montoTotal) {
        mensajesError.push(`El monto pagado (${montoPagado.toFixed(2)}) no puede ser menor al monto total (${montoTotal.toFixed(2)}).`);
        formValido = false;
    }

    // 📌 5. Validar que exista al menos un pago completo
    if (!pagoCompleto) {
        mensajesError.push("Debe existir al menos un pago completo con todos sus campos llenos.");
        formValido = false;
    }

    // 📌 6. Mostrar mensajes y cancelar envío si hay errores
    if (!formValido) {
        Swal.fire({
            icon: "error",
            title: "Validación fallida",
            html: mensajesError.join("<br>"),
            confirmButtonText: "Corregir"
        });
    }

    return formValido;
}


    // Función para cargar productos
    function carga_productos() {
        var datos = new FormData();
        datos.append("accion", "listado");
        enviaAjax(datos);
    }

    // Función para verificar si hay productos seleccionados
    function verificaproductos() {
        var existe = false;
        if ($("#recepcion1 tr").length > 0) {
            existe = true;
        }
        return existe;
    }

    // Función para calcular el total de la compra
    function calcularTotal() {
    let total = 0;
    let hasProducts = false;
    
    $('#recepcion1 tr').each(function() {
        const idProducto = $(this).find('input[name="producto[]"]').val();
        const cantidad = parseFloat($(this).find('input[name="cantidad[]"]').val()) || 0;
        
        if (idProducto) {
            const producto = productosDisponibles.find(p => p.id_producto == idProducto);
            if (producto && producto.precio) {
                total += parseFloat(producto.precio) * cantidad;
                hasProducts = true;
            }
        }
    });
    
    if (hasProducts) {
        $('#totalCompra').val('Bs. ' + total.toFixed(2));
    } else {
        $('#totalCompra').val('Bs. 0.00');
    }
}

    // Función para limpiar el formulario
    function borrar() {
        $("#correlativo").val("");
        $("#proveedor").val("disabled");
        $("#recepcion1 tr").remove();
        $("#descripcion").val("");
    }

    // Función para mostrar mensajes
    function muestraMensaje(
        tipo = "success",
        tiempo = 4000,
        titulo = "",
        mensaje = ""
    ) {
        Swal.fire({
            icon: tipo,
            title: titulo,
            text: mensaje,
            timer: tiempo,
            showConfirmButton: false,
        });
    }

    // Función para validar por Keypress
    function validarkeypress(er, e) {
        key = e.keyCode;
        tecla = String.fromCharCode(key);
        a = er.test(tecla);

        if (!a) {
            e.preventDefault();
        }
    }

    // Función para validar por keyup
    function validarkeyup(er, etiqueta, etiquetamensaje, mensaje) {
        a = er.test(etiqueta.val());

        if (a) {
            etiquetamensaje.text("");
            return 1;
        } else {
            etiquetamensaje.text(mensaje);
            return 0;
        }
    }

    // Función para enviar AJAX
    function enviaAjax(datos) {
        $.ajax({
            async: true,
            url: "",
            type: "POST",
            contentType: false,
            data: datos,
            processData: false,
            cache: false,
            beforeSend: function () {
                // Mostrar loader si es necesario
            },
            timeout: 10000,
            success: function (respuesta) {
                console.log(respuesta);
                try {
                    var lee = JSON.parse(respuesta);
                    console.log(lee.resultado);

                    if (lee.resultado == "listado") {
                        $("#listadop").html(lee.mensaje);
                        $("#modalp .modal-dialog")
                            .removeClass("modal-md modal-lg modal-xl")
                            .addClass(lee.modalSize);
                    } else if (lee.resultado == "registrar") {
                        muestraMensaje("success", 6000, "REGISTRAR", lee.mensaje);
                        resetModalCompraFisica();
                    } else if (lee.resultado == "encontro") {
                        if (lee.mensaje == "Este correlativo ya existe, por favor, ingrese otro") {
                            muestraMensaje("error", 6000, "Atencion", lee.mensaje);
                        }
                    } else if (lee.resultado == "error") {
                        muestraMensaje("success", 6000, "Error", lee.mensaje);
                    }
                } catch (e) {
                    console.log("Error en JSON " + e.name + " !!!");
                }
            },
            complete: function () {
                // Ocultar loader si es necesario
            },
        });
    }
});
function resetModalCompraFisica() {
    // 1️⃣ Cerrar modal
    $('#registrarCompraFisicaModal').modal('hide');

    // 2️⃣ Resetear formulario
    const $form = $('#f');
    $form[0].reset();

    // 3️⃣ Resetear Select2 si lo usas
    if ($('#cliente').hasClass("select2-hidden-accessible")) {
        $('#cliente').val(null).trigger('change');
    }

    // 4️⃣ Limpiar tabla de productos
    $('#recepcion1').empty();

    // 5️⃣ Reiniciar totales
    $('#monto_total').val('0.00');
    $('#cambio_efectivo').val('0.00');
    $('#totalCompra').val('');

    // 6️⃣ Limpiar pagos dinámicos y volver a crear el primer bloque
    $('#pagos-container').empty();
    pagosCount = 0; // Reiniciamos contador
    agregarPagoBloque();

    // 7️⃣ Remover mensajes de error o validaciones
    $('#scorrelativo').text('');

    console.log("Modal de Compra Física reseteado correctamente");
}

// Función para colocar productos en la tabla
function colocaproducto(linea) {
    var id = $(linea).find("td:eq(0)").text();
    var encontro = false;

    $("#recepcion1 tr").each(function () {
        if (id * 1 == $(this).find("td:eq(1)").text() * 1) {
            encontro = true;
            var t = $(this).find("td:eq(4)").children();
            t.val(t.val() * 1 + 1);
            calcularTotal(); // Actualizar total cuando aumenta cantidad
        }
    });

    if (!encontro) {
        var l = `
            <tr>
            <td>
            <button type="button" class="btn-eliminar-pr" onclick="borrarp(this)">Eliminar</button>
            </td>
            <td style="display:none">
                <input type="text" name="producto[]" style="display:none"
                value="` +
    $(linea).find("td:eq(0)").text() +
    `"/>` +
    $(linea).find("td:eq(0)").text() +
    `</td>
            <td>` +
    $(linea).find("td:eq(1)").text() +
    `</td>
            <td>` +
    $(linea).find("td:eq(2)").text() +
    `</td>
            <td>` +
    $(linea).find("td:eq(3)").text() +
    `</td>
                <td>` +
    $(linea).find("td:eq(4)").text() +
    `</td>
            <td>` +
    $(linea).find("td:eq(5)").text() +
    `</td>
                <td>` +
    $(linea).find("td:eq(6)").text() +
    `</td>
                <td>
                    <input type="number" class="numerico" name="cantidad[]" min="1" step="1" value="1" required>
                </td>
            </tr>`;
    $("#recepcion1").append(l);
    calcularTotal();
}
}
//fin de funcion modifica subtotal
// Calcula el monto total cada vez que se agregue/elimine/modifique cantidad de productos
function calcularTotal() {
    let total = 0;
    $("#recepcion1 tr").each(function () {
        const precio = parseFloat($(this).find("td:eq(7)").text()) || 0;
        const cantidad = parseFloat($(this).find('input[name="cantidad[]"]').val()) || 0;
        total += precio * cantidad;
    });
    $("#monto_total").val(total.toFixed(2));
    return total;
}

// Recalcula el total al modificar productos/cantidades
$(document).on('input', 'input[name="cantidad[]"]', calcularTotal);
$(document).on('DOMNodeInserted DOMNodeRemoved', '#recepcion1', calcularTotal);

// Calcula el cambio cuando el usuario ingresa el monto recibido en efectivo
$(document).on('change', 'input[id^="monto_"]', function() {
    // Solo si es efectivo
    if ($(this).attr('id').includes('efectivo')) {
        const montoRecibido = parseFloat($(this).val()) || 0;
        const total = parseFloat($("#monto_total").val()) || 0;
        const cambio = montoRecibido - total;
        $("#cambio_efectivo").val(cambio.toFixed(2));
    }
});
// Calcula el cambio considerando todos los pagos realizados
function calcularCambio() {
    const montoTotal = parseFloat($("#monto_total").val()) || 0;
    let sumaPagos = 0;
    // Suma todos los montos ingresados en los bloques de pago
    $('input[name^="pagos"][name$="[monto]"]').each(function() {
        sumaPagos += parseFloat($(this).val()) || 0;
    });
    const cambio = sumaPagos - montoTotal;
    $("#cambio_efectivo").val(cambio > 0 ? cambio.toFixed(2) : "0.00");
}

// Recalcula el cambio cada vez que se modifica un monto en cualquier pago
$(document).on('input', 'input[name^="pagos"][name$="[monto]"]', calcularCambio);

// También recalcula el cambio cuando se agrega o elimina un bloque de pago
$(document).on('DOMNodeInserted DOMNodeRemoved', '#pagos-container', calcularCambio);

// Recalcula el cambio cuando el monto total cambia
$(document).on('input', '#monto_total', calcularCambio);

// Inicializa el cambio al cargar
$(document).ready(function() {
    calcularCambio();
});
// Inicializa el total al cargar
$(document).ready(function() {
    calcularTotal();
});
//funcion para eliminar linea de detalle de ventas


    /**
     * Valida el formulario completo de compra antes de enviarlo
     * @returns {boolean} true si el formulario es válido, false si hay errores
     */
    function validarFormularioCompra() {
        // 1. Validar campos básicos obligatorios
        if (!validarCamposObligatorios()) {
            return false;
        }

        // 2. Validar que al menos hay un producto
        if ($('#recepcion1 tr').length === 0) {
            Swal.fire('Error', 'Debe agregar al menos un producto', 'error');
            return false;
        }

        // 3. Validar montos y pagos
        if (!validarMontosYPagos()) {
            return false;
        }

        // 4. Validar referencias numéricas
        if (!validarReferenciasNumericas()) {
            return false;
        }

        return true;
    }

    /**
     * Valida que todos los campos obligatorios estén completos
     */
    function validarCamposObligatorios() {
        const camposObligatorios = [
            { selector: '#correlativo', nombre: 'Correlativo' },
            { selector: '#cliente', nombre: 'Cliente' }
        ];

        for (const campo of camposObligatorios) {
            const valor = $(campo.selector).val().trim();
            if (!valor || valor === 'disabled') {
                Swal.fire('Error', `El campo ${campo.nombre} es obligatorio`, 'error');
                $(campo.selector).focus();
                return false;
            }
        }

        return true;
    }

    /**
     * Valida los montos y los pagos
     */
    function validarMontosYPagos() {
        // Obtener monto total de la compra
        const montoTotal = parseFloat($('#monto_total').val()) || 0;
        
        // Validar que el monto total sea mayor que 0
        if (montoTotal <= 0) {
            Swal.fire('Error', 'El monto total debe ser mayor a 0', 'error');
            return false;
        }

        // Validar cada bloque de pago
        let totalPagado = 0;
        let pagosValidos = 0;
        
        $('.bloque-pago').each(function(index) {
            const tipoPago = $(this).find('.tipo-pago').val();
            const cuenta = $(this).find('.cuenta-pago').val();
            const monto = parseFloat($(this).find('input[name$="[monto]"]').val()) || 0;
            
            // Validar que el pago esté completo
            if (tipoPago && cuenta && monto > 0) {
                // Validar que el monto no sea negativo
                if (monto < 0) {
                    Swal.fire('Error', `El monto en el pago ${index + 1} no puede ser negativo`, 'error');
                    $(this).find('input[name$="[monto]"]').focus();
                    return false;
                }
                
                // Validar referencias para transferencia/pago móvil
                if (tipoPago !== 'Efectivo') {
                    const referencia = $(this).find('input[name$="[referencia]"]').val().trim();
                    if (!referencia) {
                        Swal.fire('Error', `La referencia en el pago ${index + 1} es obligatoria`, 'error');
                        $(this).find('input[name$="[referencia]"]').focus();
                        return false;
                    }
                }
                
                totalPagado += monto;
                pagosValidos++;
            }
        });
        
        // Validar que haya al menos un pago completo
        if (pagosValidos === 0) {
            Swal.fire('Error', 'Debe registrar al menos un pago completo', 'error');
            return false;
        }
        
        // Validar que el total pagado sea suficiente
        if (totalPagado < montoTotal) {
            Swal.fire('Error', `El total pagado (${totalPagado.toFixed(2)}) es menor al monto total (${montoTotal.toFixed(2)})`, 'error');
            return false;
        }
        
        return true;
    }

    /**
     * Valida que las referencias solo contengan números
     */
    function validarReferenciasNumericas() {
        let esValido = true;
        
        $('input[name$="[referencia]"]').each(function() {
            const referencia = $(this).val().trim();
            if (referencia && !/^\d+$/.test(referencia)) {
                Swal.fire('Error', 'Las referencias de pago solo pueden contener números', 'error');
                $(this).focus();
                esValido = false;
                return false; // Salir del each
            }
        });
        
        return esValido;
    }

    /**
     * Configura validación para inputs numéricos (no negativos)
     */
    function configurarValidacionNumerosPositivos() {
        // Para inputs de tipo number
        $('input[type="number"]').on('input', function() {
            const value = parseFloat($(this).val());
            if (value < 0) {
                $(this).val(0);
            }
        });
        
        // Para inputs de texto que deben ser números
        $('input.numeric-positive').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9.]/g, ''));
            const value = parseFloat($(this).val());
            if (value < 0) {
                $(this).val(0);
            }
        });
    }
    
function borrarp(boton) {
    $(boton).closest("tr").remove();
    calcularTotal();
}