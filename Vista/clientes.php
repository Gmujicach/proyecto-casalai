<?php
if (!isset($_SESSION['name'])) {
    header('Location: .');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <form id="incluirclientes" action="" method="POST">
            <input type="hidden" name="accion" value="ingresar">
            <h3 class="titulo-form">INCLUIR CLIENTE</h3>
                
            <div class="grupo-form">
                <input class="control-form" placeholder="Nombre del Cliente" maxlength="15" type="text" id="nombre" name="nombre" placeholder="" required>
                <span id="snombre"></span>

                <input class="control-form" placeholder="Cedula/Rif" maxlength="15" type="text" id="cedula" name="cedula" placeholder="" required>
                <span id="scedula"></span>
            </div>

            <div class="grupo-form">
                <input class="control-form" placeholder="Teléfono" maxlength="11" type="text" id="telefono" name="telefono" placeholder="" required>
                <span id="stelefono"></span>

                <input class="control-form" placeholder="Dirección" maxlength="35" type="text" id="direccion" name="direccion" placeholder="" required>
                <span id="sdireccion"></span>
            </div>
            
            <div class="envolver-form">
                <input class="control-form" placeholder="Correo de Contacto" type="text" id="correo" name="correo" placeholder="" required>
                <span id="scorreo"></span>
            </div>

            <button class="boton-form" type="submit">Registrar</button>
            <button class="boton-reset" type="reset">Reset</button>
        </form>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Clientes</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $clientes): ?>
                <?php if ($clientes['activo'] == 1) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($clientes['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($clientes['cedula']); ?></td>
                    <td><?php echo htmlspecialchars($clientes['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($clientes['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($clientes['correo']); ?></td>
                    <td>
                        <span>
                            <div class="acciones-boton">
                                <i class="vertical">
                                    <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                                </i>
                                <div class="desplegable">
                                    <ul>
                                        <li>
                                            <!-- Botón Modificar que abre el modal -->
                                            <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($clientes['id_clientes']); ?>">
                                            Modificar
                                            </button>
                                        </li>
                                        <li>
                                            <!-- Botón Eliminar -->
                                            <a href="#" data-id="<?php echo htmlspecialchars($clientes['id_clientes']); ?>" class="btn btn-eliminar">Eliminar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de modificación -->
<div class="modal fade modal-modificar" id="modificar_clientes_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_clientes_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarclientes" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificar_clientes_modal_label">Modificar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificar_id_clientes" name="id_clientes">
                    <div class="form-group">
                        <label for="modificarnombre">Nombre</label>
                        <input type="text" class="form-control" maxlength="15" id="modificarnombre" name="nombre" required>
                        <span id="smodificarnombre"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificardireccion">Direccion</label>
                        <input type="text" class="form-control" id="modificardireccion" name="direccion" required>
                        <span id="smodificardireccion"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono">Telefono</label>
                        <input type="text" class="form-control" id="modificartelefono" name="telefono" required>
                        <span id="smodificartelefono"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcedula">Cedula</label>
                        <input type="text" class="form-control" id="modificarcedula" name="cedula" required>
                        <span id="smodificarcedula"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo">Correo</label>
                        <input type="text" class="form-control" id="modificarcorreo" name="correo" required>
                        <span id="smodificarcorreo"></span>
                    </div>
                    
                    
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
                </div>

                
            </form>

            
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <div class="containera"> <!-- todo el contenido ira dentro de esta etiqueta-->

<form method="post" action="" id="f" target="_blank">
<div class="containera">
    <div class="row">
        <div class="col">
               <button type="button" class="btn btn-primary" id="pdfclientes" name="pdfclientes"><a href="?pagina=pdfclientes">GENERAR REPORTE</button>
        </div>
        
    </div>
</div>
</form>
</div> <!-- fin de container -->

</div>

<script src="Javascript/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="Javascript/clientes.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>
</html>