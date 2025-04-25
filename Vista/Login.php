<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/login-darckort.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Iniciar Sesion</title>
  </head>

  <div id="mensajes" style="display:none" 
data-mensaje="<?php echo !empty($mensaje) ? $mensaje : ''; ?>">
</div>

  <body>
    <div class="container">
      <div class="forms-container">
        <div class="inicio-registro">
          <form method="post" id="f" action="" class="iniciar-sesion-form">

          <input type="text" name="accion" id="accion" style="display:none" />

            <h2 class="title">Iniciar Sesion</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" id="username"  placeholder="Nombre Usuario" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password"  placeholder="Contraseña" required/>
            </div>
            <button class="btn btn-vino w-100" id="acceder" name="acceder">Iniciar Sesion</button>
            <p class="social-text">Siguenos en nuestras Redes Sociales</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
            </div>
          </form>



          <form action="#" class="registrar-form">
            <h2 class="title">Registrarse</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Nombre de Usuario" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Correo Electrónico" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Contraseña" />
            </div>
            <input type="submit" class="btn" value="Registrarse" />
            <p class="social-text">Síguenos en nuestras Redes Sociales</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>¿Aun no te Registrar?</h3>
            <p>
              
            </p>
            <button class="btn transparent" id="registrar-btn">
              Registrar
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>¿Ya Tienes una Cuenta?</h3>
            <p>
              
            </p>
            <button class="btn transparent" id="iniciar-sesion-btn">
              Iniciar Sesion
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="Javascript/darckort-login.js"></script>
    <script src="Javascript/login.js"></script>
  </body>
</html>