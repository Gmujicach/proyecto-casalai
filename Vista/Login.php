<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      crossorigin="anonymous"
    ></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/login-darckort.css">
    <script src="Public/js/sweetalert2.js"></script>
    <title>Iniciar Sesión</title>
  </head>


<div id="mensajes" style="display:none"
    data-mensaje="<?php echo !empty($mensaje) ? strip_tags($mensaje) : ''; ?>"
    data-tipo="<?php echo (isset($resultado['status']) && $resultado['status'] == 'success') ? 'success' : 'error'; ?>">
</div>

  <body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
      <div class="forms-container">
        <div class="inicio-registro">
          <form method="post" id="f" action="" class="iniciar-sesion-form">

          <input type="text" name="accion" id="accion" style="display:none" />

            <h2 class="title">Iniciar Sesión</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" id="username"  placeholder="Nombre de Usuario" required/>
              <span class="span-value" id="susername"></span>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password"  placeholder="Contraseña" required/>
              <span class="span-value" id="spassword"></span>
            </div>
            <button class="btn btn-vino w-100" id="acceder" name="acceder">Iniciar Sesion</button>
          </form>

<style>
  .registrar-form {
    max-width: 1200px;
    width: 100%;
    margin: auto;
  }

  .input-field,
  .input-row .input-field {
    background: #f0f0f0;
    border-radius: 20px;
    padding: 0 15px;
    display: flex;
    align-items: center;
  }

  .input-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
  }

  .input-row .input-field {
    flex: 1 1 45%;
  }

  .input-row .input-field input, .input-field textarea {
    border: none;
    outline: none;
    background: none;
    padding: 10px;
    width: 100%;
    font-size: 1rem;
  }

  .input-row .input-field i {
    margin-right: 8px;
    color: #888;
  }

  .input-row .btn:hover {
    background: #357abd;
  }

  textarea.form-control {
    resize: none;
    border-radius: 20px;
    padding: 10px 20px;
    border: none;
    background: #f0f0f0;
    margin-bottom: 5px;
  }
</style>

<form method="post" id="registro-usuario-cliente" class="registrar-form">
  <h2 class="title">Registro</h2>

  <div class="input-row">
    <div class="input-field">
      <i class="fas fa-user"></i>
      <input type="text" name="nombre" id="nombre" placeholder="Nombre" maxlength="30" required />
      <span class="span-value" id="snombre"></span>
    </div>
    <div class="input-field">
      <i class="fas fa-user"></i>
      <input type="text" name="apellido" id="apellido" placeholder="Apellido" maxlength="30" required />
      <span class="span-value" id="sapellido"></span>
    </div>
  </div>

  <div class="input-row">
    <div class="input-field">
      <i class="fas fa-phone"></i>
      <input type="text" name="nombre_usuario" id="nombre_usuario" placeholder="Nombre de Usuario" maxlength="20" required />
      <span class="span-value" id="snombre_usuario"></span>
    </div>
    <div class="input-field">
      <i class="fas fa-envelope"></i>
      <input type="text" name="cedula" id="cedula" placeholder="Cédula/RIF" maxlength="12" required />
      <span class="span-value" id="scedula"></span>
    </div>
  </div>

  <div class="input-row">
    <div class="input-field">
      <i class="fas fa-phone"></i>
      <input type="text" name="telefono" id="telefono" placeholder="Teléfono" maxlength="13" required />
      <span class="span-value" id="stelefono_usuario"></span>
    </div>
    <div class="input-field">
      <i class="fas fa-envelope"></i>
      <input type="email" name="correo" id="correo" placeholder="Correo Electrónico" maxlength="50" required />
      <span class="span-value" id="scorreo_usuario"></span>
    </div>
  </div>

  <label for="direccion" style="color:#888; font-size:18px;">Dirección</label>
  <textarea class="form-control" maxlength="100" id="direccion" name="direccion" rows="2" required></textarea>
  <span class="span-value" id="sdireccion"></span>

  <div class="input-row">
    <div class="input-field">
      <i class="fas fa-lock"></i>
      <input type="password" name="clave" id="clave" placeholder="Contraseña" maxlength="15" required />
      <span class="span-value" id="sclave_usuario"></span>
    </div>
    <div class="input-field">
      <i class="fas fa-lock"></i>
      <input type="password" name="clave_confirmar" id="clave_confirmar" placeholder="Confirmar Contraseña" maxlength="15" required />
      <span class="span-value" id="sclave_confirmar"></span>
    </div>
  </div>

  <div class="input-row">
    <button type="submit" class="btn btn-vino w-100">Registrar</button>
  </div>
  <input type="hidden" name="accion" value="registrar" />
</form>

        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>¿Aun no te has registrado?</h3>
            <p>
              
            </p>
            <button class="btn transparent" id="registrar-btn">
              Registrate
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
              Iniciar Sesión
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