<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>

  <title>Gestionar Orden de Despacho</title>
  <?php include 'header.php'; ?>
</head>
<body>


<?php include 'NewNavBar.php'; ?>

<h1>Hola</h1>

<!-- Modal de eliminación -->
<?php include 'footer.php'; ?>
<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/usuario.js"></script>
<script src="Javascript/validaciones.js"></script>
<script src="Javascript/pasarela.js"></script>
<script>
  // Este bloque impide el retroceso y redirige al usuario
  (function () {
    const redirectURL = '?pagina=pasarela'; // <-- cambia esto si quieres otra página

    // Empuja una entrada adicional en el historial
    history.pushState(null, '', location.href);

    // Al presionar el botón atrás (popstate), se redirige
    window.addEventListener('popstate', function () {
      window.location.href = redirectURL;
    });

    // También evita el botón de retroceso en móviles Android
    window.history.forward();
  })();
</script>



</body>


</html>