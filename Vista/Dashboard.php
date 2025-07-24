<?php
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['name'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header('Location: .');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <?php include 'header.php'; ?>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;"> 
   <?php include 'newnavbar.php'; ?>
       <?php
        // Define los grupos de módulos y su icono
        $grupos = [
            'Administrar Perfiles' => [
                'modulos' => ['Usuario'],
                'icon' => 'img/users-round.svg',
                'color' => '#4e73df'
            ],
            'Administrar Inventario' => [
                'modulos' => ['Recepcion', 'Despacho'],
                'icon' => 'img/package-open.svg',
                'color' => '#1cc88a'
            ],
            'Administrar Productos' => [
                'modulos' => ['Marcas', 'Modelos', 'Productos', 'Categorias'],
                'icon' => 'img/package-search.svg',
                'color' => '#36b9cc'
            ],
            'Administrar Proveedores' => [
                'modulos' => ['Proveedores'],
                'icon' => 'img/truck.svg',
                'color' => '#f6c23e'
            ],
            'Administrar Clientes' => [
                'modulos' => ['Clientes'],
                'icon' => 'img/users-round.svg',
                'color' => '#e74a3b'
            ],
            'Administrar Ventas' => [
                'modulos' => ['Catalogo', 'comprafisica', 'carrito', 'pasarela', 'Prefactura', 'Ordenes de despacho'],
                'icon' => 'img/shopping-cart.svg',
                'color' => '#858796'
            ],
            'Administrar Finanzas' => [
                'modulos' => ['Cuentas bancarias', 'Finanzas'],
                'icon' => 'img/dollar-sign.svg',
                'color' => '#20c997'
            ],
            'Administrar Seguridad' => [
                'modulos' => ['permisos', 'Roles', 'bitacora', 'Respaldo'],
                'icon' => 'img/key-round.svg',
                'color' => '#fd7e14'
            ],
        ];
        ?>
  
<div class="container" style="max-width:1200px; margin:40px auto;">
    <h2 style="text-align:center; color:#1f66df; margin-bottom:32px;">Panel Principal</h2>
    <div class="row" style="display:flex; flex-wrap:wrap; gap:32px; justify-content:center;">
        <?php
        foreach ($grupos as $grupo => $info) {
            $modulosPermitidos = [];
            foreach ($info['modulos'] as $mod) {
                if (!empty($permisosConsulta[$mod])) {
                    $modulosPermitidos[] = $mod;
                }
            }
            if (count($modulosPermitidos) > 0) {
                $icono = $info['icon'];
                $color = $info['color'];
        ?>
        <div class="card-dashboard" style="flex:1 1 260px; min-width:260px; max-width:320px; background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.08); padding:32px 24px; text-align:center; border-top:6px solid <?php echo $color; ?>;">
            <img src="<?php echo $icono; ?>" alt="icono" style="width:56px; height:56px; margin-bottom:18px;">
            <h4 style="color:<?php echo $color; ?>; margin-bottom:12px;"><?php echo htmlspecialchars($grupo); ?></h4>
            <div style="min-height:40px; color:#444; margin-bottom:16px;">
                <?php
                foreach ($modulosPermitidos as $modulo) {
                    $nombreModulo = $modulos[$modulo][0];
                    $urlModulo = $modulos[$modulo][2];
                ?>
                    <a href="<?php echo $urlModulo; ?>" class="btn btn-primary" style="margin:6px 4px 0 4px; background:<?php echo $color; ?>; border:none;">
                        Ir a <?php echo htmlspecialchars($nombreModulo); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>
</div>
  <?php include 'footer.php'; ?>
  <script>
    const sesion = <?php echo json_encode($_SESSION); ?>;
    console.log('Sesión actual:', sesion);
</script>
</body>
</html>