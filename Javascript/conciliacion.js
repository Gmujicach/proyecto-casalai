$(document).ready(function () {
    let datosJSON = { datos: [] };

    // Cargar datos de cuentas en la tabla
    cargarCuentas();
    
    // Registrar nueva cuenta
    $("#formRegistrar").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "Controlador/conciliacion.php",
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
    // Función para cargar las cuentas en la tabla
    function cargarCuentas() {
        $.ajax({
            type: "POST",
            url: "Controlador/conciliacion.php",
            data: { accion: 'consultar_cuentas' },
            success: function(response) {
                let cuentas = JSON.parse(response);
                //console.log(cuentas);
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
                <button type="button" class="btn btn-success btn-modificar" data-id="${cuenta.id_cuenta}">
                    Modificar
                </button>
                <button type="button" class="btn btn-danger btn-eliminar" data-id="${cuenta.id_cuenta}">
                    Eliminar
                </button>
                <button type="button" class="btn btn-warning btn-cambiar-estado" data-id="${cuenta.id_cuenta}">
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
    // Eventos para modificar, eliminar y cambiar estado
    $(document).on('click', '.btn-modificar', function() {
        var id_cuenta = $(this).data('id');
        // Lógica para modificar la cuenta...
    });
    $(document).on('click', '.btn-eliminar', function() {
        var id_cuenta = $(this).data('id');
        // Lógica para eliminar la cuenta...
    });
    $(document).on('click', '.btn-cambiar-estado', function() {
        var id_cuenta = $(this).data('id');
        // Lógica para cambiar el estado de la cuenta...
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