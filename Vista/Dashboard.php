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

<body>
  <?php include 'NavBar.php'; ?>

  <section class="dashboard-section">
    <img class="dashboard-section" src="IMG/LogoNew.png" alt="">
  </section>

  <?php include 'footer.php'; ?>
  ?>
</body>

</html>