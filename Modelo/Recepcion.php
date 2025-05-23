<?php
require_once 'config.php';

class Recepcion extends BD{
    private $idproveedor;
    private $correlativo;
    private $desc;

    private $costo;
    private $tablerecepcion = 'tbl_recepcion_productos';




    public function getidproveedor() {
        return $this->idproveedor;
    }

   public function setidproveedor($idproveedor) {
        $this->idproveedor = $idproveedor;
    } 
    public function setcosto($costo) {
        $this->costo = $costo;
    }
    public function getdesc() {
        return $this->desc;
    }
    public function getcosto() {
        return $this->costo;
    }

   public function setdesc($desc) {
        $this->desc = $desc;
    } 
    public function getcorrelativo() {
        return $this->correlativo;
    }

    public function setcorrelativo($correlativo) {
        $this->correlativo = $correlativo;
    }
	public function registrar($idproducto, $cantidad, $costo) {
        $d = array();
        if (!$this->buscar()) {  // Asegúrate de que `buscar()` esté bien definido
            $co = $this->conexion();  // Asegúrate de que `conecta()` esté bien definido y retorne una conexión válida
            $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            try {
                // Insertar en tbl_recepcion_productos
                $tiempo = date('Y-m-d');
    
                // Asegúrate de que `$this->idproveedor` y `$this->correlativo` estén definidos
                $sql = "INSERT INTO tbl_recepcion_productos (id_proveedor, fecha, correlativo) 
                        VALUES (:idproveedor, :fecha_recepcion, :correlativo)";
                
                $stmt = $co->prepare($sql);
                $stmt->bindParam(':idproveedor', $this->idproveedor, PDO::PARAM_INT);
                $stmt->bindParam(':fecha_recepcion', $tiempo, PDO::PARAM_STR);
                $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
                $stmt->execute();
                
                $idRecepcion = $co->lastInsertId();
                
                $cap = count($idproducto);
    
                // Insertar en tbl_detalle_recepcion_productos
                for ($i = 0; $i < $cap; $i++) {
                    // Asegúrate de que `$this->desc` esté definido correctamente como una propiedad de la clase
                    $sqlDetalle = "INSERT INTO tbl_detalle_recepcion_productos (id_recepcion, id_producto, cantidad, costo) 
                                   VALUES (:idRecepcion, :idProducto, :cantidad, :costo)";
                    
                    $stmtDetalle = $co->prepare($sqlDetalle);
                    $stmtDetalle->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
                    $stmtDetalle->bindParam(':idProducto', $idproducto[$i], PDO::PARAM_INT); // Define $this->desc antes
                    $stmtDetalle->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
                    $stmtDetalle->bindParam(':costo', $costo[$i], PDO::PARAM_INT);
                    $stmtDetalle->execute();
                }
    
                $d['resultado'] = 'registrar';
                $d['mensaje'] = 'Se registró la nota de entrada correctamente';
            } catch (Exception $e) {
                $d['resultado'] = 'error';
                $d['mensaje'] = $e->getMessage();
            }
        } else {
            $d['resultado'] = 'registrar';
            $d['mensaje'] = 'El número correlativo ya existe!';
        }
        return $d;
    }
    
    
	
	
	public function obtenerproveedor(){
        $co = $this->conexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p = $co->prepare("SELECT id_proveedor,nombre FROM tbl_proveedores ");
        $p->execute();
        $r = $p->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }


	
	
	function listadoproductos(){
		$co = $this->conexion();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$r = array();
		try{
			
			$resultado = $co->query("SELECT p.id_producto, p.nombre_producto, m.nombre_modelo, mar.nombre_marca, p.serial
            FROM tbl_productos AS p 
            INNER JOIN tbl_modelos AS m ON p.id_modelo = m.id_modelo 
            INNER JOIN tbl_marcas AS mar ON m.id_marca = mar.id_marca;");
			
			if($resultado){
				
				$respuesta = '';
				foreach($resultado as $r){
					$respuesta = $respuesta."<tr style='cursor:pointer' onclick='colocaproducto(this);'>";
						$respuesta = $respuesta."<td style='display:none'>";
							$respuesta = $respuesta.$r['id_producto'];
						$respuesta = $respuesta."</td>";
						$respuesta = $respuesta."<td>";
							$respuesta = $respuesta.$r['id_producto'];
						$respuesta = $respuesta."</td>";
						$respuesta = $respuesta."<td>";
							$respuesta = $respuesta.$r['nombre_producto'];
						$respuesta = $respuesta."</td>";
                        $respuesta = $respuesta."<td>";
							$respuesta = $respuesta.$r['nombre_modelo'];
						$respuesta = $respuesta."</td>";
                        $respuesta = $respuesta."<td>";
							$respuesta = $respuesta.$r['nombre_marca'];
						$respuesta = $respuesta."</td>";
                        $respuesta = $respuesta."<td>";
							$respuesta = $respuesta.$r['serial'];
						$respuesta = $respuesta."</td>";
					$respuesta = $respuesta."</tr>";
				}
				
			    
			}
			$r['resultado'] = 'listado';
			$r['mensaje'] =  $respuesta;
			
		}catch(Exception $e){
			$r['resultado'] = 'error';
		    $r['mensaje'] =  $e->getMessage();
		}
		
		return $r;
		
	}

	// function consultar() {
    //     $sql = "SELECT * FROM tbl_dellate_recepcion_producto";
    //     $conexion = $this->conex->prepare($sql);
    //     $conexion->execute();
    //     $registros = $conexion->fetchAll(PDO::FETCH_ASSOC);
    //     return $registros;
    // }

	function buscar() {
        $co = $this->conexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {
            // Preparar la consulta para buscar el número de factura en tbl_recepcion_productos
            $stmt = $co->prepare("SELECT * FROM tbl_recepcion_productos WHERE correlativo = :correlativo");
            $stmt->execute(['correlativo' => $this->correlativo]);
            
            // Obtener los resultados
            $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Verificar si se encontró un resultado
            if ($fila) {
                $r['resultado'] = 'encontró';
                $r['mensaje'] = 'El número de el correlativo ya existe!';
            } 
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
    

    public function getrecepcion() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $queryrecepciones = 
        'SELECT r.fecha, r.correlativo, pr.nombre, pro.nombre_producto, d.cantidad, d.costo
        FROM tbl_recepcion_productos AS r 
        INNER JOIN tbl_detalle_recepcion_productos AS d ON d.id_recepcion = r.id_recepcion 
        INNER JOIN tbl_proveedores AS pr ON pr.id_proveedor = r.id_proveedor 
        INNER JOIN tbl_productos AS pro ON pro.id_producto = d.id_producto;';
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtrecepciones = $this->conexion()->prepare($queryrecepciones);
        $stmtrecepciones->execute();
        $recepciones = $stmtrecepciones->fetchAll(PDO::FETCH_ASSOC);

        return $recepciones;
    }

	

	
}


?>