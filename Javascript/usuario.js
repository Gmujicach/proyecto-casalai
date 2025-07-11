$(document).ready(function () {
  if ($.trim($("#mensajes").text()) != "") {
    mensajes("warning", 4000, "Atención", $("#mensajes").html());
  }

  $("#nombre").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
    let nombre = document.getElementById("nombre");
    nombre.value = space(nombre.value);
  });
  $("#nombre").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,30}$/,
      $(this),
      $("#snombre"),
      "*Solo letras, de 2 a 30 caracteres*"
    );
  });

  $("#apellido_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
    let apellido_usuario = document.getElementById("apellido_usuario");
    apellido_usuario.value = space(apellido_usuario.value);
  });
  $("#apellido_usuario").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
      $(this),
      $("#sapellido"),
      "*Solo letras, de 2 a 30 caracteres*"
    );
  });

  $("#nombre_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-Z0-9_]*$/, e);
  });
  $("#nombre_usuario").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-Z0-9_]{4,15}$/,
      $(this),
      $("#snombre_usuario"),
      "*El usuario debe tener entre 4 y 15 caracteres alfanuméricos*"
    );
  });

  $("#cedula").on("keypress", function(e){
      validarKeyPress(/^[0-9]*$/, e);
  });

  $("#cedula").on("keyup", function(){
      validarKeyUp(
          /^[0-9]{7,8}$/,
          $(this),
          $("#scedula"),
          "*El formato solo permite números*"
      );
  });

  $("#telefono_usuario").on("keypress", function (e) {
    validarKeyPress(/^[0-9-]*$/, e);
  });

  $("#telefono_usuario").on("keyup", function () {
    validarKeyUp(
      /^\d{4}-\d{3}-\d{4}$/,
      $(this),
      $("#stelefono_usuario"),
      "*Formato válido: 04XX-XXX-XXXX*"
    );
  });

  $("#telefono_usuario").on("input", function() {
      let valor = $(this).val().replace(/\D/g, '');
      if(valor.length > 4 && valor.length <= 7)
          valor = valor.slice(0,4) + '-' + valor.slice(4);
      else if(valor.length > 7)
          valor = valor.slice(0,4) + '-' + valor.slice(4,7) + '-' + valor.slice(7,11);
      $(this).val(valor);
  });

  $("#correo_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
  });

  $("#correo_usuario").on("keyup", function () {
    validarKeyUp(
      /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      $(this),
      $("#scorreo_usuario"),
      "*Formato válido: example@gmail.com*"
    );
  });

  $("#clave_usuario").on("keypress", function (e) {
    validarKeyPress(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]*$/, e);
  });
  $("#clave_usuario").on("keyup", function () {
    validarKeyUp(
      /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
      $(this),
      $("#sclave_usuario"),
      "*Solo letras y números, de 6 a 15 caracteres*"
    );
  });

  $("#clave_confirmar").on("keypress", function (e) {
    validarKeyPress(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]*$/, e);
  });
  $("#clave_confirmar").on("keyup", function () {
    validarKeyUp(
      /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
      $(this),
      $("#sclave_confirmar"),
      "*Solo letras y números, de 6 a 15 caracteres*"
    );
  });
function verificarPermisosEnTiempoRealUsuarios() {
    var datos = new FormData();
    datos.append('accion', 'permisos_tiempo_real');
    enviarAjax(datos, function(permisos) {
        // Si no tiene permiso de consultar
        if (!permisos.consultar) {
            $('#tablaConsultas').hide();
            $('.space-btn-incluir').hide();
            if ($('#mensaje-permiso').length === 0) {
                $('.contenedor-tabla').prepend('<div id="mensaje-permiso" style="color:red; text-align:center; margin:20px 0;">No tiene permiso para consultar los registros.</div>');
            }
            return;
        } else {
            $('#tablaConsultas').show();
            $('.space-btn-incluir').show();
            $('#mensaje-permiso').remove();
        }

        // Mostrar/ocultar botón de incluir
        if (permisos.incluir) {
            $('#btnIncluirUsuario').show();
        } else {
            $('#btnIncluirUsuario').hide();
        }

        // Mostrar/ocultar botones de modificar/eliminar
        $('.btn-modificar').each(function() {
            if (permisos.modificar) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('.btn-eliminar').each(function() {
            if (permisos.eliminar) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Ocultar columna Acciones si ambos permisos son falsos
        if (!permisos.modificar && !permisos.eliminar) {
            $('#tablaConsultas th:first-child, #tablaConsultas td:first-child').hide();
        } else {
            $('#tablaConsultas th:first-child, #tablaConsultas td:first-child').show();
        }
    });
}

// Llama la función al cargar la página y luego cada 10 segundos
$(document).ready(function() {
    verificarPermisosEnTiempoRealUsuarios();
    setInterval(verificarPermisosEnTiempoRealUsuarios, 10000); // 10 segundos
});
  function validarEnvioUsuario() {
    let valido = true;

    let nombre = $("#nombre");
    nombre.val(space(nombre.val()).trim());
    if (
      validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
        nombre,
        $("#snombre"),
        "*Solo letras, de 2 a 30 caracteres*"
      ) == 0
    ) {
      valido = false;
    }

    let apellido_usuario = $("#apellido");
    apellido_usuario.val(space(apellido_usuario.val()).trim());
    if (
      validarKeyUp(
        /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
        apellido_usuario,
        $("#sapellido"),
        "*Solo letras, de 2 a 30 caracteres*"
      ) == 0
    ) {
      valido = false;
    }

    let nombre_usuario = $("#nombre_usuario");
    nombre_usuario.val(space(nombre_usuario.val()).trim());
    if (
      validarKeyUp(
        /^[a-zA-Z0-9_]{4,15}$/,
        nombre_usuario,
        $("#snombre_usuario"),
        "*El usuario debe tener entre 4 y 15 caracteres alfanuméricos*"
      ) == 0
    ) {
      valido = false;
    }

    else if(validarKeyUp(
        /^[0-9]{7,8}$/,
        $("#cedula"),
        $("#scedula"),
        "*El formato solo permite números*"
    )==0){
        mensajes('error',4000,'Verifique el número de cédula','El formato solo permite números');
        return false;
    }

    let telefono_usuario = $("#telefono_usuario");
    if (
      validarKeyUp(
        /^\d{4}-\d{3}-\d{4}$/,
        telefono_usuario,
        $("#stelefono_usuario"),
        "*Formato válido: 04XX-XXX-XXXX*"
      ) == 0
    ) {
      valido = false;
    }

    let correo_usuario = $("#correo_usuario");
    if (
      validarKeyUp(
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        correo_usuario,
        $("#scorreo_usuario"),
        "*Formato válido: example@gmail.com*"
      ) == 0
    ) {
      valido = false;
    }

    let clave_usuario = $("#clave_usuario");
    if (
      validarKeyUp(
        /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
        clave_usuario,
        $("#sclave_usuario"),
        "*Solo letras y números, de 6 a 15 caracteres*"
      ) == 0
    ) {
      valido = false;
    }

    let clave_confirmar = $("#clave_confirmar");
    if (
      validarKeyUp(
        /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
        clave_confirmar,
        $("#sclave_confirmar"),
        "*Solo letras y números, de 6 a 15 caracteres*"
      ) == 0
    ) {
      valido = false;
    }

    if (clave_usuario.val() !== clave_confirmar.val()) {
      $("#sclave_confirmar").text("*Las contraseñas no coinciden*");
      valido = false;
    }

    // VALIDACIÓN DEL TIPO DE USUARIO
    let rango = $("#rango");
    if (!rango.val()) {
      rango.addClass("is-invalid");
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Debe seleccionar el ROL de usuario a crear",
      });
      return false; // Detener aquí para que no muestre el mensaje general
    } else {
      rango.removeClass("is-invalid");
    }

    if (!valido) {
      mensajes(
        "error",
        4000,
        "Verifique los campos",
        "Corrija los errores antes de continuar"
      );
    }
    return valido;
  }

function agregarFilaUsuario(usuario) {
    const tabla = $("#tablaConsultas").DataTable();
    const nuevaFila = [
      `<ul>
            <div>
                <button class="btn-modificar"
                    data-id="${usuario.id_usuario}"
                    data-username="${usuario.username}"
                    data-nombres="${usuario.nombres}"
                    data-apellidos="${usuario.apellidos}"
                    data-cedula="${usuario.cedula}"
                    data-correo="${usuario.correo}"
                    data-telefono="${usuario.telefono}"
                    data-clave=""
                    data-rango="${usuario.id_rol}">
                    Modificar
                </button>
            </div>
            <div>
                <button class="btn-eliminar"
                    data-id="${usuario.id_usuario}">
                    Eliminar
                </button>
            </div>
        </ul>`,
      `<span class="campo-nombres">${usuario.nombres} ${usuario.apellidos}</span>`,
      `<span class="campo-cedula">${usuario.cedula}</span>`,
      `<span class="campo-correo">${usuario.correo}</span>`,
      `<span class="campo-usuario">${usuario.username}</span>`,
      `<span class="campo-telefono">${usuario.telefono}</span>`,
      `<span class="campo-rango">${usuario.nombre_rol}</span>`,
      `<span class="campo-estatus habilitado" data-id="${usuario.id_usuario}" style="cursor: pointer;">
            habilitado
        </span>`,
    ];
    const rowNode = tabla.row.add(nuevaFila).draw(false).node();
    $(rowNode).attr("data-id", usuario.id_usuario);
}

  function resetUsuario() {
    $("#nombre").val("");
    $("#snombre").text("");
    $("#apellido").val("");
    $("#sapellido").text("");
    $("#nombre_usuario").val("");
    $("#snombre_usuario").text("");
    $("#cedula").val("");
    $("#scedula").text("");
    $("#telefono_usuario").val("");
    $("#stelefono_usuario").text("");
    $("#correo_usuario").val("");
    $("#scorreo_usuario").text("");
    $("#clave_usuario").val("");
    $("#sclave_usuario").text("");
    $("#clave_confirmar").val("");
    $("#sclave_confirmar").text("");
  }

  $("#btnIncluirUsuario").on("click", function () {
    $("#incluirusuario")[0].reset();
    $("#snombre").text("");
    $("#sapellido").text("");
    $("#snombre_usuario").text("");
    $("#scedula").text("");
    $("#scorreo_usuario").text("");
    $("#stelefono_usuario").text("");
    $("#sclave_usuario").text("");
    $("#sclave_confirmar").text("");
    $("#registrarUsuarioModal").modal("show");
  });

  $("#incluirusuario").on("submit", function (e) {
    e.preventDefault();
    if (validarEnvioUsuario()) {
      var datos = new FormData(this);
      datos.append("accion", "registrar");
      enviarAjax(datos, function (respuesta) {
        if (respuesta.status === "success" && respuesta.usuario) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: respuesta.message || "Usuario registrado correctamente",
          });
          agregarFilaUsuario(respuesta.usuario);
          resetUsuario();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: respuesta.message || "No se pudo registrar el usuario",
          });
        }
      });
    }
  });

  $(document).on("click", "#registrarUsuarioModal .close", function () {
    $("#registrarUsuarioModal").modal("hide");
  });

  function enviarAjax(datos, callback) {
    $.ajax({
      url: "",
      type: "POST",
      data: datos,
      contentType: false,
      processData: false,
      cache: false,
      success: function (respuesta) {
        if (typeof respuesta === "string") {
          respuesta = JSON.parse(respuesta);
        }
        if (callback) callback(respuesta);
      },
      error: function () {
        Swal.fire("Error", "Error en la solicitud AJAX", "error");
      },
    });
  }

  $("#modificarnombre").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
    let nombre = document.getElementById("modificarnombre");
    nombre.value = space(nombre.value);
  });
  $("#modificarnombre").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
      $(this),
      $("#smodificarnombre"),
      "*Solo letras, de 2 a 30 caracteres*"
    );
  });

  $("#modificarapellido_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
    let nombre = document.getElementById("modificarapellido_usuario");
    nombre.value = space(nombre.value);
  });
  $("#modificarapellido_usuario").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/,
      $(this),
      $("#smodificarapellido_usuario"),
      "*Solo letras, de 2 a 30 caracteres*"
    );
  });

  $("#modificarnombre_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-Z0-9_]*$/, e);
  });
  $("#modificarnombre_usuario").on("keyup", function () {
    validarKeyUp(
      /^[a-zA-Z0-9_]{4,15}$/,
      $(this),
      $("#smodificarnombre_usuario"),
      "*El usuario debe tener entre 4 y 15 caracteres alfanuméricos*"
    );
  });

  $("#modificarcedula").on("keypress", function(e){
      validarKeyPress(/^[0-9]*$/, e);
  });

  $("#modificarcedula").on("keyup", function(){
      validarKeyUp(
          /^[0-9]{7,8}$/,
          $(this),
          $("#smodificarcedula"),
          "*El formato solo permite números*"
      );
  });

  $("#modificartelefono_usuario").on("keypress", function (e) {
    validarKeyPress(/^[0-9-]*$/, e);
  });

  $("#modificartelefono_usuario").on("keyup", function () {
    validarKeyUp(
      /^\d{4}-\d{3}-\d{4}$/,
      $(this),
      $("#smodificartelefono_usuario"),
      "*Formato válido: 04XX-XXX-XXXX*"
    );
  });

  $("#modificarcorreo_usuario").on("keypress", function (e) {
    validarKeyPress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
  });

  $("#modificarcorreo_usuario").on("keyup", function () {
    validarKeyUp(
      /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      $(this),
      $("#smodificarcorreo_usuario"),
      "*Formato válido: example@gmail.com*"
    );
  });

  $(document).on("click", ".btn-modificar", function () {
    $("#modificar_id_usuario").val($(this).data("id"));
    $("#modificarnombre_usuario").val($(this).data("username"));
    $("#modificarnombre").val($(this).data("nombres"));
    $("#modificarapellido_usuario").val($(this).data("apellidos"));
    $('#modificarcedula').val($(this).data('cedula'));
    $("#modificarcorreo_usuario").val($(this).data("correo"));
    $("#modificartelefono_usuario").val($(this).data("telefono"));
    $("#modificar_rango").val($(this).data("rango"));

    $("#smodificarnombre_usuario").text("");
    $("#smodificarnombre").text("");
    $("#smodificarapellido_usuario").text("");
    $("#smodificarcedula").text("");
    $("#smodificarcorreo_usuario").text("");
    $("#smodificartelefono_usuario").text("");
    $("#modificar_usuario_modal").modal("show");
  });

  $("#modificarusuario").on("submit", function (e) {
    e.preventDefault();

    const datos = {
      username: $("#modificarnombre_usuario").val(),
      nombres: $("#modificarnombre").val(),
      apellidos: $("#modificarapellido_usuario").val(),
      cedula: $('#modificarcedula').val(),
      correo: $("#modificarcorreo_usuario").val(),
      telefono: $("#modificartelefono_usuario").val(),
      rango: $("#rango").val(),
    };

    const errores = [];
    if (!/^[a-zA-Z0-9_]{4,20}$/.test(datos.username)) {
      errores.push(
        "El usuario debe tener entre 4 y 20 caracteres alfanuméricos."
      );
    }
    if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.nombres)) {
      errores.push("Nombres: solo letras, de 2 a 30 caracteres.");
    }
    if (!/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,30}$/.test(datos.apellidos)) {
      errores.push("Apellidos: solo letras, de 2 a 30 caracteres.");
    }
    if (!/^[0-9]{7,8}$/.test(datos.cedula)) {
        errores.push("El formato solo permite números.");
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(datos.correo)) {
      errores.push("Formato correcto: example@gmail.com.");
    }
    if (!/^\d{4}-\d{3}-\d{4}$/.test(datos.telefono)) {
      errores.push("Formato correcto: 04XX-XXX-XXXX.");
    }

    if (errores.length > 0) {
      Swal.fire({
        icon: "error",
        title: "Error de validación",
        html: errores.join("<br>"),
      });
      return;
    }

  var formData = new FormData(this);
  formData.append("accion", "modificar");
  enviarAjax(formData, function (response) {
    if (response.status === "success") {
      $("#modificar_usuario_modal").modal("hide");
      Swal.fire({
        icon: "success",
        title: "Modificado",
        text: "El usuario se ha modificado correctamente",
      });

const tabla = $("#tablaConsultas").DataTable();
const id = $("#modificar_id_usuario").val();
const fila = tabla.row(`tr[data-id="${id}"]`);
const usuario = response.usuario;

if (fila.length) {
  fila.data([
    `<ul>
        <div>
            <button class="btn-modificar"
                data-id="${usuario.id_usuario}"
                data-username="${usuario.username}"
                data-nombres="${usuario.nombres}"
                data-apellidos="${usuario.apellidos}"
                data-cedula="${usuario.cedula}"
                data-correo="${usuario.correo}"
                data-telefono="${usuario.telefono}"
                data-clave=""
                data-rango="${usuario.id_rol}">
                Modificar
            </button>
        </div>
        <div>
            <button class="btn-eliminar"
                data-id="${usuario.id_usuario}">
                Eliminar
            </button>
        </div>
    </ul>`,
    `<span class="campo-nombres">${usuario.nombres} ${usuario.apellidos}</span>`,
    `<span class="campo-cedula">${usuario.cedula}</span>`,
    `<span class="campo-correo">${usuario.correo}</span>`,
    `<span class="campo-usuario">${usuario.username}</span>`,
    `<span class="campo-telefono">${usuario.telefono}</span>`,
    `<span class="campo-rango">${usuario.nombre_rol}</span>`,
    `<span class="campo-estatus ${
      usuario.estatus === "habilitado" ? "habilitado" : "inhabilitado"
    }" data-id="${usuario.id_usuario}" style="cursor: pointer;">
        ${usuario.estatus}
    </span>`,
  ]).draw(false);

  // Actualiza los data-* del botón Modificar
  const filaNode = fila.node();
  const botonModificar = $(filaNode).find(".btn-modificar");
  botonModificar.data("username", usuario.username);
  botonModificar.data("nombres", usuario.nombres);
  botonModificar.data("apellidos", usuario.apellidos);
  botonModificar.data("cedula", usuario.cedula);
  botonModificar.data("correo", usuario.correo);
  botonModificar.data("telefono", usuario.telefono);
  botonModificar.data("rango", usuario.id_rol);
}
    } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: response.message || "No se pudo modificar el usuario",
      });
    }
  });
});

  $(document).on("click", "#modificar_usuario_modal .close", function () {
    $("#modificar_usuario_modal").modal("hide");
  });

  $(document).on("click", ".btn-eliminar", function (e) {
    e.preventDefault();
    let id_usuario = $(this).data("id");
    Swal.fire({
      title: "¿Está seguro?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo!",
    }).then((result) => {
      if (result.isConfirmed) {
        var datos = new FormData();
        datos.append("accion", "eliminar");
        datos.append("id_usuario", id_usuario);
        enviarAjax(datos, function (respuesta) {
          if (respuesta.status === "success") {
            Swal.fire("Eliminado!", "El usuario ha sido eliminado.", "success");
            const tabla = $("#tablaConsultas").DataTable();
            const fila = tabla.row(
              `#tablaConsultas tbody tr[data-id="${id_usuario}"]`
            );
            tabla.row(fila).remove().draw();
          } else {
            Swal.fire(
              "Error",
              respuesta.message || "No se pudo eliminar el usuario",
              "error"
            );
          }
        });
      }
    });
  });

  function mensajes(icono, tiempo, titulo, mensaje) {
    Swal.fire({
      icon: icono,
      timer: tiempo,
      title: titulo,
      text: mensaje,
      showConfirmButton: true,
      confirmButtonText: "Aceptar",
    });
  }

  function validarKeyPress(er, e) {
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);

    if (!a) {
      e.preventDefault();
    }
  }

  function validarKeyUp(er, etiqueta, etiquetamensaje, mensaje) {
    a = er.test(etiqueta.val());

    if (a) {
      etiquetamensaje.text("");
      return 1;
    } else {
      etiquetamensaje.text(mensaje);
      return 0;
    }
  }

  function space(str) {
    str = (str || "").toString();
    const regex = /\s{2,}/g;
    return str.replace(regex, " ");
  }

  $(document).on("click", ".campo-estatus", function () {
    const id_usuario = $(this).data("id");
    cambiarEstatus(id_usuario);
  });

  function cambiarEstatus(id_usuario) {
    const span = $(`span.campo-estatus[data-id="${id_usuario}"]`);
    const estatusActual = span.text().trim();
    const nuevoEstatus =
      estatusActual === "habilitado" ? "inhabilitado" : "habilitado";

    span.addClass("cambiando");

    $.ajax({
      url: "",
      type: "POST",
      dataType: "json",
      data: {
        accion: "cambiar_estatus",
        id_usuario: id_usuario,
        nuevo_estatus: nuevoEstatus,
      },
      success: function (data) {
        span.removeClass("cambiando");
        if (data.status === "success") {
          span.text(nuevoEstatus);
          span.removeClass("habilitado inhabilitado").addClass(nuevoEstatus);
          Swal.fire({
            icon: "success",
            title: "¡Estatus actualizado!",
            showConfirmButton: false,
            timer: 1500,
          });
        } else {
          span.text(estatusActual);
          span.removeClass("habilitado inhabilitado").addClass(estatusActual);
          Swal.fire(
            "Error",
            data.message || "Error al cambiar el estatus",
            "error"
          );
        }
      },
      error: function (xhr, status, error) {
        span.removeClass("cambiando");
        span.text(estatusActual);
        span.removeClass("habilitado inhabilitado").addClass(estatusActual);
        Swal.fire("Error", "Error en la conexión", "error");
      },
    });
  }
});
