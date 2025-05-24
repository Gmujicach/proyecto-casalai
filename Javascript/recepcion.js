
$(document).ready(function(){
    // Si estoy aca es porque l
    carga_productos();
    
    //boton para levantar modal de productos
    $("#listado").on("click",function(){
        $("#modalp").modal("show");
    });
    
    
    $("#correlativo").on("keypress",function(e){
        validarkeypress(/^[0-9-\b]*$/,e);
    });
    
    $("#correlativo").on("keyup",function(){
        validarkeyup(/^[0-9]{4,10}$/,$(this),
        $("#scorrelativo"),"Se permite de 4 a 10 carácteres");
        if ($("#correlativo").val().length <= 9) {
			var datos = new FormData();
			datos.append('accion', 'buscar');
			datos.append('correlativo', $(this).val());
			enviaAjax(datos);
		}
    });

    $("#descripcion").on("keypress", function (e) {
        validarkeypress(/^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]*$/, e);
      });
    
      $("#descripcion").on("keyup", function () {
        validarkeyup(
          /^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{1,200}$/,
          $(this),
          $("#sdescripcion"),
          "No debe estar vacío y se permite un máximo 200 carácteres"
        );
      });
    
    //evento keyup de input codigoproducto
    $("#codigoproducto").on("keyup",function(){
        var codigo = $(this).val();
        $("#listadop tr").each(function(){
            if(codigo == $(this).find("td:eq(1)").text()){
                colocaproducto($(this));
            }
        });
    });	
    
    //evento click de boton registrar
    $("#registrar").on("click",function(){
         if (validarenvio()){
            if(verificaproductos()){
            $('#accion').val('registrar');
    
                var datos = new FormData($('#f')[0]);
                
                $('#proveedor').change(function() {
                    var valor = $(this).val();
                    datos.append('proveedor', valor); });
                datos.append("descripcion", $("#descripcion").val());
    
                enviaAjax(datos);
                } else{
                muestraMensaje("info",4000,"Debe colocar algun producto");
            }
          } 
           
            
        
    });
        
        
    });

    function validarenvio(){
        
        var proveedorseleccionado = $("#proveedor").val();
        if (proveedorseleccionado === null || proveedorseleccionado === "0") {
            muestraMensaje("info",4000,"Por favor, seleccione un proveedor!"); 
            return false;
        }
        else if(validarkeyup(/^[0-9]{4,10}$/,$("#correlativo"),
            $("#scorrelativo"),"Se permite de 4 a 10 carácteres")==0){
            muestraMensaje("info",4000,"el correlativo debe coincidir con el formato");
                           
            return false;					
        } else if (
            validarkeyup(
                /^[A-Za-z0-9,#\b\s\u00f1\u00d1\u00E0-\u00FC-]{1,200}$/,
                $("#descripcion"),
                $("#sdescripcion"),
                "No debe contener más de 200 carácteres"
            ) == 0
        ) {
            muestraMensaje(
                "error",
                4000,
                "ERROR!",
               
                    "No debe estar vacío, ni contener más de 200 carácteres"
            );
            return false;
        }
        return true;
    }
    
    function carga_productos(){
        
        
        var datos = new FormData();
        
        datos.append('accion','listado'); //le digo que me muestre un listado de aulas
        
        enviaAjax(datos);
    }
    
    //function para saber si selecciono algun productos
    function verificaproductos(){
        var existe = false;
       
        if($("#recepcion1 tr").length > 0){
            existe = true;
            
        }
      
        return existe;
    }
    function borrar(){
        $("#correlativo").val('');
        $("#proveedor").val("disabled");
        $("#recepcion1 tr").remove();
        $("#descripcion").val('');
        
        }

    
//funcion para colocar los productos
    
    
    function colocaproducto(linea){
        var id = $(linea).find("td:eq(0)").text();
        var encontro = false;
        
        $("#recepcion1 tr").each(function(){
            if(id*1 == $(this).find("td:eq(1)").text()*1){
                encontro = true
                var t = $(this).find("td:eq(4)").children();
                t.val(t.val()*1+1);
                modificasubtotal(t);
            } 
        });
        
        if(!encontro){
            var l = `
              <tr>
               <td>
               <button type="button" class="btn" onclick="borrarp(this)">Eliminar</button>
               </td>
               <td style="display:none">
                   <input type="text" name="producto[]" style="display:none"
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
               <td>`+
                        $(linea).find("td:eq(3)").text()+
               `</td>
                <td>`+
                        $(linea).find("td:eq(4)").text()+
               `</td>
               <td>`+
                        $(linea).find("td:eq(5)").text()+
               `</td>
<td>
  <input type="number" class="control-form" name="costo[]" min="0.01" step="0.01" value="1" 
         style="width: 80px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;" required>
</td>
<td>
  <input type="number" class="control-form" name="cantidad[]" min="1" step="1" value="1" 
         style="width: 60px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;" required>
</td>

             
               
               </tr>`;
            $("#recepcion1").append(l);
        }
    }
    
 
    //fin de funcion modifica subtotal
 

    
    //funcion para eliminar linea de detalle de ventas
    function borrarp(boton){
        $(boton).closest('tr').remove();
    }


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
    
    //Funcion que muestra el modal con un mensaje
    
    
    
    
    
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
                    
                    if(lee.resultado=='listado'){
                        
                        $('#listadop').html(lee.mensaje);
                    }
                    else if(lee.resultado=='registrar'){
                        muestraMensaje('success', 6000,'REGISTRAR', lee.mensaje);
                        borrar();
                    }else if (lee.resultado == "encontro") {		
                        if (lee.mensaje == 'El numero de correlativo ya existe!') {
                            muestraMensaje('success', 6000,'Atencion', lee.mensaje);
                        }		
                    }else if(lee.resultado=='error'){
                        muestraMensaje('success', 6000,'Error',lee.mensaje);
                    }
                    
                }
                catch(e){
                    console.log("Error en JSON"+e.name+" !!!");
                }
                  
                },
                complete: function(){
                
                }
                
            });
    
    
        
    }
   