$(document).ready(function(){

	carga_productos();
	

//boton para levantar modal de productos
$("#listadodeproductos").on("click",function(){
	$("#modalproductos").modal("show");
});

//evento keyup de input codigoproducto
$("#codigoproducto").on("keyup",function(){
	var codigo = $(this).val();
	$("#listadoproductos tr").each(function(){
		if(codigo == $(this).find("td:eq(1)").text()){
			colocaproducto($(this));
		}
	});
});	

//evento click de boton registrar
$("#registrar").on("click",function(){
	
		//	$('#accion').val('registrar');
			var datos = new FormData($('#f')[0]);


				$('#cliente').change(function() {
                    var valor = $(this).val();
                    datos.append('cliente', valor);
                });
    
       		 datos.append('accion','registrar');
			enviaAjax(datos);
		
});
	
	
});

function carga_productos(){
	
	
	var datos = new FormData();
	
	datos.append('accion','listadoproductos'); //le digo que me muestre un listado de aulas
	
	enviaAjax(datos);
}

//function para saber si selecciono algun productos
function verificaproductos(){
	var existe = false;
	if($("#detalle_despacho tr").length > 0){
		existe = true;
	}
	return existe;
}
//fin de verificar si selecciono procductos



//funcion para colocar los productos
function colocaproducto(linea){
	var id = $(linea).find("td:eq(0)").text();
	var encontro = false;
	
	$("#detalle_despacho tr").each(function(){
		if(id*1 == $(this).find("td:eq(1)").text()*1){
			encontro = true
			var t = $(this).find("td:eq(4)").children();
			t.val(t.val()*1+1);
		} 
	});
	
	if(!encontro){
		var l = `
		  <tr>
		   <td>
		   <button type="button" class="btn btn-primary" onclick="eliminalineadetalle(this)">X</button>
		   </td>
		   <td style="display:none">
			   <input type="text" name="idp[]" style="display:none"
			   value="`+
					$(linea).find("td:eq(0)").text()+
			   `"/>`+	
					$(linea).find("td:eq(0)").text()+
		   `</td>
		   <td>`+
					$(linea).find("td:eq(1)").text()+
		   `</td>
		   <td>`+
					$(linea).find("td:eq(2)").text()+
		   `</td>
		   <td>
		      <input type="text" value="1" name="cant[]"/>
		   </td>
		  
		   </tr>`;
		$("#detalle_despacho").append(l);
	}
}
//fin de funcion colocar productos


//funcion para eliminar linea de detalle de ventas
function eliminalineadetalle(boton){
	$(boton).closest('tr').remove();
}
// fin de funcion de eliminar linea


//Funcion que muestra el modal con un mensaje
function muestraMensaje(mensaje){
	$("#contenidodemodal").html(mensaje);
			$("#mostrarmodal").modal("show");
			setTimeout(function() {
					$("#mostrarmodal").modal("hide");
			},5000);
}


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


function enviaAjax(datos){
	
	$.ajax({
		async: true,
            url: '', //la pagina a donde se envia por estar en mvc, se omite la ruta ya que siempre estaremos en la misma pagina
            type: 'POST',//tipo de envio 
            contentType: false,
            data: datos,
            processData: false,
            cache: false,
            beforeSend: function(){
				//pasa antes de enviar pueden colocar un loader
				
				
			},
			timeout:10000, //tiempo maximo de espera por la respuesta del servidor
            success: function(respuesta) {//si resulto exitosa la transmision
				console.log(respuesta);
            	try{
	
				var lee = JSON.parse(respuesta);	
				console.log(lee.resultado);
				if(lee.resultado=='listadoproductos'){
					
					$('#listadoproductos').html(lee.mensaje);
				}
				else if(lee.resultado=='registrar'){
					
					muestraMensaje(lee.mensaje);
				}
				else if(lee.resultado=='error'){
					muestraMensaje(lee.mensaje);
				}
				
			}
			catch (e) {
            console.error("Error en análisis JSON:", e); // Registrar el error para depuración
            alert("Error en JSON " + e.name + ": " + e.message);
             }
			  //cuanto termina el proceso ocultan el loader
			  
			},
			error: function (request, status, err) {
            if (status == "timeout") {
                muestraMensaje("Servidor ocupado, intente de nuevo");
            } else {
                muestraMensaje("ERROR: <br/>" + request + status + err);
            }
            },
			complete: function(){
				
			}
			
		});


	
}