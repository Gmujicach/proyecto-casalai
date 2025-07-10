<?php
// Verificar que $datos esté definido y sea válido
if (!isset($datos) || !is_array($datos) || empty($datos)) {
    die("Error: No se pudo cargar la variable datos.");
}


if (!empty($datos) && isset($datos["nombre_p"])) {
    $datos = [$datos];
}
// Convertir datos a JSON
$labels = json_encode(array_column($datos, "nombre_p"));
$data = json_encode(array_column($datos, "stock"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Estadístico con Chart.js</title>
    <script src="public/js/chart.js"></script>
    <script src="public/js/jspdf.umd.min.js"></script>
    <script src="public/js/html2canvas.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        canvas {
            width: 80%;
            margin: auto;
        }
    </style>
</head>
<body>

    <h2>Reporte Estadístico de Productos en Stock</h2>
    <canvas id="graficoBarras"></canvas>
    <button id="descargarPDF">Descargar Reporte en PDF</button>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const datos = {
                labels: <?php echo $labels; ?>,
                datasets: [{
                    label: "Stock Disponible",
                    data: <?php echo $data; ?>,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2
                }]
            };

            const config = {
                type: "bar",
                data: datos,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        title: { display: true, text: "Stock de Productos" }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            };

            const ctx = document.getElementById("graficoBarras").getContext("2d");
            new Chart(ctx, config);
        });
          document.getElementById("descargarPDF").addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        html2canvas(document.getElementById("graficoBarras")).then(canvas => {
            const imgData = canvas.toDataURL("image/png"); // Convertir el gráfico a imagen
            const imgWidth = 180; // Ancho en mm
            const imgHeight = (canvas.height * imgWidth) / canvas.width; // Mantener la proporción

            doc.setFontSize(16);
            doc.text("Reporte de Stock de Productos", 15, 15);
            doc.addImage(imgData, "PNG", 15, 25, imgWidth, imgHeight);
            doc.save("Reporte_Productos.pdf");
        });
    });  
    </script>


</body>
</html>
