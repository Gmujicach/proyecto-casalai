<?php
require_once('dompdf/vendor/autoload.php'); //archivo para cargar las funciones de la 
		//libreria DOMPDF
		// lo siguiente es hacer rerencia al espacio de trabajo
use Dompdf\Dompdf; //Declaracion del espacio de trabajo

//llamda al archivo que contiene la clase
//datos, en ella posteriormente se colcora el codigo
//para enlazar a su base de datos
require_once 'config/config.php';

//declaracion de la clase usuarios que hereda de la clase datos
//la herencia se declara con la palabra extends y no es mas 
//que decirle a esta clase que puede usar los mismos metodos
//que estan en la clase de dodne hereda (La padre) como sir fueran de el

class rusuarios extends BD{
	//el primer paso dentro de la clase
	//sera declarar los atributos (variables) que describen la clase
	//para nostros no es mas que colcoar los inputs (controles) de
	//la vista como variables aca
	//cada atributo debe ser privado, es decir, ser visible solo dentro de la
	//misma clase, la forma de colcoarlo privado es usando la palabra private
	
	private $codigo; //recuerden que en php, las variables no tienen tipo predefinido
	private $nombre;
	
	
	//Ok ya tenemos los atributos, pero como son privados no podemos acceder a ellos desde fueran
	//por lo que debemos colcoar metodos (funciones) que me permitan leer (get) y colocar (set)
	//valores en ello, esto es  muy mal llamado geters y seters por si alguien se los pregunta
	

	//lo mismo que se hizo para cedula se hace para usuario y clave
	
	function set_nombre($valor){
		$this->nombre = $valor;
	}
	
	//el siguiente metodo enlza con la la base de datos
	//crea el html a partir de la consulta y envia los datos a la
	//libreria DOMPDF
	function generarPDF(){
		
		//El primer paso es generar una consulta SQl tal cual como lo hemos hecho en las 
		//clases anteriores, en este caso la consulta sera sobre la tabla usuarios
		//y tendra como parametros para filtro la cedula y el usuario
		
		$co = $this->getConexion();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try{
			
			
			$resultado = $co->prepare("Select * from tbl_usuarios where username like :nombre ");
			$resultado->bindValue(':nombre','%'.$this->nombre.'%');

			$resultado->execute();
			
			$fila = $resultado->fetchAll(PDO::FETCH_BOTH);
			
			$logoPath = 'img/logonew.png'; // Asegúrate de que la ruta sea correcta
			$logo = base64_encode(file_get_contents($logoPath));
			
			//aqui es donde comienza el cambio, debido a que se va a armar una variable en memoria
			//con el contenido html que se enviara a la libreria dompdf
			$html = "<html><head>";
            $html .= "<style>
            body { font-family: Arial, sans-serif; background-color: #fff; color: #333; margin: 0; padding: 0; }
            .container { width: 90%; max-width: 1000px; margin: 20px auto; border: 1px solid #ddd; background-color: #fff; padding: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
			 .header img { max-width: 150px; }
            h1 { font-size: 24px; color: #black; margin: 0; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 12px; text-align: center; font-size: 14px; color: #black; } /* Cambiado a text-align: center */
            th { background-color: #4481eb; color: #fff; border-bottom: 2px solid #0056b3; }
            tr:nth-child(even) { background-color: #aec8f5; }
            tr:hover { background-color: #e0f7fa; }
              </style>";
            $html .= "</head><body>";
            $html .= "<div class='container'>";
            $html .= "<div class='header'>";
			$html .= "<img src='data:image/png;base64,{$logo}' alt='Logo de la Empresa'>";
			$html .= "<h1>Listado de Usuarios</h1></div>";
            $html .= "<table>";
            $html .= "<thead>";
			$html = $html."<thead>";
			$html = $html."<tr>";
			$html = $html."<th>Nombre de Usuario</th>";
			$html = $html."<th>Rango del Usuario</th>";

			
			$html = $html."</tr>";
			$html = $html."</thead>";
			$html = $html."<tbody>";
			if($fila){
				
				foreach($fila as $f){
					$html = $html."<tr>";
					$html = $html."<td style='text-align:center'>".$f['username']."</td>";
					$html = $html."<td style='text-align:center'>".$f['rango']."</td>";
					
							 
					$html = $html."</tr>";
				}

				//return json_encode($fila);
				
			}
			else{
				
				//return '';
			}
			$html = $html."</tbody>";
			$html = $html."</table>";
		    $html = $html."</div></div></div>";
			$html = $html."</body></html>";
			
			
		}catch(Exception $e){
			//return $e->getMessage();
		}
		
		
		
		echo $html;
		exit ;

 
		// Instanciamos un objeto de la clase DOMPDF.
		$pdf = new DOMPDF();
		 
		// Definimos el tamaño y orientación del papel que queremos.
		$pdf->set_paper("A4", "portrait");
		 
		// Cargamos el contenido HTML.
		$pdf->load_html(utf8_decode($html));
		 
		// Renderizamos el documento PDF.
		$pdf->render();
		 
		// Enviamos el fichero PDF al navegador.
		$pdf->stream('ReporteUsuarios.pdf', array("Attachment" => false));
		
		
	}
	
	
	
	
	
	
	
	
}
?>