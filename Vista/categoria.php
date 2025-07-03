<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario' || $_SESSION['nombre_rol'] == 'Almacenista') { ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Categoria</title>
        <?php include 'header.php'; ?>
        <style>
  .caracteristica-item {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: flex-end;
  }
  .caracteristica-item input,
  .caracteristica-item select {
    flex: 1;
  }
  .caracteristica-item .btn-eliminar {
    flex: 0 0 auto;
  }
</style>
    </head>

    <body class="fondo"
        style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <?php include 'NewNavBar.php'; ?>

        <div class="modal fade modal-registrar" id="registrarCategoriaModal" tabindex="-1" role="dialog"
            aria-labelledby="registrarCategoriaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="registrarCategoria" method="POST">
                        <div class="modal-header">
                            <h5 class="titulo-form" id="registrarCategoriaModalLabel">Incluir Categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="accion" value="registrar">

                            <!-- Nombre de la categoría -->
                            <div class="envolver-form">
                                <label for="nombre_categoria">Nombre de la categoría</label>
                                <input type="text" placeholder="Categoría" class="control-form" id="nombre_categoria"
                                    name="nombre_categoria" maxlength="20" required>
                                <span class="span-value" id="snombre_categoria"></span>
                            </div>

                            <!-- Características dinámicas -->
                            <div class="envolver-form">
                                <label>Características</label>
                                <div id="caracteristicasContainer"></div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="agregarCaracteristica">+
                                    Agregar característica</button>
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
                <button id="btnIncluirCategoria" class="btn-incluir">
                    Incluir Categoria
                </button>
            </div>

            <h3>Lista de Categorias</h3>

            <table class="tablaConsultas" id="tablaConsultas">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr data-id="<?php echo $categoria['id_categoria']; ?>">
                            <td>
                                <ul>
                                    <div>
                                        <button class="btn-modificar"
                                            id="btnModificarCategoria"
                                            data-id="<?php echo $categoria['id_categoria']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($categoria['nombre_categoria']); ?>">Modificar</button>
                                    </div>
                                    <div>
                                        <button class="btn-eliminar"
                                            data-id="<?php echo $categoria['id_categoria']; ?>">Eliminar</button>
                                    </div>
                                </ul>
                            </td>
                            <td>
                                <span class="campo-numeros">
                                    <?php echo htmlspecialchars($categoria['id_categoria']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="campo-nombres">
                                    <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<div class="modal fade modal-modificar" id="modificarCategoriaModal" tabindex="-1" role="dialog"
    aria-labelledby="modificarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarCategoria" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarCategoriaModalLabel">Modificar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_categoria" name="id_categoria">
                    <div class="form-group">
                        <label for="modificar_nombre_categoria">Nombre de la categoría</label>
                        <input type="text" class="form-control" id="modificar_nombre_categoria"
                            name="nombre_categoria" maxlength="20" required>
                        <span class="span-value-modal" id="smnombre_categoria"></span>
                    </div>
                    <div class="form-group">
                        <label>Características</label>
                        <div id="modificar_caracteristicasContainer"></div>
                        <button type="button" class="btn btn-sm btn-success mt-2" id="modificar_agregarCaracteristica">
                            + Agregar característica
                        </button>
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
        <script src="Javascript/categoria.js"></script>
        <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="public/js/jquery-3.7.1.min.js"></script>
        <script src="public/bootstrap/js/sidebar.js"></script>
        <script src="public/js/jquery.dataTables.min.js"></script>
        <script src="public/js/dataTables.bootstrap5.min.js"></script>
        <script src="public/js/datatable.js"></script>
        <script>
            $(document).ready(function () {
                $('#tablaConsultas').DataTable({
                    language: {
                        url: 'Public/js/es-ES.json'
                    }
                });
            });
        </script>
        <script>
document.addEventListener('DOMContentLoaded', () => {
  const contenedor = document.getElementById('caracteristicasContainer');
  const btnAgregar = document.getElementById('agregarCaracteristica');

  let contador = 0;
  const maxCaracteristicas = 5;

  const crearInputCaracteristica = (id, puedeEliminar = true) => {
    const div = document.createElement('div');
    div.classList.add('caracteristica-item');
    div.dataset.index = id;

div.innerHTML = `
  <input type="text" name="caracteristicas[${id}][nombre]" placeholder="Nombre" class="form-control" maxlength="20" required>
  <select name="caracteristicas[${id}][tipo]" class="form-select" required>
    <option value="" disable hidden>Tipo</option>
    <option value="int">Entero</option>
    <option value="float">Decimal</option>
    <option value="string">Texto</option>
  </select>
  <input type="number" name="caracteristicas[${id}][max]" placeholder="Máx. caracteres" class="form-control" min="1" max="255" style="display:none;" required>
  ${puedeEliminar ? `<button type="button" class="btn btn-danger btn-eliminar-caracteristicas">✖</button>` : ''}
`;

// Mostrar/ocultar el input de max solo si es tipo string
const selectTipo = div.querySelector('select[name="caracteristicas[' + id + '][tipo]"]');
const inputMax = div.querySelector('input[name="caracteristicas[' + id + '][max]"]');
selectTipo.addEventListener('change', function() {
  if (this.value === 'string') {
    inputMax.style.display = '';
    inputMax.required = true;
  } else {
    inputMax.style.display = 'none';
    inputMax.required = false;
    inputMax.value = '';
  }
});

    if (puedeEliminar) {
      div.querySelector('.btn-eliminar-caracteristicas').addEventListener('click', () => {
        contenedor.removeChild(div);
        contador--;
        btnAgregar.disabled = false;
      });
    }

    contenedor.appendChild(div);
  };

  // Agrega una característica inicial no eliminable
  crearInputCaracteristica(contador++, false);

  btnAgregar.addEventListener('click', () => {
    if (contador < maxCaracteristicas) {
      crearInputCaracteristica(contador++);
      if (contador === maxCaracteristicas) {
        btnAgregar.disabled = true;
      }
    }
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
