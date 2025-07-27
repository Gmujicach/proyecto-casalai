<div class="top-bar">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid" style="background: linear-gradient(135deg, #5f6dfd 0%, #3a4af0 100%); padding: 0.5rem 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <!-- Contenedor izquierdo con logo y botón Registrar -->
            <div class="d-flex align-items-center" style="flex-grow: 1;">

                
                <!-- Logo y nombre -->
                <a class="navbar-brand d-flex align-items-center" href="#" style="margin-left: 15px;">
                    <img src="img/logotipo.png" alt="Logo" width="50" height="40" style="margin-right: 12px; filter: brightness(0) invert(1);">
                    <h3 style="color: white; margin: 0; font-size: 1.4rem; font-weight: 500;">Bienvenido a Casa Lai Tu Tienda Virtual</h3>
                </a>
            </div>

            <!-- Menú colapsable -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="?pagina=login">
                        <button class="btn btn-outline-light"  style="border-radius: 8px; padding: 8px 20px; font-weight: 500;">
                            <i class="fas fa-sign-in-alt me-2" "></i>Ingresar
                        </button>
                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Estilos adicionales -->
<style>
    .navbar {
        transition: all 0.3s ease;
    }
    
    .btn-outline-light:hover {
        background-color: rgba(255,255,255,0.2);
    }
    
    .navbar-brand:hover {
        opacity: 0.9;
    }
    
    .top-bar {
        position: sticky;
        top: 0;
        z-index: 1030;
    }
</style>

<!-- Scripts (asegúrate de tener Font Awesome para los íconos) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="public/js/jquery.min.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="javascript/js/bootstrap.min.js"></script>

<script>
    // Efecto de scroll para el navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 10) {
            navbar.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        } else {
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        }
    });
</script>