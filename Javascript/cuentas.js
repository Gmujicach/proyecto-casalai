$(document).ready(function () {
    // Cargar datos de cuentas en la tabla
    cargarCuentas();

    // Registrar nueva cuenta
    $("#formRegistrar").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "",
            data: {
                accion: 'registrar',
                nombre_banco: $("#nombre_banco").val(),
                numero_cuenta: $("#numero_cuenta").val(),
                rif_cuenta: $("#rif_cuenta").val(),
                telefono_cuenta: $("#telefono_cuenta").val(),
                correo_cuenta: $("#correo_cuenta").val(),
            },
            success: function(response) {
                location.reload(); // Recargar la página para ver los cambios
            },
            error: function() {
                muestraMensaje('Error al registrar la cuenta.');
            }
        });
    });

    // Modificar cuenta
    $(document).on('click', '.btn-modificar', function() {
        var id_cuenta = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "",
            data: {
                accion: 'obtener_cuenta',
                id_cuenta: id_cuenta
            },
            success: function(response) {
                var cuenta = JSON.parse(response);
                $("#id_cuenta_modificar").val(cuenta.id_cuenta);
                $("#nombre_banco_modificar").val(cuenta.nombre_banco);
                $("#numero_cuenta_modificar").val(cuenta.numero_cuenta);
                $("#rif_cuenta_modificar").val(cuenta.rif_cuenta);
                $("#telefono_cuenta_modificar").val(cuenta.telefono_cuenta);
                $("#correo_cuenta_modificar").val(cuenta.correo_cuenta);
                $("#modificarModal").modal("show");
            },
            error: function() {
                muestraMensaje('Error al obtener los datos de la cuenta.');
            }
        });
    });

    $("#formModificar").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "",
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
                location.reload(); // Recargar la página para ver los cambios
            },
            error: function() {
                muestraMensaje('Error al modificar la cuenta.');
            }
        });
    });

    // Eliminar cuenta
    $(document).on('click', '.btn-eliminar', function() {
        var id_cuenta = $(this).data('id');

        if (confirm("¿Estás seguro de que deseas eliminar esta cuenta?")) {
            $.ajax({
                type: "POST",
                url: "",
                data: {
                    accion: 'eliminar',
                    id_cuenta: id_cuenta
                },
                success: function(response) {
                    location.reload(); // Recargar la página para ver los cambios
                },
                error: function() {
                    muestraMensaje('Error al eliminar la cuenta.');
                }
            });
        }
    });

    // Cambiar estado de la cuenta
    $(document).on('click', '.btn-cambiar-estado', function() {
        var id_cuenta = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "",
            data: {
                accion: 'cambiar_estado',
                id_cuenta: id_cuenta
            },
            success: function(response) {
                location.reload(); // Recargar la página para ver los cambios
            },
            error: function() {
                muestraMensaje('Error al cambiar el estado de la cuenta.');
            }
        });
    });
});

// Función para cargar las cuentas en la tabla
function cargarCuentas() {
    $.ajax({
        type: "POST",
        url: "",
        data: { accion: 'consultar_cuentas' },
        success: function(response) {
            var datos = JSON.parse(response);
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
                data: datos, // Utilizar el objeto JSON directamente
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
        },
        error: function() {
            muestraMensaje('Error al cargar las cuentas.');
        }
    });
}

// Función para mostrar mensajes
function muestraMensaje(mensaje) {
    alert(mensaje); // Cambia esto por un modal o una alerta más estilizada si lo deseas
}