<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente' || $_SESSION['nombre_rol'] == 'SuperUsuario') {?>

<?php require_once 'modelo/despacho.php' ; require_once 'controlador/factura.php' ; ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'header.php'; ?>
        <link rel="stylesheet" href="styles/darckort.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Gestionar Despachos</title>
    </head>

    <body>
        <?php require_once("public/modal.php"); ?>


        <?php include 'NavBar.php'; ?>


        <div class="container"> <!-- todo el contenido ira dentro de esta etiqueta-->
            <form method="post" action="?pagina=descargarFactura" id="f" class="formulario-1">
                <input type="text" name="accion" id="accion" style="display:none" />
                <input type="hidden" name="detalle_factura" id="detalle_factura_input">
                <h3 class="display-4 text-center">Factura</h3>
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
                                <input class="form-control" type="text" id="nombre_p" name="nombre_p"
                                    style="display:none" />
                                <input class="form-control" type="text" id="id_producto" name="id_producto"
                                    style="display:none" />
                                <button type="button" class="btn btn-primary" id="listadodeproductos"
                                    name="listadodeproductos">LISTADO DE PRODUCTOS</button>
                                <div class=" row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary" id="registrar"
                                            name="registrar">Procesar<br> Pre-Factura</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN DE FILA BUSQUEDA DE PRODUCTOS -->
                        <div class="row">
                            <div class="col">
                                <hr />
                            </div>
                        </div>




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
                                    <th>Eliminar</th>
                                    <th style="display:none">Id</th>
                                    <th>Producto</th>
                                    <th>modelo</th>
                                    <th>Marca</th>
                                    <th>Cantidad Disponible</th>
                                    <th>Cantidad Seleccionada</th>
                                    <th>Precio</th>
                                    <th>Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody id="detalle_factura">
                                <!-- Filas insertadas dinámicamente con JavaScript -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" style="text-align:right; font-weight:bold;">Total:</td>
                                    <td id="total_subtotal" style="font-weight:bold;">0.00 $</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>


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
                    <h5 class="modal-title">Agregar Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-content">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display:none">Id</th>
                                <th>Nombre Producto</th>
                                <th>modelo</th>
                                <th>Marca</th>
                                <th>Stock Actual</th>
                                <th>Precio</th>
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
        <script src="javascript/factura.js"></script>




        <?php include 'footer.php'; ?>
        <script src="javascript/validaciones.js"></script>
    </body>

    </html>
    <?php
} else {
    header("Location: ?pagina=acceso-denegado"); 
    exit;
}
?>