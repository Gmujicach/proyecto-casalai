<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="Styles/darckort.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestionar Proveedores</title>
</head>
<body>


    <?php include 'NavBar.php'; ?>


<div class="container">
    <!--== INICIO DEL CONTENIDO ==-->
    <section class="container">
        <div class="row my-5">
            <div class="col-sm-12 col-md-12 col-lg-12">

        
            
            <form id="incluirproveedor" action="" method="POST" class="formulario-1">
            <input type="hidden" name="accion" value="ingresar">
                    <h3 class="display-4 text-center">INCLUIR PROVEEDOR</h3>
                    <div class="row">
                        <div class="col">
                            <label class="form-label mt-4" for="nombre_proveedor">Nombre del Proveedor</label>
                            <input class="form-control" maxlength="15" type="text" id="nombre_proveedor" name="nombre_proveedor" placeholder="">
                            <span id="snombre_proveedor"></span>
                        </div>
                        <div class="col">
                            <label class="form-label mt-4" for="rif_proveedor">Rif del Proveedor</label>
                            <input class="form-control" maxlength="10" type="text" id="rif_proveedor" name="rif_proveedor" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label mt-4" for="nombre_representante">Nombre del Representante</label>
                            <input class="form-control" maxlength="15" type="text" id="nombre_representante" name="nombre_representante" placeholder="">
                        </div>

                        <div class="col">
                            <label class="form-label mt-4" for="rif_representante">Rif del Representante</label>
                            <input class="form-control" maxlength="10" type="text" id="rif_representante" name="rif_representante" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label mt-4" for="direccion_proveedor">Direccion</label>
                            <input class="form-control" maxlength="50" type="text" id="direccion_proveedor" name="direccion_proveedor" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label mt-4" for="telefono_1">Telefono Principal</label>
                            <input class="form-control" maxlength="11" type="text" id="telefono_1" name="telefono_1" placeholder="">
                        </div>
                        <div class="col">
                            <label class="form-label mt-4" for="telefono_2">Telefono Secundario</label>
                            <input class="form-control" maxlength="11" type="text" id="telefono_2" name="telefono_2" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label mt-4" for="correo_proveedor">Correo de Contacto</label>
                            <input class="form-control" type="text" id="correo_proveedor" name="correo_proveedor" placeholder="">
                        </div>
                    </div>
                    <label class="form-label" for="observacion">Observaciones</label>
                    <textarea class="form-control" maxlength="50" id="observacion" name="observacion" rows="3" placeholder="Escriba alguna Observaciones que se deba tener en cuenta..."></textarea>


                    <div class="row">
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--== FIN DEL CONTENIDO ==-->

    <!--== LISTADO DE CONSULTA ==-->

    <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE PROVEEDORES</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>R.I.F</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
                <tr>
                    <td>
                        <!-- Botón Modificar que abre el modal -->
                        <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($proveedor['id_proveedor']); ?>">
                        Modificar
                        </button>
                        <br>
                        <!-- Botón Eliminar -->
                        <a href="#" data-id="<?php echo htmlspecialchars($proveedor['id_proveedor']); ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                    <td><?php echo htmlspecialchars($proveedor['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($proveedor['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($proveedor['rif_proveedor']); ?></td>
                    <td><?php echo htmlspecialchars($proveedor['correo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                        <!-- MODAL -->
<div class="modal fade" id="modificar_proveedor_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_proveedor_modal_label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form id="modificarproveedor" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modificar_proveedor_modal_label">Modificar Proveedor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <!-- Campos del formulario de modificación -->
                                                <input type="hidden" id="modificar_id_proveedor" name="id_proveedor">
                                                <div class="form-group">
                                                    <div class="col">
                                                        <label for="modificarnombre_proveedor">Nombre del Proveedor</label>
                                                        <input type="text" class="form-control" id="modificarnombre_proveedor" name="nombre_proveedor" maxlength="15" required>
                                                        <span id="smodificarnombre_proveedor"></span>
                                                    </div>

                                                    <div class="col">
                                                        <label for="modificarrif_proveedor">R.I.F del Proveedor</label>
                                                        <input type="text" class="form-control" id="modificarrif_proveedor" name="rif_proveedor" maxlength="15" required>
                                                        <span id="smodificarrif_proveedor"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col">
                                                        <label for="modificarnombre_representante">Nombre del Representante</label>
                                                        <input type="text" class="form-control" id="modificarnombre_representante" name="nombre_representante" maxlength="15" required>
                                                        <span id="smodificarnombre_representante"></span>
                                                    </div>

                                                    <div class="col">
                                                        <label for="modificarrif_representante">R.I.F del Representante</label>
                                                        <input type="text" class="form-control" id="modificarrif_representante" name="rif_representante" maxlength="15" required>
                                                        <span id="smodificarrif_representante"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                   
                                                        <label for="modificardireccion_proveedor">Direccion</label>
                                                        <input type="text" class="form-control" id="modificardireccion_proveedor" name="direccion_proveedor" maxlength="15" required>
                                                        <span id="smodificardireccion_proveedor"></span>
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <div class="col">
                                                        <label for="modificartelefono_1">Telefono del Proveedor</label>
                                                        <input type="text" class="form-control" id="modificartelefono_1" name="telefono_1" maxlength="15" required>
                                                        <span id="smodificartelefono_1"></span>
                                                    </div>

                                                    <div class="col">
                                                        <label for="modificartelefono_2">Telefono del Representante</label>
                                                        <input type="text" class="form-control" id="modificartelefono_2" name="telefono_2" maxlength="15" required>
                                                        <span id="smodificartelefono_2"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   
                                                   <label for="modificarcorreo_proveedor">Correo</label>
                                                   <input type="text" class="form-control" id="modificarcorreo_proveedor" name="correo_proveedor" maxlength="15" required>
                                                   <span id="smodificarcorreo_proveedor"></span>
                                               
                                                </div>

                                                <div class="form-group">
                                                        
                                                        <label for="modificarobservacion">observacion</label>
                                                        <input type="text" class="form-control" id="modificarobservacion" name="observacion" maxlength="30" required>
                                                        <span id="smodificarobservacion"></span>
                                                    
                                                </div>
                                            
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Modificar</button>
                                            </div>
                                            </div>
                                            
                                        </form>
                                    </div>
    </div>

                        <!-- FIN DEL MODAL -->
                    <div class="row">
                        <div class="col">
                            <button class="btn" name="" type="button" id="pdfproveedores" name="pdfproveedores"><a href="?pagina=pdfproveedores">GENERAR REPORTE</a></button>
                        </div>
                    </div>

    </div>

                
            

            
    </form>
</div>

  <?php include 'footer.php'; ?>
  <script src="Javascript/proveedor.js"></script>
  <script src="Javascript/validaciones.js"></script>
</body>
</html>
