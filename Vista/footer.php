<script>
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const body = document.querySelector("body");

  // Mostrar menú cuando el mouse está sobre él
  sidebar.addEventListener("mouseenter", function () {
    sidebar.classList.add("active");
  });

  // Ocultar menú cuando se da clic fuera de él
  body.addEventListener("click", function (event) {
    if (!sidebar.contains(event.target)) {
      sidebar.classList.remove("active");
    }
  });
});
</script>

<script src="Javascript/tabla.js"></script>

<!-- Footer de la página -->
<footer class="footer text-center text-lg-start bg-light text-muted">
  <div class="text-center p-4" style="background-color: #f1f1f1;">
    © 2023 Copyright: CasaLai C.A/ Paula R - Braynt M - Simon C - Diego C - Gabriel C
    <!-- Bootstrap JS -->
  <script src='Public/bootstrap/js/bootstrap.bundle.min.js'></script>
  <script src="Javascript/validaciones.js"></script>
  <script src="Public/bootstrap/js/sidebar.js"></script>
  <script src="Public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Public/js/jquery-3.7.1.min.js"></script>
  <script src="Public/js/jquery.dataTables.min.js"></script>
  <script src="Public/js/dataTables.bootstrap5.min.js"></script>
  <script src="Public/js/datatable.js"></script>
  <script src="Public/js/sweetalert2.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  