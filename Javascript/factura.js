$(document).ready(function () {
    carga_productos();

    // Botón para levantar modal de productos
    $("#listadodeproductos").on("click", function () {
        $("#modalproductos").modal("show");
    });

    // Evento keyup de input codigoproducto
    $("#codigoproducto").on("keyup", function () {
        var codigo = $(this).val();
        $("#listadoproductos tr").each(function () {
            if (codigo == $(this).find("td:eq(1)").text()) {
                colocaproducto($(this));
            }
        });
    });

    // Evento click de botón registrar
    $("#registrar").on("click", function () {
        var datos = new FormData($('#f')[0]);
        $('#cliente').change(function () {
            var valor = $(this).val();
            datos.append('cliente', valor);
        });
        datos.append('accion', 'registrar');
        enviaAjax(datos);
    });
});

function carga_productos() {
    var datos = new FormData();
    datos.append('accion', 'listadoproductos');
    enviaAjax(datos);
}

// Función para colocar los productos
function colocaproducto(linea) {
    var id = $(linea).find("td:eq(0)").text();
    var encontro = false;
    var stockDisponible = parseInt($(linea).find("td:eq(4)").text()) || 1; // Obtener el stock

    $("#detalle_factura tr").each(function () {
        if (id * 1 == $(this).find("td:eq(1)").text() * 1) {
            encontro = true;
            let cantidadInput = $(this).find("td:eq(6)").find("input");
            let nuevaCantidad = parseInt(cantidadInput.val()) + 1;

            if (nuevaCantidad > stockDisponible) {
                alert("No puedes agregar más de la cantidad disponible.");
            } else {
                cantidadInput.val(nuevaCantidad);
                actualizarFila(cantidadInput[0]);
            }
        }
    });

    if (!encontro) {
        let cantidad = 1;
        let precio = parseFloat($(linea).find("td:eq(5)").text().replace("$", ""));
        let subtotal = cantidad * precio;

        let fila = `
          <tr>
            <td>
                <button type="button" class="btn btn-primary" onclick="eliminalineadetalle(this)">X</button>
            </td>
            <td style="display:none">
                <input type="text" name="idp[]" style="display:none" value="${id}"/>${id}
            </td>
            <td>${$(linea).find("td:eq(1)").text()}</td>
            <td>${$(linea).find("td:eq(2)").text()}</td>
            <td>${$(linea).find("td:eq(3)").text()}</td>
            <td>${stockDisponible}</td>
            <td>
                <div class="cantidad-control">
                    <button type="button" onclick="cambiarCantidad(this, -1)">-</button>
                    <input type="number" value="1" min="1" max="${stockDisponible}" step="1" name="cant[]" oninput="validarCantidad(this)" readonly/>
                    <button type="button" onclick="cambiarCantidad(this, 1)">+</button>
                </div>
            </td>
            <td>${precio.toFixed(2)} $</td>
            <td class="subtotal">${subtotal.toFixed(2)} $</td>
          </tr>`;

        $("#detalle_factura").append(fila);
        actualizarSubtotal();
    }
}

// Función para eliminar una fila y actualizar el total
function eliminalineadetalle(boton) {
    $(boton).closest("tr").remove();
    actualizarSubtotal();
}

// Función para validar la cantidad
function validarCantidad(input) {
    let fila = $(input).closest("tr");
    let stockMaximo = parseInt(fila.find("td:eq(5)").text()) || 1;

    if (input.value < 1 || isNaN(input.value)) {
        input.value = 1;
    } else if (input.value > stockMaximo) {
        alert("No puedes seleccionar más de la cantidad disponible.");
        input.value = stockMaximo;
    }
    actualizarFila(input);
}

// Función para cambiar la cantidad usando los botones + y -
function cambiarCantidad(boton, cambio) {
    let input = $(boton).siblings("input");
    let fila = $(input).closest("tr");
    let stockMaximo = parseInt(fila.find("td:eq(5)").text()) || 1;
    let nuevaCantidad = parseInt(input.val()) + cambio;

    if (nuevaCantidad < 1) {
        nuevaCantidad = 1;
    } else if (nuevaCantidad > stockMaximo) {
        alert("No puedes seleccionar más de la cantidad disponible.");
        nuevaCantidad = stockMaximo;
    }

    input.val(nuevaCantidad);
    actualizarFila(input[0]);
}

// Función para actualizar subtotal cuando cambia la cantidad
function actualizarFila(input) {
    let fila = $(input).closest("tr");
    let cantidad = parseInt($(input).val()) || 1;
    let precio = parseFloat(fila.find("td:eq(7)").text().replace("$", ""));
    let subtotal = cantidad * precio;

    fila.find(".subtotal").text(subtotal.toFixed(2) + " $");
    actualizarSubtotal();
}

// Función para calcular el total de los subtotales
function actualizarSubtotal() {
    let total = 0;
    $("#detalle_factura .subtotal").each(function () {
        total += parseFloat($(this).text().replace("$", "")) || 0;
    });

    $("#total_subtotal").text(total.toFixed(2) + " $");
}

// Función para enviar los datos por AJAX
function filtrarProductosPorStock() {
    // Recorrer todas las filas de la tabla
    $("#listadoproductos tr").each(function() {
        let stock = $(this).find("td:eq(4)").text().trim(); // Obtener el stock de la fila
        stock = parseInt(stock); // Convertir el stock a un número

        // Si el stock es menor o igual a 0, ocultamos la fila
        if (stock <= 0) {
            $(this).hide(); // Ocultamos la fila
        } else {
            $(this).show(); // Mostramos la fila
        }
    });
}

// Llamamos a esta función después de cargar los productos
function carga_productos() {
    var datos = new FormData();
    datos.append('accion', 'listadoproductos'); // Le decimos que me muestre un listado de productos
    enviaAjax(datos);
}

// Función para manejar la respuesta AJAX
function enviaAjax(datos) {
    $.ajax({
        async: true,
        url: '', // La URL se omite ya que estamos en la misma página
        type: 'POST', // Tipo de solicitud
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        timeout: 10000, // Tiempo máximo de espera por la respuesta del servidor
        success: function (respuesta) {
            console.log(respuesta);
            try {
                var lee = JSON.parse(respuesta);
                if (lee.resultado === 'listado') {
                    // Aquí llenamos la tabla con los productos recibidos
                    alert("Hola");
                    $('#listado').html(lee.mensaje);
                    // Luego filtramos los productos con stock > 0
                    filtrarProductosPorStock();
                } else if (lee.resultado === 'registrar') {
                    Swal.fire({
                        title: 'Factura registrada',
                        text: 'La factura se ha registrado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Cerrar'
                    });
                }
            } catch (e) {
                console.error("Error en análisis JSON:", e);
                alert("Error en JSON " + e.name + ": " + e.message);
            }
        },
        error: function (request, status, err) {
            muestraMensaje("ERROR: <br/>" + request + status + err);
        }
    });
}

document.getElementById('registrar').addEventListener('click', function (event) {
    // Obtén el contenido de la tabla de detalles de la factura
    var detalleFactura = document.getElementById('detalle_factura').getElementsByTagName('tr');

    // Verifica si hay filas en la tabla de detalles
    if (detalleFactura.length === 0) {
        // Muestra un mensaje de advertencia si no hay productos
        Swal.fire({
            title: 'Error',
            text: 'No hay productos registrados en la factura.',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });

        // Previene el envío del formulario
        event.preventDefault();
    }
});

document.getElementById("f").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío automático del formulario

    let productos = [];
    let filas = document.querySelectorAll("#detalle_factura tr");

    filas.forEach(fila => {
        let producto = {
            id: fila.cells[1].textContent.trim(), // ID del producto (celda oculta)
            producto: fila.cells[2].textContent.trim(),
            modelo: fila.cells[3].textContent.trim(),
            marca: fila.cells[4].textContent.trim(),
            stock: fila.cells[5].textContent.trim(),
            cantidad: fila.cells[6].querySelector("input").value, // Obtener cantidad ingresada
            precio: fila.cells[7].textContent.trim(),
            subtotal: fila.cells[8].textContent.trim()
        };
        productos.push(producto);
    });

    document.getElementById("detalle_factura_input").value = JSON.stringify(productos);
    
    // Ahora sí enviamos el formulario
    this.submit();
});
