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

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/BannerCasaLai.png); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <?php include 'NewNavBar.php'; ?>

  <?php include 'footer.php'; ?>
</body>
</html>