<?php
require_once 'Config/config.php';

class Despacho extends BD{
    private $idcliente;
    private $correlativo;
    private $desc;
    private $fecha;
    private $tablerecepcion = 'tbl_despachos';




    public function getidcliente() {
        return $this->idcliente;
    }
    public function getfecha() {
        return $this->fecha;
    }
    public function setfecha($fecha) {
        $this->fecha = $fecha;
    }

   public function setidcliente($idcliente) {
        $this->idcliente = $idcliente;
    } 
    public function getdesc() {
        return $this->desc;
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
	public function registrar($idproducto, $cantidad) {
        $d = array();
        if (!$this->buscar()) {  // Asegúrate de que `buscar()` esté bien definido
            $co = $this->getConexion();  // Asegúrate de que `conecta()` esté bien definido y retorne una conexión válida
            $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            try {
                // Insertar en tbl_recepcion_productos
                $tiempo = date('Y-m-d');
    
                // Asegúrate de que `$this->idproveedor` y `$this->correlativo` estén definidos
                $sql = "INSERT INTO tbl_despachos (id_clientes, fecha_despacho, correlativo) 
                        VALUES (:id_cliente, :fecha_despacho, :correlativo)";
                
                $stmt = $co->prepare($sql);
                $stmt->bindParam(':id_cliente', $this->idcliente, PDO::PARAM_INT);
                $stmt->bindParam(':fecha_recepcion', $tiempo, PDO::PARAM_STR);
                $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
                $stmt->execute();
                
                $idRecepcion = $co->lastInsertId();
                
                $cap = count($idproducto);
    
                // Insertar en tbl_detalle_recepcion_productos
                for ($i = 0; $i < $cap; $i++) {
                    // Asegúrate de que `$this->desc` esté definido correctamente como una propiedad de la clase
                    $sqlDetalle = "INSERT INTO tbl_despacho_detalle (id_despacho, id_producto, cantidad) 
                                   VALUES (:id_despacho, :idProducto, :cantidad, :costo)";
                    
                    $stmtDetalle = $co->prepare($sqlDetalle);
                    $stmtDetalle->bindParam(':id_despacho', $idDespacho, PDO::PARAM_INT);
                    $stmtDetalle->bindParam(':idProducto', $idproducto[$i], PDO::PARAM_INT); // Define $this->desc antes
                    $stmtDetalle->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
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
    
    public function modificar($idRecepcion, $idproducto, $cantidad, $costo, $iddetalle)
{
    $d = array();

    try {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $co->beginTransaction();

        // Actualizar la recepción principal
        $sqlRecepcion = "UPDATE tbl_despachos 
                         SET id_clientes = :id_cliente, fecha = :fecha, correlativo = :correlativo 
                         WHERE id_despachos = :idDespacho";
        $stmt = $co->prepare($sqlRecepcion);
        $stmt->bindParam(':id_cliente', $this->idcliente, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
        $stmt->bindParam(':idDespacho', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los detalles actuales
        $sqlExistentes = "SELECT id_detalle FROM tbl_despacho_detalle WHERE id_despachos = :idDespacho";
        $stmt = $co->prepare($sqlExistentes);
        $stmt->bindParam(':idDespacho', $idDespacho, PDO::PARAM_INT);
        $stmt->execute();
        $detallesExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        // Detectar detalles que deben ser eliminados
        $idsConservados = array_filter($iddetalle); // eliminar nulls (los nuevos productos no tienen id)
        $idsEliminar = array_diff($detallesExistentes, $idsConservados);

        if (!empty($idsEliminar)) {
            $in = implode(',', array_fill(0, count($idsEliminar), '?'));
            $sqlDelete = "DELETE FROM tbl_despacho_detalle WHERE id_detalle_recepcion_productos IN ($in)";
            $stmt = $co->prepare($sqlDelete);
            foreach (array_values($idsEliminar) as $k => $id) {
                $stmt->bindValue($k + 1, $id, PDO::PARAM_INT);
            }
            $stmt->execute();
        }

        // Insertar o actualizar productos
        $cap = count($idproducto);
        for ($i = 0; $i < $cap; $i++) {
            if (!empty($iddetalle[$i])) {
                // Producto existente → actualizar
                $sqlUpdate = "UPDATE tbl_despacho_detalle
                              SET id_producto = :idproducto, cantidad = :cantidad
                              WHERE id_detalle = :iddetalle";
                $stmt = $co->prepare($sqlUpdate);
                $stmt->bindParam(':idproducto', $idproducto[$i], PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
                $stmt->bindParam(':iddetalle', $iddetalle[$i], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Producto nuevo → insertar
                $sqlInsert = "INSERT INTO tbl_despacho_detalles (id_recepcion, id_producto, cantidad) 
                              VALUES (:idDespacho, :idproducto, :cantidad)";
                $stmt = $co->prepare($sqlInsert);
                $stmt->bindParam(':idDespacho', $idDespacho, PDO::PARAM_INT);
                $stmt->bindParam(':idproducto', $idproducto[$i], PDO::PARAM_INT);
                $stmt->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        $co->commit();
        $d['resultado'] = 'modificarRecepcion';
        $d['mensaje'] = 'Se modificó la recepción y sus productos correctamente';

    } catch (Exception $e) {
        if ($co->inTransaction()) {
            $co->rollBack();
        }
        $d['resultado'] = 'error';
        $d['mensaje'] = $e->getMessage();
    }

    return $d;
}

	
	
	public function obtenercliente(){
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p = $co->prepare("SELECT * FROM tbl_clientes ");
        $p->execute();
        $r = $p->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }


	
	
	function listadoproductos(){
		$co = $this->getConexion();
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

	function consultarproductos() {
    $sql = "SELECT p.id_producto, p.nombre_producto, m.nombre_modelo, mar.nombre_marca, p.serial
            FROM tbl_productos AS p 
            INNER JOIN tbl_modelos AS m ON p.id_modelo = m.id_modelo 
            INNER JOIN tbl_marcas AS mar ON m.id_marca = mar.id_marca;";
    $conexion = $this->getConexion()->prepare($sql);
    $conexion->execute();
    $registros = $conexion->fetchAll(PDO::FETCH_ASSOC);
    return $registros;
    }

	function buscar() {
        $co = $this->getConexion();
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
    

    public function getdespacho() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querydespachos = 
        'SELECT 
    d.id_detalle,
    r.id_despachos,
    pro.id_producto,
    c.id_clientes,
    r.fecha_despacho,
    r.correlativo,
    c.nombre AS nombre_cliente,
    pro.nombre_producto,
    d.cantidad
FROM tbl_despachos AS r
INNER JOIN tbl_despacho_detalle AS d ON d.id_despacho = r.id_despachos
INNER JOIN tbl_clientes AS c ON c.id_clientes = r.id_clientes
INNER JOIN tbl_productos AS pro ON pro.id_producto = d.id_producto
ORDER BY r.correlativo ASC;
';
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtdespachos = $this->getConexion()->prepare($querydespachos);
        $stmtdespachos->execute();
        $despachos = $stmtdespachos->fetchAll(PDO::FETCH_ASSOC);

        return $despachos;
    }

	public function obtenerDetallesPorDespacho($idDespacho) {
    $datos = [];

    try {
        $co = $this->getConexion(); // Asegúrate de que esta función devuelve una conexión PDO válida
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultar productos de esa recepción
        $sql = "SELECT dr.id_producto, dr.cantidad, dr.costo, p.nombre 
                FROM tbl_detalle_recepcion_productos dr
                INNER JOIN tbl_productos p ON dr.id_producto = p.id
                WHERE dr.id_recepcion = :idRecepcion";

        $stmt = $co->prepare($sql);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Consultar todos los productos (para el <select>)
        $sqlProductos = "SELECT id, nombre FROM tbl_productos";
        $productosTodos = $co->query($sqlProductos)->fetchAll(PDO::FETCH_ASSOC);

        // Agregar opciones al array de productos
        foreach ($productos as &$producto) {
            $opciones = '';
            foreach ($productosTodos as $item) {
                $selected = ($item['id'] == $producto['id_producto']) ? 'selected' : '';
                $opciones .= "<option value='{$item['id']}' $selected>{$item['nombre']}</option>";
            }
            $producto['opciones'] = $opciones;
        }

        $datos = $productos;

    } catch (Exception $e) {
        $datos = [
            'error' => true,
            'mensaje' => $e->getMessage()
        ];
    }

    return $datos;
}


	
}


?>