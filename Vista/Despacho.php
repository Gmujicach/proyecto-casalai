<?php

require_once 'Modelo/Despacho.php';
require_once 'Controlador/Despacho.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="Styles/darckort.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestionar Despachos</title>
</head>

<body>
    <?php require_once("public/modal.php"); ?>


    <?php include 'NewNavBar.php'; ?>


    <div class="container"> <!-- todo el contenido ira dentro de esta etiqueta-->
        <form method="post" action="" id="f" class="formulario-1">
            <input type="text" name="accion" id="accion" style="display:none" />
            <h3 class="display-4 text-center">Gestionar Despachos</h3>
            <div class="">
                
                <div class="row">
                    <div class="col">
                        <hr />
                    </div>
                </div>
                <!-- FILA DE INPUT Y BUSCAR CLIENTE -->
                <div class="row">

                    <div class="row">
                        <div class="col-md-8 input-group">
                            <input class="form-control" type="text" id="nombre_p" name="nombre_p" style="display:none"/>
                            <input class="form-control" type="text" id="id_producto" name="id_producto" style="display:none" />
                            <button type="button" class="btn btn-primary" id="listadodeproductos" name="listadodeproductos">LISTADO DE PRODUCTOS</button>
                        </div>
                    </div>
                    <!-- FIN DE FILA BUSQUEDA DE PRODUCTOS -->
                    <div class="row">
                        <div class="col">
                            <hr />
                        </div>
                    </div>              
                    <div class="col-md-6">
                        <label for="correlativo">Correlativo</label>
                        <input class="form-control" maxlength="10" type="text" id="correlativo" name="correlativo" />
                    </div>

                    <div class="col-md-6">
                        <label for="cliente">Clientes</label>
                        <select class="form-select" name="cliente" id="cliente">
                            <option value='disabled'  
                                disabled selected>Seleccione un cliente</option>
                            <?php
                            foreach ($clientes as $cliente) {
                                echo "<option value='" . $cliente['id_clientes'] . "'>" . $cliente['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- FIN DE FILA INPUT Y BUSCAR CLIENTE -->

                <!-- FILA DE DATOS DEL CLIENTE -->
                <div class="row">
                    <div class="col-md-12" id="datosdelcliente">

                    </div>
                </div>
                <!-- FIN DE FILA DATOS DEL CLIENTE -->

                <div class="row">
                    <div class="col">
                        <hr />
                    </div>
                </div>

                <!-- FILA DE BUSQUEDA DE PRODUCTOS -->

                <!-- FILA DE DETALLES DE LA VENTA -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>X</th>
                                    <th style="display:none">Id</th>
                                    <th>Nombre</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                
                                </tr>
                            </thead>
                            <tbody id="detalle_despacho">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- FIN DE FILA DETALLES DE LA VENTA -->
            </div>
            <!-- FILA DE BOTONES -->
            <div class=" row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" id="registrar" name="registrar">Registrar</button>
                    </div>
                </div>
                <!-- FIN DE FILA BOTONES -->
        </form>

        <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE DESPACHOS</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>FECHA</th>
                <th>CORRELATIVO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($despachos as $despacho): ?>
                <tr>
                    <td><?php echo htmlspecialchars($despacho['fecha_despacho']); ?></td>
                    <td><?php echo htmlspecialchars($despacho['correlativo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 
    </div>

        <div class="table-container">
                   
                    <div class="row">
                        <div class="col">
                            <button class="btn" name="" type="button" id="pdfdespacho" name="pdfdespacho"><a href="?pagina=pdfdespachos">GENERAR REPORTE</a></button>
                        </div>
                    </div>

        </div>
    </div> <!-- fin de container -->
    


    <!-- seccion del modal clientes -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalclientes">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-header text-light bg-info">
                <h5 class="modal-title">Listado de clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-content">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="display:none">Id</th>
                            <th>Nombre</th>
                            <th>Rif</th>
                        </tr>
                    </thead>
                    <tbody id="listadoclientes">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    <!--fin de seccion modal-->

    <!-- seccion del modal productos -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalproductos">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-header text-light bg-info">
                <h5 class="modal-title">Listado de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-content">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="display:none">Id</th>
                            <th>Nombre</th>
                            <th>Stock Actual</th>
                        </tr>
                    </thead>
                    <tbody id="listadoproductos">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        
    </div>
    <!--fin de seccion modal-->

    <script src="Javascript/despacho.js"></script>
    <script src="Javascript/validaciones.js"></script>
</body>

<?php include 'footer.php'; ?>