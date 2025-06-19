$(document).ready(function(){

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

        // Validar nombre de usuario (solo letras y números, 3-20 caracteres)
        let nombre_usuario = $("#nombre_usuario").val();
        if(!/^[A-Za-z0-9]{3,20}$/.test(nombre_usuario)){
            valido = false;
            mensaje = "El nombre de usuario debe tener entre 3 y 20 caracteres, solo letras y números.";
            $("#nombre_usuario").focus();
        }

        // Validar nombre y apellido (solo letras y espacios)
        let nombre = $("#nombre").val();
        if(!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,30}$/.test(nombre)){
            valido = false;
            mensaje = "El nombre solo debe contener letras y espacios.";
            $("#nombre").focus();
        }
        let apellido = $("#apellido").val();
        if(!/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,30}$/.test(apellido)){
            valido = false;
            mensaje = "El apellido solo debe contener letras y espacios.";
            $("#apellido").focus();
        }

        // Validar cédula (letras y números, 6-12 caracteres)
        let cedula = $("#cedula").val();
        if(!/^[0-9]{6,12}$/.test(cedula)){
            valido = false;
            mensaje = "La cédula/RIF debe tener entre 6 y 12 caracteres, solo números ";
            $("#cedula").focus();
        }

        // Validar teléfono (formato ####-###-####)
        let telefono = $("#telefono").val();
        if(!/^\d{4}-\d{3}-\d{4}$/.test(telefono)){
            valido = false;
            mensaje = "El teléfono debe tener el formato ####-###-####.";
            $("#telefono").focus();
        }

        // Validar correo
        let correo = $("#correo").val();
        if(!/^[\w\.-]+@[\w\.-]+\.\w{2,}$/.test(correo)){
            valido = false;
            mensaje = "El correo electrónico no es válido.";
            $("#correo").focus();
        }

        // Validar dirección (mínimo 5 caracteres)
        let direccion = $("#direccion").val();
        if(direccion.length < 5){
            valido = false;
            mensaje = "La dirección debe tener al menos 5 caracteres.";
            $("#direccion").focus();
        }

        // Validar contraseña (mínimo 3, máximo 15)
        let clave = $("#clave").val();
        if(!/^[A-Za-z0-9]{3,15}$/.test(clave)){
            valido = false;
            mensaje = "La contraseña debe tener entre 3 y 15 caracteres, solo letras y números.";
            $("#clave").focus();
        }

        // Validar confirmación de contraseña
        let clave_confirmar = $("#clave_confirmar").val();
        if(clave !== clave_confirmar){
            valido = false;
            mensaje = "Las contraseñas no coinciden.";
            $("#clave_confirmar").focus();
        }

        if(!valido){
            muestraMensaje("error", 4000, "Error de validación", mensaje);
            e.preventDefault();
            return false;
        }
    });

    // Bloquear caracteres inválidos en cada campo (keypress y keyup)
    $("#nombre_usuario").on("keypress", function(e){
        validarkeypress(/^[A-Za-z0-9\b]*$/, e);
    });
    $("#nombre").on("keypress", function(e){
        validarkeypress(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s\b]*$/, e);
    });
    $("#apellido").on("keypress", function(e){
        validarkeypress(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s\b]*$/, e);
    });
    $("#cedula").on("keypress", function(e){
        validarkeypress(/^[0-9]*$/, e);
    });
    $("#telefono").on("keypress", function(e){
        validarkeypress(/^[0-9\-]*$/, e);
    });
    $("#correo").on("keypress", function(e){
        validarkeypress(/^[A-Za-z0-9@._\-]*$/, e);
    });
    $("#clave, #clave_confirmar").on("keypress", function(e){
        validarkeypress(/^[A-Za-z0-9]*$/, e);
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
        validarkeypress(/^[A-Za-z0-9\b]*$/,e);
      });
      
      $("#username").on("keyup",function(){
        validarkeyup(/^[A-Za-z0-9\b]{3,8}$/,$(this),
        $("#susername"),"El formato debe ser 9999999 ");
      });
      
      $("#password").on("keypress",function(e){
        validarkeypress(/^[A-Za-z0-9\b]*$/,e);
      });
      
      $("#password").on("keyup",function(){
        
        validarkeyup(/^[A-Za-z0-9]{3,15}$/,
        $(this),$("#spassword"),"Solo letras y numeros entre 3 y 15 caracteres");
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
      
      if(validarkeyup(/^[A-Za-z0-9]{3,8}$/,$("#username"),
        $("#susername"),"El formato debe ser entre 3 y 8 dígitos")==0){
          muestraMensaje("error",4000,"ERROR!","El username debe tener mínimo 3 dígitos y máximo 8");
        return false;					
      }	
      else if(validarkeyup(/^[A-Za-z0-9]{3,15}$/,
        $("#password"),$("#spassword"),"Solo letras y numeros entre 3 y 15 caracteres")==0){
         muestraMensaje("error",4000,"ERROR!","El password debe tener mínimo 3 dígitos y máximo 15");
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
    