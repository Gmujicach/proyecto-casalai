<?php if ($_SESSION['nombre_rol'] == 'Administrador' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Usuarios</title>
        <?php include 'header.php'; ?>
    </head>

    <body class="fondo"
        style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <?php include 'newnavbar.php'; ?>

        <div class="modal fade modal-registrar" id="registrarUsuarioModal" tabindex="-1" role="dialog"
            aria-labelledby="registrarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="incluirusuario" method="POST">
                        <div class="modal-header">
                            <h5 class="titulo-form" id="registrarUsuarioModalLabel">Incluir Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="grupo-form">
                                <div class="grupo-interno">
                                    <label for="nombre">Nombre de la Persona</label>
                                    <input type="text" placeholder="Nombre" class="control-form" id="nombre" name="nombre"
                                        maxlength="30" required>
                                    <span class="span-value" id="snombre"></span>
                                </div>
                                <div class="grupo-interno">
                                    <label for="apellido_usuario">Apellido de la Persona</label>
                                    <input type="text" placeholder="Apellido" class="control-form" id="apellido_usuario"
                                        name="apellido_usuario" maxlength="30" required>
                                    <span class="span-value" id="sapellido"></span>
                                </div>
                            </div>
                            <div class="envolver-form">
                                <label for="nombre">Nombre de Usuario</label>
                                <input type="text" placeholder="Usuario" class="control-form" id="nombre_usuario"
                                    name="nombre_usuario" maxlength="20" required>
                                <span class="span-value" id="snombre_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="cedula">Número de cédula</label>
                                <input class="control-form" placeholder="Cédula" maxlength="8" type="text" id="cedula" name="cedula" required>
                                <span class="span-value" id="scedula"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="telefono_usuario">Número de Teléfono</label>
                                <input type="text" placeholder="Teléfono" class="control-form" id="telefono_usuario"
                                    name="telefono_usuario" maxlength="13" required>
                                <span class="span-value" id="stelefono_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="correo_usuario">Correo Electrónico</label>
                                <input type="text" placeholder="ejemplo@gmail.com" class="control-form" id="correo_usuario"
                                    name="correo_usuario" maxlength="50" required>
                                <span class="span-value" id="scorreo_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="rango">Rol de Usuario</label>
                                <select class="form-select" id="rango" name="rango">
                                    <option value="" hidden>Seleccione el rol del usuario</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Almacenista</option>
                                    <option value="3">Cliente</option>
                                    <option value="4">Desarrollador</option>
                                </select>
                            </div>
                            <div class="envolver-form">
                                <label for="clave_usuario">Contraseña</label>
                                <input type="password" placeholder="Crea una contraseña" class="control-form"
                                    id="clave_usuario" name="clave_usuario" maxlength="15" required>
                                <span class="span-value" id="sclave_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="clave_confirmar">Confirmar Contraseña</label>
                                <input type="password" placeholder="Ingrese nuevamente la contraseña" class="control-form"
                                    id="clave_confirmar" name="clave_confirmar" maxlength="15" required>
                                <span class="span-value" id="sclave_confirmar"></span>
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
                <button id="btnIncluirUsuario" class="btn-incluir">
                    Incluir Usuario
                </button>
            </div>

            <h3>LISTA DE USUARIOS</h3>

            <table class="tablaConsultas" id="tablaConsultas">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre y Apellido</th>
                        <th>Cédula</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                    </tr>
                </thead>

    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr data-id="<?php echo $usuario['id_usuario']; ?>">
                <td>
                    <ul>
                        <div>
                            <?php if (strtolower($usuario['nombre_rol']) !== 'superusuario'): ?>
                                <button class="btn-modificar" data-id="<?php echo $usuario['id_usuario']; ?>"
                                    data-username="<?php echo htmlspecialchars($usuario['username']); ?>"
                                    data-nombres="<?php echo htmlspecialchars($usuario['nombres']); ?>"
                                    data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                    data-cedula="<?php echo htmlspecialchars($usuario['cedula']); ?>"
                                    data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                    data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                    data-clave="<?php echo htmlspecialchars($usuario['password']); ?>"
                                    data-rango="<?php echo htmlspecialchars($usuario['id_rol']); ?>">
                                    Modificar
                                </button>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (strtolower($usuario['nombre_rol']) !== 'superusuario'): ?>
                                <button class="btn-eliminar"
                                    data-id="<?php echo $usuario['id_usuario']; ?>">Eliminar</button>
                            <?php endif; ?>
                        </div>
                    </ul>
                </td>
                <td>
                    <span class="campo-nombres">
                        <?php echo htmlspecialchars($usuario['nombres']); ?>
                        <?php echo htmlspecialchars($usuario['apellidos']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rif-correo">
                        <?php echo htmlspecialchars($usuario['cedula']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rif-correo">
                        <?php echo htmlspecialchars($usuario['correo']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                        <?php echo htmlspecialchars($usuario['username']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-numeros">
                        <?php echo htmlspecialchars($usuario['telefono']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rango">
                        <?php echo htmlspecialchars($usuario['nombre_rol']); ?>
                    </span>
                </td>
                <td>

                    <span
                        <?php if (strtolower($usuario['nombre_rol']) !== 'superusuario'): ?>
                        class="campo-estatus <?php echo ($usuario['estatus'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>"
                        data-id="<?php echo $usuario['id_usuario']; ?>" style="cursor: pointer;">
                        <?php echo htmlspecialchars($usuario['estatus']); ?>

                            <?php endif; ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
         </table>
        </div>

        <!-- Reporte estadístico de usuarios por rol -->
        <div class="reporte-container"
            style="max-width: 900px; margin: 40px auto; background: #fff; padding: 32px 24px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
            <h2 style="text-align:center;">Reporte de Usuarios por Rol</h2>
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center;">
                <div style="flex:1; min-width:220px; text-align:center;">
                    <div class="grafica-container" style="max-width:220px; margin:0 auto 24px auto;">
                        <canvas id="graficoRoles" width="220" height="220"></canvas>
                    </div>
                </div>
                <div style="flex:2; min-width:320px;">
                    <table class="table table-bordered table-striped" style="margin:0 auto 32px auto; width:100%;">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Cantidad de Usuarios</th>
                                <th>Porcentaje (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reporteRoles)): ?>
                                <?php foreach ($reporteRoles as $rol): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($rol['nombre_rol']) ?></td>
                                        <td><?= $rol['cantidad'] ?></td>
                                        <td><?= $rol['porcentaje'] ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align:center;">No hay datos</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th><?= $totalRoles ?></th>
                                <th>100%</th>
                            </tr>
                            

                        </tfoot>
                    </table>
                </div>
            </div>   
     <div style="text-align:center; margin-top:20px;">
    <button id="descargarPDFUsuarios" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
        Descargar Reporte de Usuarios por Rol
    </button>
</div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.getElementById('descargarPDFUsuarios').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
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
        doc.save('Reporte_Usuarios_Rol.pdf');
    });
});
</script>
        <script>
            const labelsRoles = <?= json_encode(array_column($reporteRoles ?? [], 'nombre_rol')) ?>;
            const dataRoles = <?= json_encode(array_column($reporteRoles ?? [], 'cantidad')) ?>;
            function generarColoresRoles(n) {
                const colores = [];
                for (let i = 0; i < n; i++) {
                    const hue = Math.round((360 / n) * i);
                    colores.push(`hsl(${hue}, 70%, 60%)`);
                }
                return colores;
            }
            const coloresRoles = generarColoresRoles(labelsRoles.length || 1);
            const ctxRoles = document.getElementById('graficoRoles').getContext('2d');
            new Chart(ctxRoles, {
                type: 'pie',
                data: {
                    labels: labelsRoles.length ? labelsRoles : ['Sin datos'],
                    datasets: [{
                        data: dataRoles.length ? dataRoles : [1],
                        backgroundColor: coloresRoles,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: true, position: 'bottom' },
                        title: { display: true, text: 'Distribución de Usuarios por Rol' }
                    }
                }
            });
        </script>

        <div class="modal fade modal-modificar" id="modificar_usuario_modal" tabindex="-1" role="dialog"
            aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="modificarusuario" method="POST">
                        <div class="modal-header titulo-form">
                            <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                            <div class="form-group">
                                <label for="modificarnombre">Nombres del Usuario</label>
                                <input type="text" class="form-control" id="modificarnombre" name="nombre" maxlength="30"
                                    required>
                                <span class="span-value-modal" id="smodificarnombre"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarapellido_usuario">Apellidos del Usuario</label>
                                <input type="text" class="form-control" id="modificarapellido_usuario"
                                    name="apellido_usuario" maxlength="30" required>
                                <span class="span-value-modal" id="smodificarapellido_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarnombre_usuario">Usuario</label>
                                <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario"
                                    maxlength="20" required>
                                <span class="span-value-modal" id="smodificarnombre_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarcedula">Cédula</label>
                                <input type="text" class="form-control" id="modificarcedula" name="cedula" maxlength="8" required>
                                <span class="span-value-modal" id="smodificarcedula"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificartelefono_usuario">Telefono</label>
                                <input type="text" class="form-control" id="modificartelefono_usuario"
                                    name="telefono_usuario" maxlength="13" required>
                                <span class="span-value-modal" id="smodificartelefono_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarcorreo_usuario">Correo</label>
                                <input type="text" class="form-control" id="modificarcorreo_usuario" name="correo_usuario"
                                    maxlength="50" required>
                                <span class="span-value-modal" id="smodificarcorreo_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="rango">Rol de Usuario</label>
                                <select class="form-select form-select-lg mb-3" id="modificar_rango" name="rango">
                                    <option value="" hidden>Seleccione el tipo de usuario a crear</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Almacenista</option>
                                    <option value="3">Cliente</option>
                                    <option value="4">Desarrollador</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Modificar</button>
                        </div>
                </div>

                </form>
            </div>
        </div>
        </div>


        <!-- Modal de eliminación -->
        <?php include 'footer.php'; ?>
        <script src="javascript/usuario.js"></script>
        <script src="public/bootstrap/js/sidebar.js"></script>
        <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="public/js/jquery-3.7.1.min.js"></script>
        <script src="public/js/jquery.dataTables.min.js"></script>
        <script src="public/js/dataTables.bootstrap5.min.js"></script>
        <script src="public/js/datatable.js"></script>
        <script>
            $(document).ready(function () {
                $('#tablaConsultas').DataTable({
                    language: {
                        url: 'public/js/es-ES.json'
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