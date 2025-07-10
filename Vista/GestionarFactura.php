<?php include 'header.php'; ?>
<title>Gestionar Facturas</title>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <?php require_once("public/modal.php"); ?>


    <?php include 'newnavbar.php'; ?>


    <div class="container"> <!-- todo el contenido ira dentro de esta etiqueta-->





        <!-- seccion del modal productos -->
        <div id="modalproductos" class="container-lg mt-4 p-4 bg-light shadow rounded" style="max-width: 90%; margin: auto;">
    <h5 class="title text-center bg-info text-white p-3 rounded">Registro de Facturas</h5>
    <div style="display: flex; flex-direction: column;">
    <div class="table-responsive" style="flex: 1 1 auto; height: 100%;">
        <table class="table table-striped table-hover table-bordered w-100 h-100" style="height: 100%;">
            <tbody id="listado" style="height: 100%; display: block; overflow-y: auto;">

            </tbody>
        </table>
    </div>
</div>

</div>


    </div>


    

    <?php include 'footer.php'; ?>
        <!-- Bootstrap JS -->
    <script src="javascript/factura.js"></script>
    <script src='public/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='public/bootstrap/css/bootstrap.min.css'></script>
    <script src="javascript/validaciones.js"></script>



</body>