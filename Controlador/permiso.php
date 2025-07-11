<?php
require_once __DIR__ . '/../modelo/permiso.php';
require_once __DIR__ . '/../modelo/usuario.php';

$permisos = new Permisos();

// Obtener roles
$roles = $permisos->getRoles();

// Obtener módulos
$modulos_permiso = $permisos->getModulos();

// Acciones posibles
$acciones = ['ingresar','consultar', 'incluir', 'modificar', 'eliminar','reportar'];

// Obtener permisos actuales (por rol y módulo)
$permisosActuales = $permisos->getPermisosPorRolModulo();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardarPermisos'])) {
    $permisos->guardarPermisos($_POST['permisos'] ?? [], $roles, $modulos_permiso, $acciones);
    header("Location: ?pagina=permiso&ok=1");
    exit;
}

$pagina = "permiso";
if (is_file("vista/" . $pagina . ".php")) {
    require_once("vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}