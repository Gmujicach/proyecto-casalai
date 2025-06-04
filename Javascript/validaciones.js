
$(document).ready(function(){

	
//VALIDACION DE CLIENTES

    $("#cedula").on("keypress",function(e){
        validarkeypress(/^[VEJGPU\-\0-9]*$/,e);
    });
    
    $("#cedula").on("keyup",function(){
        validarkeyup(/^[VEJGPU]{1}[-]{1}[0-9]{9,10}$/,
        $(this),$("#srif"),"El Formato debe ser V-999999999");
    });		
	
	$("#nombre").on("keypress",function(e){
		validarkeypress(/^[A-Z\a-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
	});
	
	$("#nombre").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
		$(this),$("#snombre"),"Solo letras entre 3 y 15 caracteres");
	});
	
	$("#direccion").on("keypress",function(e){
		validarkeypress(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
	});
	
	$("#direccion").on("keyup",function(){
		validarkeyup(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{6,35}$/,
		$(this),$("#sdireccion"),"Solo letras y/o numeros entre 6 y 35 caracteres");
	});
	
	
	$("#correo").on("keypress",function(e){
		validarkeypress(/^[A-Z\a-z\0-9\@\_\.\b\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
	});
	
	$("#correo").on("keyup",function(){
		validarkeyup(/^[A-Za-z0-9\b\_\s\u00f1\u00d1\u00E0-\u00FC]{3,15}[@]{1}[A-Za-z]{3,8}[.]{1}[A-Za-z]{2,3}$/,

		$(this),$("#scorreo"),"El formato debe ser Individuo@servidor.com");
	});
	
	
	$("#telefono").on("keypress",function(e){
		validarkeypress(/^[0-9\b-]*$/,e);
	});
	
	$("#telefono").on("keyup",function(){
	    validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$("#stelefono_1"),"El formato debe ser 9999-9999999");
	});



    //MODIFICAR CLIENTES VALIDACIONES
    $("#modificarcedula").on("keypress",function(e){
        validarkeypress(/^[VEJGPU\-\0-9]*$/,e);
    });
    
    $("#modificarcedula").on("keyup",function(){
        validarkeyup(/^[VEJGPU]{1}[-]{1}[0-9]{9,10}$/,
        $(this),$("#smodificarcedula"),"El Formato debe ser V-999999999");
    });     
    
    $("#modificarnombre").on("keypress",function(e){
        validarkeypress(/^[A-Z\a-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#modificarnombre").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
        $(this),$("#smodificarnombre"),"Solo letras entre 3 y 15 caracteres");
    });

    $("#modificardireccion").on("keypress",function(e){
        validarkeypress(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
    });
    
    $("#modificardireccion").on("keyup",function(){
        validarkeyup(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{6,35}$/,
        $(this),$("#smodificardireccion"),"Solo letras y/o numeros entre 6 y 35 caracteres");
    });
    
    
    $("#modificarcorreo").on("keypress",function(e){
        validarkeypress(/^[A-Z\a-z\0-9\@\_\.\b\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
    });
    
    $("#modificarcorreo").on("keyup",function(){
        validarkeyup(/^[A-Za-z0-9\b\_\s\u00f1\u00d1\u00E0-\u00FC]{3,15}[@]{1}[A-Za-z]{3,8}[.]{1}[A-Za-z]{2,3}$/,

        $(this),$("#smodificarcorreo"),"El formato debe ser Individuo@servidor.com");
    });
    
    
    $("#modificartelefono").on("keypress",function(e){
        validarkeypress(/^[0-9\b-]*$/,e);
    });
    
    $("#modificartelefono").on("keyup",function(){
        validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$("#smodificartelefono"),"El formato debe ser 9999-9999999");
    });
	
	
//FIN DE VALIDACION DE CLIENTES




//VALIDACION DE MARCAS
$("#descripcion_ma").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#descripcion_ma").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{2,15}$/,
        $(this),$("#sdescripcion_ma"),"Solo letras entre 2 y 15 caracteres");
    });

    $("#modificardescripcion_ma").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#modificardescripcion_ma").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{2,15}$/,
        $(this),$("#smodificardescripcion_ma"),"Solo letras entre 2 y 15 caracteres");
    });

//FIN DE VALIDACION DE MARCAS 




//VALIDACION DE MODELOS
$("#descripcion_mo").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#descripcion_mo").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
        $(this),$("#sdescripcion_mo"),"Solo letras entre 3 y 15 caracteres");
    });

    $("#modificardescripcion_mo").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#modificardescripcion_mo").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
        $(this),$("#smodificardescripcion_mo"),"Solo letras entre 3 y 15 caracteres");
    });

//FIN DE VALIDACION DE MODELOS


// VALIDACION DE USUARIO

$("#nombre_usuario").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#nombre_usuario").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#snombre_usuario"),"Solo letras entre 3 y 15 caracteres");
});

$("#modificarnombre_usuario").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#modificarnombre_usuario").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#smodificarnombre_usuario"),"Solo letras entre 3 y 15 caracteres");
});


$("#clave_usuario").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#clave_usuario").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#sclave_usuario"),"Solo letras y Numeros entre 3 y 15 caracteres");
});

$("#modificarclave_usuario").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#modificarclave_usuario").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#smodificarclave_usuario"),"Solo letras y Numeros entre 3 y 15 caracteres");
});

//FIN DE VALIDACION DE USUARIO


// VALIDACION DE PROVEEDOR

$("#nombre_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#nombre_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#snombre_proveedor"),"Solo letras entre 3 y 15 caracteres");
});

$("#modificarnombre_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#modificarnombre_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#smodificarnombre_proveedor"),"Solo letras entre 3 y 15 caracteres");
});

$("#rif_proveedor").on("keypress",function(e){
    validarkeypress(/^[VJ\-\0-9]*$/,e);
});

$("#rif_proveedor").on("keyup",function(){
    validarkeyup(/^[VJ]{1}[-]{1}[0-9]{9,10}$/,
    $(this),$("#srif_proveedor"),"El Formato debe ser V o J // J-99999999");
});	

$("#modificarrif_proveedor").on("keypress",function(e){
    validarkeypress(/^[VJ\-\0-9]*$/,e);
});

$("#modificarrif_proveedor").on("keyup",function(){
    validarkeyup(/^[VJ]{1}[-]{1}[0-9]{9,10}$/,
    $(this),$("#smodificarrif_proveedor"),"El Formato debe ser V o J // J-99999999");
});

//

$("#nombre_representante").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#nombre_representante").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#snombre_representante"),"Solo letras entre 3 y 15 caracteres");
});

$("#modificarnombre_representante").on("keypress",function(e){
    validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
});

$("#modificarnombre_representante").on("keyup",function(){
    validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,15}$/,
    $(this),$("#smodificarnombre_representante"),"Solo letras entre 3 y 15 caracteres");
});

$("#rif_representante").on("keypress",function(e){
    validarkeypress(/^[VJ\-\0-9]*$/,e);
});

$("#rif_representante").on("keyup",function(){
    validarkeyup(/^[VJ]{1}[-]{1}[0-9]{9,10}$/,
    $(this),$("#srif_representante"),"El Formato debe ser V o J // J-99999999");
});	

$("#modificarrif_representante").on("keypress",function(e){
    validarkeypress(/^[VJ\-\0-9]*$/,e);
});

$("#modificarrif_representante").on("keyup",function(){
    validarkeyup(/^[VJ]{1}[-]{1}[0-9]{9,10}$/,
    $(this),$("#smodificarrif_representante"),"El Formato debe ser V o J // J-99999999");
});

//

$("#direccion_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#direccion_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]{6,50}$/,
    $(this),$("#sdireccion_proveedor"),"Solo letras y/o numeros y Simbolos entre 6 y 50 caracteres");
});

$("#modificardireccion_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#modificardireccion_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]{6,50}$/,
    $(this),$("#smodificardireccion_proveedor"),"Solo letras y/o numeros y Simbolos entre 6 y 50 caracteres");
});

//

$("#telefono_1").on("keypress",function(e){
    validarkeypress(/^[0-9\b-]*$/,e);
});

$("#telefono_1").on("keyup",function(){
    validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$
    ("#stelefono_1"),"El formato debe ser 9999-9999999");
});

$("#telefono_2").on("keypress",function(e){
    validarkeypress(/^[0-9\b-]*$/,e);
});

$("#telefono_2").on("keyup",function(){
    validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$
    ("#stelefono_2"),"El formato debe ser 9999-9999999");
});

$("#modificartelefono_1").on("keypress",function(e){
    validarkeypress(/^[0-9\b-]*$/,e);
});

$("#modificartelefono_1").on("keyup",function(){
    validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$
    ("#smodificartelefono_1"),"El formato debe ser 9999-9999999");
});

$("#modificartelefono_2").on("keypress",function(e){
    validarkeypress(/^[0-9\b-]*$/,e);
});

$("#modificartelefono_2").on("keyup",function(){
    validarkeyup(/^[0-9]{4}[-]{1}[0-9]{7,8}$/,$(this),$
    ("#smodificartelefono_2"),"El formato debe ser 9999-9999999");
});

//

$("#correo_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Z\a-z\0-9\@\_\.\b\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#correo_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9\b\_\s\u00f1\u00d1\u00E0-\u00FC]{3,15}[@]{1}[A-Za-z]{3,8}[.]{1}[A-Za-z]{2,3}$/,
    $(this),$("#scorreo_proveedor"),"El formato debe ser Individuo@servidor.com");
});

$("#modificarcorreo_proveedor").on("keypress",function(e){
    validarkeypress(/^[A-Z\a-z\0-9\@\_\.\b\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#modificarcorreo_proveedor").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9\b\_\s\u00f1\u00d1\u00E0-\u00FC]{3,15}[@]{1}[A-Za-z]{3,8}[.]{1}[A-Za-z]{2,3}$/,
    $(this),$("#smodificarcorreo_proveedor"),"El formato debe ser Individuo@servidor.com");
});

//

$("#observacion").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#observacion").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]{6,50}$/,
    $(this),$("#sobservacion"),"Solo letras y/o numeros y Simbolos entre 6 y 50 caracteres");
});

$("#modificarobservacion").on("keypress",function(e){
    validarkeypress(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]*$/,e);
});

$("#modificarobservacion").on("keyup",function(){
    validarkeyup(/^[A-Za-z0-9,#\b\@\s\u00f1\u00d1\u00E0-\u00FC-]{6,50}$/,
    $(this),$("#smodificarobservacion"),"Solo letras y/o numeros y Simbolos entre 6 y 50 caracteres");
});

//FIN DE VALIDACION DE PROVEEDOR




// Función para validar solo teclas numéricas
function validarkeypress(er, e) {
  key = e.key;
  if (!er.test(key)) {
    e.preventDefault();
  }
}

// Función para validar campos al soltar una tecla
function validarkeyup(er, input, span, mensaje) {
  let valor = input.val();
  if (!er.test(valor) || parseFloat(valor) <= 0) {
    span.text(mensaje).css("color", "red");
    input.addClass("is-invalid").removeClass("is-valid");
    return false;
  } else {
    span.text("").css("color", "");
    input.addClass("is-valid").removeClass("is-invalid");
    return true;
  }
}

// Validaciones para campos numéricos que no pueden ser <= 0
$("#Stock_Actual, #Stock_Minimo, #Stock_Maximo, #Precio").on("keypress", function(e){
  validarkeypress(/^[0-9\b]*$/, e);
});

$("#Stock_Actual").on("keyup", function(){
  validarkeyup(/^[1-9][0-9]{0,9}$/, $(this), $("#sStock_Actual"), "Debe ser un número mayor a 0");
});

$("#Stock_Minimo").on("keyup", function(){
  validarkeyup(/^[1-9][0-9]{0,9}$/, $(this), $("#sStock_Minimo"), "Debe ser un número mayor a 0");
});

$("#Stock_Maximo").on("keyup", function(){
  validarkeyup(/^[1-9][0-9]{0,9}$/, $(this), $("#sStock_Maximo"), "Debe ser un número mayor a 0");
});

$("#Precio").on("keyup", function(){
  validarkeyup(/^[1-9][0-9]{0,9}$/, $(this), $("#sPrecio"), "Debe ser un número mayor a 0");
});

// Validar que Stock Mínimo < Stock Máximo
$("#Stock_Minimo, #Stock_Maximo").on("keyup", function(){
  let minimo = parseInt($("#Stock_Minimo").val());
  let maximo = parseInt($("#Stock_Maximo").val());
  if (minimo >= maximo && maximo > 0) {
    Swal.fire({
      icon: "error",
      title: "Error en Stock",
      text: "El Stock Mínimo debe ser menor que el Stock Máximo",
    });
    $("#Stock_Minimo").addClass("is-invalid");
    $("#Stock_Maximo").addClass("is-invalid");
  }

  $("#Stock_Minimo, #Stock_Maximo").on("focusout", function(){
  let minimo = parseInt($("#Stock_Minimo").val());
  let maximo = parseInt($("#Stock_Maximo").val());
  if (minimo >= maximo && maximo > 0) {
    $("#Stock_Minimo").addClass("is-invalid");
    $("#Stock_Maximo").addClass("is-invalid");
  } else {
    $("#Stock_Minimo").removeClass("is-invalid").addClass("is-valid");
    $("#Stock_Maximo").removeClass("is-invalid").addClass("is-valid");
  }});
});










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