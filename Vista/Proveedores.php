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
     data-id="<?php echo $usuario['id_usuario']; ?>"
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

                                    <li><a href="#" class="eliminar" onclick="eliminarUsuario(<?php echo $usuario['id_usuario']; ?>)">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <!-- <tfoot>
            <tr>
                <td>Filas por Página: 
                    <select id="filasPorPagina" onchange="cambiarFilasPorPagina(this.value)">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </td>
                <td><?php //echo "$inicio-$fin de $totalUsuarios"; ?></td>
                <td>
                    <a href="?pagina=<?php //echo max(1, $paginaActual - 1); ?>">
                        <i class="flecha-izquierda"><img src="IMG/flecha_izquierda.svg" alt="Anterior" width="16" height="16"></i>
                    </a>
                </td>
                <td>
                    <a href="?pagina<?php //echo min(ceil($totalUsuarios / $filasPorPagina), $paginaActual + 1); ?>">
                        <i class="flecha-derecha"><img src="IMG/flecha_derecha.svg" alt="Siguiente" width="16" height="16"></i>
                    </a>
                </td>
            </tr>
        </tfoot> -->
    </table>




<!-- Modal de modificación -->
    <div class="modal fade" id="modificar_usuario_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarusuario" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                    <div class="form-group">
                        <label for="modificarnombre">Nombres del Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre" name="nombre" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarapellido_usuario">Apellidos del Usuario</label>
                        <input type="text" class="form-control" id="modificarapellido_usuario" name="apellido_usuario" maxlength="15" required>
                        <span id="smodificarapellido_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarnombre_usuario">Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono_usuario">Telefono</label>
                        <input type="text" class="form-control" id="modificartelefono_usuario" name="telefono_usuario" maxlength="15" required>
                        <span id="smodificartelefono_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo_usuario">Correo</label>
                        <input type="text" class="form-control" id="modificarcorreo_usuario" name="correo_usuario" maxlength="15" required>
                        <span id="smodificarcorreo_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" required>
                        <span id="smodificarclave_usuario"></span>
                    </div>
                    <div class="form-group col-md-4">
                                    <label for="rango">Categorias</label>
                                    <select class="custom-select" id="rango" name="rango">
                                    <option value="usuario">Usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Almacenista">Almacenista</option>
                                    <option value="Cliente">Cliente</option> 
                                    <option value="Desarrollador">Desarrollador</option>   
                                    </select>
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
</div>


    <div class="contenedor-tabla">
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
