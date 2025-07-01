
<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Permisos</title>
    <?php include 'header.php'; ?>
    <style>
        .rol-selector button {
            margin: 0 8px 12px 0;
            padding: 8px 18px;
            border-radius: 6px;
            border: 1px solid #2980b9;
            background: #fff;
            color: #2980b9;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .rol-selector button.active,
        .rol-selector button:hover {
            background: #2980b9;
            color: #fff;
        }
        .tabla-permisos-rol { display: none; }
        .tabla-permisos-rol.active { display: block; }
    </style>
</head>
<body class="fondo" style="height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div style="display:flex; flex-direction:column; align-items:center; min-height:70vh;">
    <form method="post" action="" style="background:rgba(255,255,255,0.97); padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08); margin: 30px 0; width: 100%; max-width: 1100px;">
        <h2 style="text-align:center;">Gestión de Permisos por Rol</h2>
        
        <!-- Selector de roles -->
   
<!-- Selector de roles -->
<div class="rol-selector" style="text-align:center; margin-bottom:18px;">
    <?php
$rolesSinSuper = array_filter($roles, function($rol) {
    return str_replace(' ', '', strtolower($rol['nombre_rol'])) !== 'superusuario';
});
$rolesSinSuper = array_values($rolesSinSuper); // Reindexar

    foreach ($rolesSinSuper as $i => $rol): ?>
        <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-rol="<?= $rol['id_rol'] ?>">
            <?= htmlspecialchars($rol['nombre_rol']) ?>
        </button>
    <?php endforeach; ?>
</div>

<!-- Tablas de permisos por rol -->
<div style="max-height: 60vh; overflow-y: auto;">
    <?php foreach ($rolesSinSuper as $i => $rol): ?>
        <div class="tabla-permisos-rol<?= $i === 0 ? ' active' : '' ?>" id="tabla-rol-<?= $rol['id_rol'] ?>">
            <h4 style="text-align:center; color:#2980b9;"><?= htmlspecialchars($rol['nombre_rol']) ?></h4>
            <table border="1" cellpadding="6" style="margin:0 auto; min-width:400px; text-align:center;">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <?php foreach (['consultar','incluir','modificar','eliminar'] as $accion): ?>
                            <th><?= ucfirst($accion) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modulos as $modulo): ?>
                        <tr>
                            <td><?= htmlspecialchars($modulo['nombre_modulo']) ?></td>
                            <?php foreach (['consultar','incluir','modificar','eliminar'] as $accion): ?>
                                <td>
                                    <input type="checkbox"
                                        name="permisos[<?= $rol['id_rol'] ?>][<?= $modulo['id_modulo'] ?>][<?= $accion ?>]"
                                        <?= isset($permisosActuales[$rol['id_rol']][$modulo['id_modulo']][$accion]) ? 'checked' : '' ?>>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>
        <div style="text-align:center;">
            <button type="submit" name="guardarPermisos" class="btn btn-primary">Guardar Permisos</button>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.rol-selector button').forEach(btn => {
    btn.addEventListener('click', function() {
        // Quitar clase active a todos los botones y tablas
        document.querySelectorAll('.rol-selector button').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tabla-permisos-rol').forEach(tabla => tabla.classList.remove('active'));
        // Activar el seleccionado
        this.classList.add('active');
        document.getElementById('tabla-rol-' + this.dataset.rol).classList.add('active');
    });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>