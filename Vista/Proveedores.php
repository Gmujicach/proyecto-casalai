<?php if ($_SESSION['nombre_rol'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Proveedores</title>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarProveedorModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="incluirproveedor" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarProveedorModalLabel">Incluir Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="grupo-form">
                      <div class="grupo-interno">
                        <label for="nombre_proveedor">Nombre del Proveedor</label>
                        <input type="text" placeholder="Nombre: Proveedor" class="control-form" id="nombre_proveedor" name="nombre_proveedor" maxlength="50" required>
                        <span class="span-value" id="snombre_proveedor"></span>
                      </div>

                      <div class="grupo-interno">
                        <label for="rif_proveedor">RIF del Proveedor</label>                     
                        <input type="text" placeholder="RIF: Proveedor" class="control-form" id="rif_proveedor" name="rif_proveedor" maxlength="12" required>
                        <span class="span-value" id="srif_proveedor"></span>
                      </div>
                    </div>

                    <div class="grupo-form">
                      <div class="grupo-interno">
                        <label for="nombre_representante">Nombre del Representante</label>
                        <input type="text" placeholder="Nombre: Representante" class="control-form" id="nombre_representante" name="nombre_representante" maxlength="50" required>
                        <span class="span-value" id="snombre_representante"></span>
                      </div>

                      <div class="grupo-interno">
                        <label for="rif_representante">RIF del Representante</label>
                        <input type="text" placeholder="RIF: Representante" class="control-form" id="rif_representante" name="rif_representante" maxlength="12" required>
                        <span class="span-value" id="srif_representante"></span>
                      </div>
                    </div>

                    <div class="envolver-form">
                        <label for="correo_proveedor">Correo del Proveedor</label>
                        <input type="text" placeholder="Correo electrónico" class="control-form" id="correo_proveedor" name="correo_proveedor" maxlength="50" required>
                        <span class="span-value" id="scorreo_proveedor"></span>
                    </div>

                    <div class="envolver-form">
                        <label for="direccion_proveedor">Dirección del Proveedor</label>
                        <input type="text" placeholder="Dirección" class="control-form" id="direccion_proveedor" name="direccion_proveedor" rows="3" maxlength="100" required>
                        <span class="span-value" id="sdireccion_proveedor"></span>
                    </div>

                    <div class="grupo-form">
                      <div class="grupo-interno">
                        <label for="telefono_1">Teléfono Principal</label>
                        <input type="text" placeholder="04XX-XXX-XXXX" class="control-form" id="telefono_1" name="telefono_1" maxlength="13" required>
                        <span class="span-value" id="stelefono_1"></span>
                      </div>

                      <div class="grupo-interno">
                        <label for="telefono_2">Teléfono Secundario</label>
                        <input type="text" placeholder="04XX-XXX-XXXX" class="control-form" id="telefono_2" name="telefono_2" maxlength="13" required>
                        <span class="span-value" id="stelefono_2"></span>
                      </div>
                    </div>

                    <div class="envolver-form">
                        <label for="observacion">Observación</label>
                        <textarea class="form-control" placeholder="Escriba alguna observación a tomar en cuenta" id="observacion" name="observacion" maxlength="100" rows="3"></textarea>
                        <span class="span-value" id="sobservacion"></span>
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
        <button id="btnIncluirProveedor" class="btn-incluir">
            Incluir Proveedor
        </button>
    </div>
    <h3>LISTA DE PROVEEDORES</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre del Proveedor</th>
                <th>RIF del Proveedor</th>
                <th>Nombre del Proveedor</th>
                <th>RIF del Representante</th>
                <th>Correo del Proveedor</th>
                <th>Dirección del Proveedor</th>
                <th>Teléfono Principal</th>
                <th>Teléfono Secundario</th>
                <th>Observación</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr data-id="<?php echo $proveedor['id_proveedor']; ?>">
                <td>
                    <ul>
                        <div>
                            <button class="btn-modificar"
                                id="btnModificarProveedor"
                                data-id="<?php echo $proveedor['id_proveedor']; ?>"
                                data-nombre-proveedor="<?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>"
                                data-rif-proveedor="<?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>"
                                data-nombre-representante="<?php echo htmlspecialchars($proveedor['nombre_representante']); ?>"
                                data-rif-representante="<?php echo htmlspecialchars($proveedor['rif_representante']); ?>"
                                data-correo-proveedor="<?php echo htmlspecialchars($proveedor['correo_proveedor']); ?>"
                                data-direccion-proveedor="<?php echo htmlspecialchars($proveedor['direccion_proveedor']); ?>"
                                data-telefono-1="<?php echo htmlspecialchars($proveedor['telefono_1']); ?>"
                                data-telefono-2="<?php echo htmlspecialchars($proveedor['telefono_2']); ?>"
                                data-observacion="<?php echo htmlspecialchars($proveedor['observacion']); ?>"
                                >Modificar
                            </button>
                        </div>
                        <div>
                              <button class="btn-eliminar" 
                              data-id="<?php echo $proveedor['id_proveedor']; ?>">Eliminar</button>
                        </div>
                    </ul>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rif-correo">
                    <?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre_representante']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rif-correo">
                    <?php echo htmlspecialchars($proveedor['rif_representante']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rif-correo">
                    <?php echo htmlspecialchars($proveedor['correo_proveedor']); ?>
                    </span>
                </td> 
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['direccion_proveedor']); ?>
                    </span>
                </td> 
                <td>
                    <span class="campo-numeros">
                    <?php echo htmlspecialchars($proveedor['telefono_1']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-numeros">
                    <?php echo htmlspecialchars($proveedor['telefono_2']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['observacion']); ?>
                    </span>
                </td> 
                <td class="campo-estado">
                    <span 
                      class="campo-estatus <?php echo ($proveedor['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                      data-id="<?php echo $proveedor['id_proveedor']; ?>"
                      style="cursor: pointer;">
                      <?php echo htmlspecialchars($proveedor['estado']); ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="contenedor-tabla">
    <h3>Lista de Productos Con Bajo Stock</h3>
    <table class="tabla" class="tablaConsultas" id="">
        <thead>
            <tr>
                <th>Acción</th>
                <th>ID</th>
                <th>Producto</th>
                <th>Modelo</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No hay productos con bajo stock.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td>
                            <ul>
                                <div>
                                    <button class="btn-pedido" 
                                        id="btnPedidoProducto"
                                        data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                                        data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                                        data-modelo="<?php echo htmlspecialchars($producto['nombre_modelo']); ?>"
                                        data-stockactual="<?php echo htmlspecialchars($producto['stock']); ?>"
                                        data-stockminimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                                    >Realizar Pedido
                                    </button>
                                </div>
                            </ul>
                        </td>
                        <td>
                            <span class="campo-numeros">
                              <?php echo htmlspecialchars($producto['id_producto']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="campo-nombres">
                              <?php echo htmlspecialchars($producto['nombre_producto']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="campo-nombres">
                              <?php echo htmlspecialchars($producto['nombre_modelo']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="campo-stock-actual-negativo">
                              <?php echo htmlspecialchars($producto['stock']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="campo-stock-minimo">
                              <?php echo htmlspecialchars($producto['stock_minimo']); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Reporte estadístico de productos suministrados por proveedor -->
<div class="reporte-container" style="max-width:900px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
    <h3 style="text-align:center; color:#1f66df;">Top 10 Proveedores por Productos Suministrados</h3>
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center;">
        <div style="flex:1; min-width:320px;">
            <canvas id="graficoSuministroProveedores" width="400" height="260"></canvas>
        </div>
        <div style="flex:1; min-width:320px;">
            <table class="table table-bordered table-striped" style="margin:0 auto 32px auto; width:100%;">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Cantidad Suministrada</th>
                        <th>Porcentaje (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reporteSuministroProveedores as $prov): 
                        $porcentaje = $totalSuministrado > 0 ? round(($prov['cantidad'] / $totalSuministrado) * 100, 2) : 0;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($prov['nombre_proveedor']) ?></td>
                            <td><?= $prov['cantidad'] ?></td>
                            <td><?= $porcentaje ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?= $totalSuministrado ?></th>
                        <th>100%</th>
                    </tr>
                </tfoot>
            </table>
            <div style="text-align:center; margin-top:20px;">
                <button id="descargarPDFProveedores" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
                    Descargar Reporte de Suministro
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-modificar" id="modificarProveedorModal" tabindex="-1" role="dialog"
aria-labelledby="modificarProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <form id="FormModificarProveedor" method="POST">
        <div class="modal-header">
          
          <h5 class="titulo-form" id="modificarProveedorModalLabel">Modificar Proveedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="modificar_id_proveedor" name="id_proveedor">
          <input type="hidden" name="accion" value="modificar">

          <div class="form-group">
            <label for="modificar_nombre_proveedor">Nombre del Proveedor</label>
            <input type="text" class="form-control" id="modificar_nombre_proveedor" name="nombre_proveedor" maxlength="50" required>
            <span class="span-value-modal" id="smnombre_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_rif_proveedor">RIF del Proveedor</label>
            <input type="text" class="form-control" id="modificar_rif_proveedor" name="rif_proveedor" maxlength="12" required>
            <span class="span-value-modal" id="smrif_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_nombre_representante">Nombre del Representante</label>
            <input type="text" class="form-control" id="modificar_nombre_representante" name="nombre_representante" maxlength="50" required>
            <span class="span-value-modal" id="smnombre_representante"></span>
          </div>

          <div class="form-group">
            <label for="modificar_rif_representante">RIF del Representante</label>
            <input type="text" class="form-control" id="modificar_rif_representante" name="rif_representante" maxlength="12" required>
            <span class="span-value-modal" id="smrif_representante"></span>
          </div>

          <div class="form-group">
            <label for="modificar_correo_proveedor">Correo</label>
            <input type="email" class="form-control" id="modificar_correo_proveedor" name="correo_proveedor" maxlength="50" required>
            <span class="span-value-modal" id="smcorreo_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_direccion_proveedor">Dirección</label>
            <input type="text" class="form-control" id="modificar_direccion_proveedor" name="direccion_proveedor" maxlength="100" required>
            <span class="span-value-modal" id="smdireccion_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_telefono_1">Teléfono Principal</label>
            <input type="text" class="form-control" id="modificar_telefono_1" name="telefono_1" maxlength="13" required>
            <span class="span-value-modal" id="smtelefono_1"></span>
          </div>

          <div class="form-group">
            <label for="modificar_telefono_2">Teléfono Secundario</label>
            <input type="text" class="form-control" id="modificar_telefono_2" name="telefono_2" maxlength="13" required>
            <span class="span-value-modal" id="smtelefono_2"></span>
          </div>

          <div class="form-group">
            <label for="modificar_observacion">Observación</label>
            <textarea class="form-control" id="modificar_observacion" name="observacion" maxlength="100" rows="3"></textarea>
            <span class="span-value-modal" id="smobservacion"></span>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-modificar" id="PedidoProductoModal" tabindex="-1" role="dialog" 
aria-labelledby="PedidoProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <form id="FormPedidoProducto" method="POST">
        <div class="modal-header">
          <h5 class="titulo-form" id="PedidoProductoModalLabel">Realizar Pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="accion" value="realizar_pedido">
          <input type="hidden" id="modificarIdProducto" name="id_producto">

          <div class="form-group">
            <label for="modificarNombreProducto">Nombre del producto</label>
            <input type="text" maxlength="50" class="form-control" id="modificarNombreProducto" name="nombre_producto" readonly>
          </div>

          <div class="form-group">
            <label for="modificarModelo">Modelo</label>
            <input type="text" maxlength="50" class="form-control" id="modificarModelo" name="modelo" readonly>
          </div>

          <div class="form-group">
            <label for="Proveedor">Proveedor</label>
            <select class="form-select" id="Proveedor" name="proveedor" required>
              <option value="">Seleccionar Proveedor</option>
              <option value="<?php echo $proveedor['id_proveedor']; ?>">
                <?php echo $proveedor['nombre_proveedor']; ?>
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="modificarStockMinimo">Cantidad a Pedir</label>
            <input type="number" min="1" class="form-control" id="modificarStockMinimo" name="cantidad_pedir" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="Javascript/proveedor.js"></script>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
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
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'Public/js/es-ES.json'
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const labelsProveedores = <?= json_encode(array_column($reporteSuministroProveedores, 'nombre_proveedor')) ?>;
const dataProveedores = <?= json_encode(array_column($reporteSuministroProveedores, 'cantidad')) ?>;
const ctxProveedores = document.getElementById('graficoSuministroProveedores').getContext('2d');
console.log(dataProveedores);
new Chart(ctxProveedores, {
    type: 'bar',
    data: {
        labels: labelsProveedores,
        datasets: [{
            label: 'Productos suministrados',
            data: dataProveedores,
            backgroundColor: 'rgba(39, 174, 96, 0.7)',
            borderColor: 'rgba(39, 174, 96, 1)',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Top 10 Proveedores por Productos Suministrados' }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});

document.getElementById('descargarPDFProveedores').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'pt',
        format: 'a4'
    });

    const reporte = document.querySelector('.reporte-container');
    html2canvas(reporte).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pageWidth = doc.internal.pageSize.getWidth();
        const imgWidth = pageWidth - 40;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        doc.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
        doc.save('Reporte_Suministro_Proveedores.pdf');
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