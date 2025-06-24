<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Almacenista') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarClienteModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ingresarclientes" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarClienteModalLabel">Incluir Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="nombre">Nombre Completo</label>
                        <input class="control-form" placeholder="Nombres y apellidos" maxlength="100" type="text" id="nombre" name="nombre" required>
                        <span class="span-value" id="snombre"></span>
                    </div>

                    <div class="envolver-form">
                        <label for="cedula_o_rif">Cedula o RIF</label>
                        <input class="control-form" placeholder="Cedula/Rif" maxlength="12" type="text" id="cedula" name="cedula" required>
                        <span class="span-value" id="scedula"></span>
                    </div>

                    <div class="envolver-form">
                        <label for="telefono">Numero de Teléfono</label>
                        <input class="control-form" placeholder="Teléfono" maxlength="13" type="text" id="telefono" name="telefono" required>
                        <span class="span-value" id="stelefono"></span>
                    </div>
                    
                    <div class="envolver-form">
                        <label for="Direccion">Dirección</label>
                        <textarea class="form-control" maxlength="100" id="direccion" name="direccion" rows="3"></textarea>
                        <span class="span-value" id="sdireccion"></span>
                    </div>
                    
                    <div class="envolver-form">
                        <label for="correo">Correo Electrónico</label>
                        <input class="control-form" placeholder="Correo" type="text" id="correo" name="correo" maxlength="50" required>
                        <span class="span-value" id="scorreo"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="boton-form" type="submit">Registrar</button>
                    <button class="boton-reset" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <div class="space-btn-incluir">
        <button id="btnIncluirCliente" class="btn-incluir">
            Incluir Cliente
        </button>
    </div>

    <h3>Lista de Clientes</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre del Cliente</th>
                <th>Cedula</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <?php if ($cliente['activo'] == 1) { ?>
                <tr data-id="<?php echo $cliente['id_clientes']; ?>">
                    <td>
                        <ul>
                            <div>
                                <button class="btn-modificar"
                                    id="btnModificarCliente"
                                    data-id="<?php echo htmlspecialchars($cliente['id_clientes']); ?>"
                                    data-nombre="<?php echo htmlspecialchars($cliente['nombre']); ?>"
                                    data-cedula="<?php echo htmlspecialchars($cliente['cedula']); ?>"
                                    data-direccion="<?php echo htmlspecialchars($cliente['direccion']); ?>"
                                    data-telefono="<?php echo htmlspecialchars($cliente['telefono']); ?>"
                                    data-correo="<?php echo htmlspecialchars($cliente['correo']); ?>">
                                    Modificar
                                </button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                    data-id="<?php echo $cliente['id_clientes']; ?>">
                                    Eliminar
                                </button>
                            </div>
                        </ul>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($cliente['nombre']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cliente['cedula']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($cliente['direccion']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($cliente['telefono']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cliente['correo']); ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade modal-modificar" id="modificar_clientes_modal" tabindex="-1" role="dialog" 
aria-labelledby="modificar_clientes_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarclientes" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificar_clientes_modal_label">Modificar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_clientes" name="id_clientes">
                    <div class="form-group">
                        <label for="modificarnombre">Nombre completo</label>
                        <input type="text" class="form-control" maxlength="100" id="modificarnombre" name="nombre" required>
                        <span class="span-value-modal" id="smodificarnombre"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcedula">Cédula</label>
                        <input type="text" class="form-control" id="modificarcedula" name="cedula" maxlength="12" required>
                        <span class="span-value-modal" id="smodificarcedula"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono">Teléfono</label>
                        <input type="text" class="form-control" id="modificartelefono" name="telefono" maxlength="13" required>
                        <span class="span-value-modal" id="smodificartelefono"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificardireccion">Dirección</label>
                        <textarea class="form-control" maxlength="100" id="modificardireccion" name="direccion" rows="3"></textarea>
                        <span class="span-value-modal" id="smodificardireccion"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo">Correo electrónico</label>
                        <input type="text" class="form-control" id="modificarcorreo" name="correo" maxlength="50" required>
                        <span class="span-value-modal" id="smodificarcorreo"></span>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
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

<script src="Javascript/js/jquery.min.js"></script>
<script src="Javascript/js/jquery-3.5.1.min.js"></script>
<script src="Public/js/popper.min.js"></script>
<script src="Javascript/js/bootstrap.min.js"></script>

<script src="Javascript/clientes.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'Public/js/es-ES.json'
        },
        columnDefs: [
            { orderable: false, targets: 5 } // Deshabilitar ordenamiento para columna de acciones
        ]
    });
});
</script>
</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>