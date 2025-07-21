$(document).ready(function(){

        $("#nombre_usuario").on("keypress", function (e) {
          validarkeypress(/^[a-zA-Z0-9_]*$/, e);
        });
        $("#nombre_usuario").on("keyup", function () {
          validarkeyup(
            /^[a-zA-Z0-9_]{4,20}$/,
            $(this),
            $("#snombre_usuario"),
            "*El usuario debe tener entre 4 y 20 caracteres alfanuméricos*"
          );
        });

        $("#nombre").on("keypress", function (e) {
          validarkeypress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]*$/, e);
          let nombre = document.getElementById("nombre");
          nombre.value = space(nombre.value);
        });
        $("#nombre").on("keyup", function () {
          validarkeyup(
            /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ\s]{2,50}$/,
            $(this),
            $("#snombre"),
            "*Solo letras, de 2 a 50 caracteres*"
          );
        });
        $("#apellido").on("keypress", function (e) {
          validarkeypress(/^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]*$/, e);
          let apellido_usuario = document.getElementById("apellido");
          apellido_usuario.value = space(apellido_usuario.value);
        });
        $("#apellido").on("keyup", function () {
          validarkeyup(
            /^[a-zA-ZÁÉÍÓÚÑáéíóúüÜ\s]{2,50}$/,
            $(this),
            $("#sapellido"),
            "*Solo letras, de 2 a 50 caracteres*"
          );
        });

        $("#cedula").on("keypress", function(e){
            validarkeypress(/^[0-9]*$/, e);
        });

        $("#cedula").on("keyup", function(){
            validarkeyup(
                /^[0-9]{6,8}$/,
                $(this),
                $("#scedula"),
                "*El formato solo permite números*"
            );
        });

        $("#telefono").on("keypress", function (e) {
          validarkeypress(/^[0-9-]*$/, e);
        });

        $("#telefono").on("keyup", function () {
          validarkeyup(
            /^\d{4}-\d{3}-\d{4}$/,
            $(this),
            $("#stelefono_usuario"),
            "*Formato válido: 04XX-XXX-XXXX*"
          );
        });

        $("#correo").on("keypress", function (e) {
          validarkeypress(/^[a-zA-ZñÑ_0-9@,.\b]*$/, e);
        });

        $("#correo").on("keyup", function () {
          validarkeyup(
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            $(this),
            $("#scorreo_usuario"),
            "*Formato válido: example@gmail.com*"
          );
        });

        $("#direccion").on("keypress", function(e){
            validarkeypress(/^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]*$/, e);
            let direccion = document.getElementById("direccion");
            direccion.value = space(direccion.value);
        });

        $("#direccion").on("keyup", function(){
            validarkeyup(
                /^[a-zA-ZÁÉÍÓÚñÑáéíóúüÜ0-9,-\s\b]{2,100}$/,
                $(this),
                $("#sdireccion"),
                "*El formato permite letras y números*"
            );
        });

        $("#clave").on("keypress", function (e) {
          validarkeypress(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]*$/, e);
        });
        $("#clave").on("keyup", function () {
          validarkeyup(
            /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
            $(this),
            $("#sclave_usuario"),
            "*Solo letras y números, de 6 a 15 caracteres*"
          );
        });

        $("#clave_confirmar").on("keypress", function (e) {
          validarkeypress(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]*$/, e);
        });
        $("#clave_confirmar").on("keyup", function () {
          validarkeyup(
            /^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
            $(this),
            $("#sclave_confirmar"),
            "*Solo letras y números, de 6 a 15 caracteres*"
          );
        });

    // Validación para el formulario de registro de usuario y cliente
    $("#registro-usuario-cliente").on("submit", function(e){
        let valido = true;
        let mensaje = "";

        // Validar campos vacíos
        $("#registro-usuario-cliente input[required], #registro-usuario-cliente textarea[required]").each(function(){
            if($.trim($(this).val()) === ""){
                valido = false;
                mensaje = "Todos los campos son obligatorios.";
                $(this).focus();
                return false;
            }
        });

        if(!valido){
            muestraMensaje("error", 4000, "Error de validación", mensaje);
            e.preventDefault();
            return false;
        }
    });

    // Formato automático para teléfono ####-###-####
    $("#telefono").on("input", function() {
        let valor = $(this).val().replace(/\D/g, '');
        if(valor.length > 4 && valor.length <= 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4);
        else if(valor.length > 7)
            valor = valor.slice(0,4) + '-' + valor.slice(4,7) + '-' + valor.slice(7,11);
        $(this).val(valor);
    });

    // Función para bloquear caracteres inválidos
    function validarkeypress(er, e){
        let key = e.keyCode || e.which;
        let tecla = String.fromCharCode(key);
        if(!er.test(tecla)){
            e.preventDefault();
        }
    }

    // ... (el resto de tu código de validación y muestraMensaje permanece igual) ...

    
    //Función que verifica que exista algo dentro de un div
    //oculto y lo muestra por el modal
    if($.trim($("#mensajes").text()) != ""){
      muestraMensaje($("#mensajes").html());
    }
    //Fin de seccion de mostrar envio en modal mensaje//		
      
      
      $("#username").on("keypress",function(e){
        validarkeypress(/^[a-zA-Z0-9_]*$/,e);
      });
      
      $("#username").on("keyup",function(){
        validarkeyup(/^[a-zA-Z0-9_]{4,20}$/,$(this),
        $("#susername"),"*Ingrese su nombre de usuario*");
      });
      
      $("#password").on("keypress",function(e){
        validarkeypress(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]*$/,e);
      });
      
      $("#password").on("keyup",function(){
        
        validarkeyup(/^[A-Za-z0-9\b\u00f1\u00d1\u00E0-\u00FC]{6,15}$/,
        $(this),$("#spassword"),"*Ingrese su contraseña de seguridad*");
      });
      
      
      
    //FIN DE VALIDACION DE DATOS
    
    
    
    //CONTROL DE BOTONES
    
    
    $("#acceder").on("click",function(){
      event.preventDefault();
      if(validarenvio()){
        
        $("#accion").val("acceder");	
        $("#f").submit();
        
      }
    });
      
    });
    
    //Validación de todos los campos antes del envio
    function validarenvio(){
      
      if(validarkeyup(/^[A-Za-z0-9]{4,20}$/,$("#username"),
        $("#susername"),"El formato es de 4 y 20 caracteres")==0){
          muestraMensaje("error",4000,"ERROR!","El usuario es incorrecto, ingrese el usuario nuevamente");
        return false;					
      }	
      else if(validarkeyup(/^[A-Za-z0-9]{6,15}$/,
        $("#password"),$("#spassword"),"El formato es de 6 y 15 caracteres")==0){
         muestraMensaje("error",4000,"ERROR!","La contraseña es incorrecto, ingrese la contraseña nuevamente");
        return false;
      }
      
      
      return true;
    }
    
    
    //Funcion que muestra el modal con un mensaje
    function muestraMensaje(icono,tiempo,titulo,mensaje){
      Swal.fire({
      icon:icono,
        timer:tiempo,	
        title:titulo,
      html:mensaje,
      showConfirmButton:true,
      confirmButtonText:'Aceptar',
      });
    }
    
$(document).ready(function() {
    const mensajesDiv = $("#mensajes");
    const mensaje = mensajesDiv.data("mensaje");
    const tipo = mensajesDiv.data("tipo") || "error";

    if (mensaje) {
        muestraMensaje(tipo, 4000, tipo === "success" ? "¡Éxito!" : "Error", mensaje);
    }
});
    
    //Función para validar por Keypress
    function validarkeypress(er,e){
      
      key = e.keyCode;
      
      
        tecla = String.fromCharCode(key);
      
      
        a = er.test(tecla);
      
        if(!a){
      
        e.preventDefault();
        }
      
        
    }
    //Función para validar por keyup
    function validarkeyup(er,etiqueta,etiquetamensaje,
    mensaje){
      a = er.test(etiqueta.val());
      if(a){
        etiquetamensaje.text("");
        return 1;
      }
      else{
        etiquetamensaje.text(mensaje);
        return 0;
      }
    }
    