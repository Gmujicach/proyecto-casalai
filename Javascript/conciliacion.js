$(document).ready(function () {
    let datosJSON = { datos: [] };

    // Cargar datos de cuentas en la tabla
    cargarCuentas();

    // Registrar nueva cuenta
    $("#formRegistrar").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'Controlador/conciliacion.php',
            data: {
                accion: 'registrar',
                nombre_banco: $("#nombre_banco").val(),
                numero_cuenta: $("#numero_cuenta").val(),
                rif_cuenta: $("#rif_cuenta").val(),
                telefono_cuenta: $("#telefono_cuenta").val(),
                correo_cuenta: $("#correo_cuenta").val(),
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Crear un nuevo objeto para la cuenta
                    var newCuenta = {
                        id_cuenta: result.id_cuenta, // Asegúrate de que el ID de la nueva cuenta sea devuelto
                        nombre_banco: $("#nombre_banco").val(),
                        numero_cuenta: $("#numero_cuenta").val(),
                        rif_cuenta: $("#rif_cuenta").val(),
                        telefono_cuenta: $("#telefono_cuenta").val(),
                        correo_cuenta: $("#correo_cuenta").val(),
                        estado: 'Habilitado', // O el estado que desees asignar por defecto
                        acciones: `
                            <button type="button" class="btn btn-success btn-modificar" data-id_cuenta="${result.id_cuenta}">
                                Modificar
                            </button>
                            <button type="button" class="btn btn-danger btn-eliminar" data-id_cuenta="${result.id_cuenta}">
                                Eliminar
                            </button>
                            <button type="button" class="btn btn-warning btn-cambiar-estado" data-id_cuenta="${result.id_cuenta}">
                                Cambiar Estado
                            </button>
                        `
                    };
                    // Agregar la nueva cuenta a la tabla
                    var table = $("#cuentasTable").DataTable();
                    table.row.add(newCuenta).draw();
                    // Cerrar el modal de registro
                    $("#registrarModal").modal("hide");
                    // Limpiar el formulario
                    $("#formRegistrar")[0].reset();
                } else {
                    muestraMensaje(result.message);
                }
            },
            error: function() {
                muestraMensaje('Error al registrar la cuenta.');
            }
        });
    });

    // Función para cargar las cuentas en la tabla
    function cargarCuentas() {
        $.ajax({
            type: 'POST',
            url: '',
            data: { accion: 'consultar_cuentas' },
            success: function(response) {
                let cuentas = JSON.parse(response);
                mostrarTabla(cuentas);
            },
            error: function() {
                muestraMensaje('Error al cargar las cuentas.');
            }
        });
    }

    // Función para mostrar la tabla
    function mostrarTabla(cuentas) {
        datosJSON.datos = []; // Reiniciar el array de datos
        cuentas.forEach(cuenta => {
            let acciones = `
                <button type="button" class="btn btn-success btn-modificar" data-id_cuenta="${cuenta.id_cuenta}">
                    Modificar
                </button>
                <button type="button" class="btn btn-danger btn-eliminar" data-id_cuenta="${cuenta.id_cuenta}">
                    Eliminar
                </button>
                <button type="button" class="btn btn-warning btn-cambiar-estado" data-id_cuenta="${cuenta.id_cuenta}">
                    Cambiar Estado
                </button>
            `;
            datosJSON.datos.push({
                id_cuenta: cuenta.id_cuenta,
                nombre_banco: cuenta.nombre_banco,
                numero_cuenta: cuenta.numero_cuenta,
                rif_cuenta: cuenta.rif_cuenta,
                telefono_cuenta: cuenta.telefono_cuenta,
                correo_cuenta: cuenta.correo_cuenta,
                estado: cuenta.estado,
                acciones: acciones
            });
        });

        // Limpiar la tabla actual y cargar los nuevos datos
        $("#cuentasTable").DataTable().clear().rows.add(datosJSON.datos).draw();
    }

    $("#formModificar").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'Controlador/conciliacion.php',
            data: {
                accion: 'modificar',
                id_cuenta: $("#id_cuenta_modificar").val(),
                nombre_banco: $("#nombre_banco_modificar").val(),
                numero_cuenta: $("#numero_cuenta_modificar").val(),
                rif_cuenta: $("#rif_cuenta_modificar").val(),
                telefono_cuenta: $("#telefono_cuenta_modificar").val(),
                correo_cuenta: $("#correo_cuenta_modificar").val(),
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Actualizar la tabla sin recargar la página
                    var id_cuenta = $("#id_cuenta_modificar").val();
                    var updatedCuenta = {
                        id_cuenta: id_cuenta,
                        nombre_banco: $("#nombre_banco_modificar").val(),
                        numero_cuenta: $("#numero_cuenta_modificar").val(),
                        rif_cuenta: $("#rif_cuenta_modificar").val(),
                        telefono_cuenta: $("#telefono_cuenta_modificar").val(),
                        correo_cuenta: $("#correo_cuenta_modificar").val(),
                        estado: result.estado // Asegúrate de que el estado esté incluido si es necesario
                    };
                    // Actualizar la fila en la tabla
                    var table = $("#cuentasTable").DataTable();
                    var rowIndex = table.row(function (idx, data, node) {
                        return data.id_cuenta === id_cuenta;
                    }).index();
                    // Actualizar la fila en la DataTable
                    table.row(rowIndex).data(updatedCuenta).draw();
                    // Cerrar el modal
                    $("#modificarModal").modal("hide");
                } else {
                    muestraMensaje(result.message);
                }
            },
            error: function() {
                muestraMensaje('Error al modificar la cuenta.');
            }
        });
    });

    // Eventos para modificar, eliminar y cambiar estado
    $(document).on('click', '.btn-modificar', function() {
        var id_cuenta = $(this).data('id_cuenta');
        $.ajax({
            type: 'POST',
            url: 'Controlador/conciliacion.php',
            data: { accion: 'obtener_cuenta', id_cuenta: id_cuenta },
            success: function(response) {
                var cuenta = JSON.parse(response);
                if (cuenta.status !== 'error') {
                    $("#id_cuenta_modificar").val(cuenta.id_cuenta);
                    $("#nombre_banco_modificar").val(cuenta.nombre_banco);
                    $("#numero_cuenta_modificar").val(cuenta.numero_cuenta);
                    $("#rif_cuenta_modificar").val(cuenta.rif_cuenta);
                    $("#telefono_cuenta_modificar").val(cuenta.telefono_cuenta);
                    $("#correo_cuenta_modificar").val(cuenta.correo_cuenta);
                    $("#modificarModal").modal("show"); // Mostrar el modal de modificación
                } else {
                    muestraMensaje(cuenta.message);
                }
            },
            error: function() {
                muestraMensaje('Error al obtener los datos de la cuenta.');
            }
        });
    });

    $(document).on('click', '.btn-eliminar', function() {
        var id_cuenta = $(this).data('id_cuenta');
        if (confirm("¿Estás seguro de que deseas eliminar esta cuenta?")) {
            $.ajax({
                type: 'POST',
                url: 'Controlador/conciliacion.php',
                data: { accion: 'eliminar', id_cuenta: id_cuenta },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        // Eliminar la fila de la tabla
                        var table = $("#cuentasTable").DataTable();
                        table.row($(this).closest('tr')).remove().draw(); // Eliminar la fila
                    } else {
                        muestraMensaje(result.message);
                    }
                },
                error: function() {
                    muestraMensaje('Error al eliminar la cuenta.');
                }
            });
        }
    });

    $(document).on('click', '.btn-cambiar-estado', function() {
        var id_cuenta = $(this).data('id_cuenta');
        $.ajax({
            type: 'POST',
            url: 'Controlador/conciliacion.php',
            data: { accion: 'cambiar_estado', id_cuenta: id_cuenta },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Cambiar el estado en la tabla
                    var table = $("#cuentasTable").DataTable();
                    var rowIndex = table.row(function (idx, data, node) {
                        return data.id_cuenta === id_cuenta;
                    }).index();
                    // Obtener el estado actual
                    var currentRow = table.row(rowIndex).data();
                    currentRow.estado = currentRow.estado === 'Habilitado' ? 'Inhabilitado' : 'Habilitado'; // Cambiar el estado
                    // Actualizar la fila en la DataTable
                    table.row(rowIndex).data(currentRow).draw();
                } else {
                    muestraMensaje(result.message);
                }
            },
            error: function() {
                muestraMensaje('Error al cambiar el estado de la cuenta.');
            }
        });
    });

    // Inicializar DataTable
    $("#cuentasTable").DataTable({
        language: {
            lengthMenu: "Mostrando _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
        data: datosJSON.datos,
        columns: [
            { data: "id_cuenta" },
            { data: "nombre_banco" },
            { data: "numero_cuenta" },
            { data: "rif_cuenta" },
            { data: "telefono_cuenta" },
            { data: "correo_cuenta" },
            { data: "estado" },
            { data: "acciones" },
        ],
    });
});

// Función para mostrar mensajes
function muestraMensaje(mensaje) {
    alert(mensaje); // Cambia esto por un modal o una alerta más estilizada si lo deseas
}