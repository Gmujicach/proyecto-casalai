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
    <title>Gestionar Proveedores</title>
</head>
<body>


    <?php include 'NewNavBar.php'; ?>


<div class="formulario-responsivo">
    <div class="fondo-form">
    <form id="incluirproveedor" action="" method="POST" action="">
        <input type="hidden" name="accion" value="ingresar">
        <h3 class="titulo-form">INCLUIR PROVEEDOR</h3>

        <div class="grupo-form">
            <input type="text" placeholder="Nombre Proveedor" class="control-form" id="nombre_proveedor" name="nombre_proveedor" required>
            <span id="snombre_proveedor"></span>

            <input type="text" placeholder="R.I.F del Proveedor" class="control-form" id="rif_proveedor" name="rif_proveedor" required>
            <span id="srif_proveedor"></span>
        </div>

        <div class="grupo-form">
            <input type="text" placeholder="Nombre Representante" class="control-form" id="nombre_representante" name="nombre_representante" required>
            <span id="snombre_representante"></span>

            <input type="text" placeholder="R.I.F del Representante" class="control-form" id="rif_representante" name="rif_representante" required>
            <span id="srif_representante"></span>
        </div>

        <div class="envolver-form">
            <input type="text" placeholder="Correo" class="control-form" id="correo_proveedor" name="correo_proveedor" required>
            <span id="scorreo_proveedor"></span>
        </div>

        <div class="envolver-form">
            <input type="text" placeholder="Direccion" class="control-form" id="direccion_proveedor" name="direccion_proveedor" required>
            <span id="sdireccion_proveedor"></span>
        </div>

        

        <div class="grupo-form">
            <input type="text" placeholder="Telefono Principal" class="control-form" id="telefono_1" name="telefono_1" required>
            <span id="stelefono_1"></span>

            <input type="text" placeholder="Telefono Secundario" class="control-form" id="telefono_2" name="telefono_2" required>
            <span id="stelefono_2"></span>
        </div>

        <div class="envolver-form">
            <textarea class="control-form" maxlength="50" id="observacion" name="observacion" rows="3" placeholder="Escriba alguna Observaciones que se deba tener en cuenta..."></textarea>
            <span id="sobservacion"></span>
        </div>

        <button class="boton-form" type="submit">Registrar</button>
    </form>
    </div>
</div>

    <!--== LISTADO DE CONSULTA ==-->
<div class="contenedor-tabla">
    <h3>LISTA DE USUARIOS</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Nombre</th>
                <th>R.I.F</th>
                <th>Telefono</th>
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>


        <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><input type="checkbox"></td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre']); ?>
                    </span>
                    <span class="campo-correo">
                    <?php echo htmlspecialchars($proveedor['correo']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-telefono">
                    <?php echo htmlspecialchars($proveedor['telefono']); ?>
                    </span>
                </td>
                
                <td>
                    <span>
                        <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                            <div class="desplegable">
                                <ul>
                                    <li><a href="#">Ver</a></li>
                                    <li>
                                        <a href="#" class="modificar" 
                                            data-id="<?php echo $proveedor['id_proveedor']; ?>"
                                            data-nombres="<?php echo htmlspecialchars($usuario['nombres']); ?>"
                                            data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                            data-usuario="<?php echo htmlspecialchars($usuario['username']); ?>"
                                            data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                            data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                            data-clave="<?php echo htmlspecialchars($usuario['password']); ?>"
                                            data-rango="<?php echo htmlspecialchars($usuario['rango']); ?>"
                                            data-toggle="modal" 
                                            data-target="#modificar_usuario_modal">
                                            Modificar
                                        </a>
                                    </li>

                                    <li><a href="#" class="eliminar" data-id="<?php echo $proveedor['id_proveedor']; ?>">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

<div class="contenedor-tabla">
    <h3>Lista de Productos Con Bajo Stock</h3>
    <table class="tabla"class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Id Producto</th>
                <th>Producto</th>
                <th>Modelo</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_modelo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock_minimo']); ?></td>            
                    <td>
                        <span>
                            <div class="acciones-boton">
                                <i class="vertical">
                                    <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                                </i>
                                <div class="desplegable">
                                    <ul>
                                        <li>
                                            <!-- Botón de Realizar Pedido -->
                                            <button 
                                                type="button" 
                                                class="btn btn-primary modificar" 
                                                id="modificarProductoBtn"
                                                data-toggle="modal" 
                                                data-target="#modificarProductoModal" 
                                                data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                                                data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                                                data-modelo="<?php echo htmlspecialchars($producto['nombre_modelo']); ?>"
                                                data-stockactual="<?php echo htmlspecialchars($producto['stock']); ?>"
                                                data-stockminimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                                            >
                                                Realizar Pedido
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

                
            

            
    </form>
</div>

  <?php include 'footer.php'; ?>
  <script src="Javascript/proveedor.js"></script>
  <script src="Javascript/validaciones.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Escuchar el clic en cualquier botón con clase "modificar"
    document.querySelectorAll('.modificar').forEach(button => {
        button.addEventListener('click', function () {
            // Obtener los datos del botón
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const modelo = this.dataset.modelo;
            const stockactual = this.dataset.stockactual;
            const stockminimo = this.dataset.stockminimo;

            // Llenar los campos del modal
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-nombre').value = nombre;
            document.getElementById('modal-modelo').value = modelo;
            document.getElementById('modal-stockminimo').value = stockminimo;
        });
    });
});
</script>


</body>
</html>
