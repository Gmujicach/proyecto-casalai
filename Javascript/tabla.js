var x = document.getElementsByClassName("acciones-boton");
var i;
for (i = 0; i < x.length; i++) {
    x[i].addEventListener("click", function() {
        this.classList.toggle("active");
    })
}

function cambiarFilasPorPagina(filas) {
    const url = new URL(window.location.href);
    url.searchParams.set('filas', filas);
    url.searchParams.set('pagina', 1); // Volver a la primera página
    window.location.href = url.toString();
}

// Opcional: Manejo con AJAX para evitar recargar la página
function cambiarPagina(pagina) {
    const filas = document.getElementById('filasPorPagina').value;
    
    $.ajax({
        url: window.location.pathname,
        type: 'GET',
        data: {
            pagina: pagina,
            filas: filas
        },
        success: function(data) {
            // Actualizar la tabla con los nuevos datos
            $('#tablaConsultas tbody').html($(data).find('#tablaConsultas tbody').html());
            $('#tablaConsultas tfoot').html($(data).find('#tablaConsultas tfoot').html());
        }
    });
}