<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>
<?php include 'header.php'; ?>
  <title>Gestionar Usuarios</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/darckort.css">
  
</head>
<body>

<?php include 'NavBar.php'; ?>

<div class="container"> 
            <form id="incluirusuario" action="" method="POST" class="formulario-1">
                <input type="hidden" name="accion" value="ingresar">
                <h3 class="display-4 text-center">INCLUIR USUARIO</h3>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nombre_usuario">Nombre de Usuario</label>
                        <input type="text" maxlength="15" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                        <span id="snombre_usuario"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="clave_usuario">Contraseña del Usuario</label>
                        <input type="text" maxlength="15" class="form-control" id="clave_usuario" name="clave_usuario" required>
                        <span id="sclave_usuario"></span>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                </div>
            </form>
    </div>


    <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE USUARIOS</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Usuarios</th>
                <th>Rango del Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td>
                        <!-- Botón Modificar que abre el modal -->
                        <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                        Modificar
                        </button>
                        <br>
                        <!-- Botón Eliminar -->
                        <a href="#" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                    <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['rango']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
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
                        <label for="modificarnombre_usuario">Nombre del Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" required>
                        <span id="smodificarclave_usuario"></span>
                    </div>
                    <div class="form-group col-md-4">
                                    <label for="rango">Categorias</label>
                                    <select class="custom-select" id="rango" name="rango">
                                    <option value="USUARIO">Usuario</option>
                                                        <option value="admin">Administrador</option>
                                                        <option value="almacen">Almacen</option>    
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
    <div class="containera"> <!-- todo el contenido ira dentro de esta etiqueta-->

<form method="post" action="" id="f" target="_blank">
<div class="containera">
    <div class="row">
        <div class="col">
               <button type="button" class="btn btn-primary" id="pdfusuarios" name="pdfusuarios"><a href="?pagina=pdfusuarios">GENERAR REPORTE</button>
        </div>
        
    </div>
</div>
</form>
    
</div> <!-- fin de container -->
</div>


<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/usuario.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>
</html>
