<?php include 'header.php'; ?>
<title>Gestionar Despachos</title>
</head>

<body>
    <?php require_once("public/modal.php"); ?>


    <?php include 'NavBar.php'; ?>


    <div class="container"> <!-- todo el contenido ira dentro de esta etiqueta-->





        <!-- seccion del modal productos -->
        <div id="modalproductos" class="container mt-4">
            <h5 class="title text-center bg-info text-white p-2 rounded">Registro de Facturas</h5>
            <div class="table-responsive p-3">
                <table class="table table-striped table-hover table-bordered">
                    <tbody id="listado">



                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="Javascript/factura.js"></script>

    <?php include 'footer.php'; ?>
        <!-- Bootstrap JS -->



</body>