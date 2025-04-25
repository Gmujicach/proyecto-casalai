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
  <title>Gestionar Marcas</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/darckort.css">
  
</head>
<body>

<?php include 'NavBar.php'; ?>

<div class="container"> 
<form id="incluirmarcas" action="" method="POST" class="formulario-1">
    <input type="hidden" name="accion" value="ingresar">
    <h3 class="display-4 text-center">INCLUIR MARCA</h3>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="descripcion_ma">Nombre de la Marca</label>
            <input type="text" maxlength="15" class="form-control" id="descripcion_ma" name="descripcion_ma" required>
            <span id="sdescripcion_ma"></span>
        </div>
    </div>
    <div class="form-group d-flex justify-content-center">
        <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
    </div>
</form>
    </div>


    <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE MARCAS</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre de la Marca</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marcas as $marcas): ?>
                <tr>
                    <td>
                        <!-- Botón Modificar que abre el modal -->
                        <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($marcas['id_marca']); ?>">
                        Modificar
                        </button>
                        <br>
                        <!-- Botón Eliminar -->
                        <a href="#" data-id="<?php echo htmlspecialchars($marcas['id_marca']); ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                    <td><?php echo htmlspecialchars($marcas['descripcion_ma']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<!-- Modal de modificación -->
<div class="modal fade" id="modificar_marcas_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_marcas_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarmarcas" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificar_marcas_modal_label">Modificar Marcas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificar_id_marcas" name="id_marca">
                    <div class="form-group">
                        <label for="modificardescripcion_ma">Nombre de la Marca</label>
                        <input type="text" class="form-control" id="modificardescripcion_ma" name="descripcion_ma" required>
                        <span id="smodificardescripcion_ma"></span>
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
               <button type="button" class="btn btn-primary" id="pdfmarcas" name="pdfmarcas"><a href="?pagina=pdfmarcas">GENERAR REPORTE</button>
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
<script src="Javascript/marcas.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>
</html>