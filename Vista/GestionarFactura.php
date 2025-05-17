<?php include 'header.php'; ?>
<title>Gestionar Despachos</title>
</head>

<body>
    <?php require_once("public/modal.php"); ?>


    <?php include 'NewNavBar.php'; ?>


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
    <script src="Javascript/factura.js"></script>
    <script src='Public/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='Public/bootstrap/css/bootstrap.min.css'></script>
    <script src="Javascript/validaciones.js"></script>



</body>