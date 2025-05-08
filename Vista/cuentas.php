<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Cuentas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Consultar Cuentas</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#registrarModal">Registrar Cuenta</button>
        <table class="table table-bordered" id="cuentasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Banco</th>
                    <th>Número de Cuenta</th>
                    <th>RIF</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal para Registrar Cuenta -->
    <div class="modal fade" id="registrarModal" tabindex="-1" role="dialog" aria-labelledby="registrarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrarModalLabel">Registrar Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formRegistrar">
                        <div class="form-group">
                            <label for="nombre_banco">Nombre del Banco</label>
                            <input type="text" class="form-control" id="nombre_banco" required>
                        </div>
                        <div class="form-group">
                            <label for="numero_cuenta">Número de Cuenta</label>
                            <input type="text" class="form-control" id="numero_cuenta" required>
                        </div>
                        <div class="form-group">
                            <label for="rif_cuenta">RIF</label>
                            <input type="text" class="form-control" id="rif_cuenta" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono_cuenta">Teléfono</label>
                            <input type="text" class="form-control" id="telefono_cuenta" required>
                        </div>
                        <div class="form-group">
                            <label for="correo_cuenta">Correo</label>
                            <input type="email" class="form-control" id="correo_cuenta" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Modificar Cuenta -->
    <div class="modal fade" id="modificarModal" tabindex="-1" role="dialog" aria-labelledby="modificarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarModalLabel">Modificar Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formModificar">
                        <input type="hidden" id="id_cuenta_modificar">
                        <div class="form-group">
                            <label for="nombre_banco_modificar">Nombre del Banco</label>
                            <input type="text" class="form-control" id="nombre_banco_modificar" required>
                        </div>
                        <div class="form-group">
                            <label for="numero_cuenta_modificar">Número de Cuenta</label>
                            <input type="text" class="form-control" id="numero_cuenta_modificar" required>
                        </div>
                        <div class="form-group">
                            <label for="rif_cuenta_modificar">RIF</label>
                            <input type="text" class="form-control" id="rif_cuenta_modificar" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono_cuenta_modificar">Teléfono</label>
                            <input type="text" class="form-control" id="telefono_cuenta_modificar" required>
                        </div>
                        <div class="form-group">
                            <label for="correo_cuenta_modificar">Correo</label>
                            <input type="email" class="form-control" id="correo_cuenta_modificar" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="Javascript/cuentas.js"></script>
</body>
</html>