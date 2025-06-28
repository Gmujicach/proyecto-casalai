<?php
require_once 'Config/config.php';

class Recepcion extends BD{
    private $idproveedor;
    private $correlativo;
    private $desc;
    private $fecha;
    private $costo;
    private $tablerecepcion = 'tbl_recepcion_productos';




    public function getidproveedor() {
        return $this->idproveedor;
    }
    public function getfecha() {
        return $this->fecha;
    }
    public function setfecha($fecha) {
        $this->fecha = $fecha;
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
    if (!$this->buscar()) {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $tiempo = date('Y-m-d');
            $sql = "INSERT INTO tbl_recepcion_productos (id_proveedor, fecha, correlativo) 
                    VALUES (:idproveedor, :fecha_recepcion, :correlativo)";
            $stmt = $co->prepare($sql);
            $stmt->bindParam(':idproveedor', $this->idproveedor, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_recepcion', $tiempo, PDO::PARAM_STR);
            $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
            $stmt->execute();

            $idRecepcion = $co->lastInsertId();
            $cap = count($idproducto);

            $descripcion = "Compra: ";
            $monto_total = 0;
for ($i = 0; $i < $cap; $i++) {
    $sqlDetalle = "INSERT INTO tbl_detalle_recepcion_productos (id_recepcion, id_producto, cantidad, costo) 
                   VALUES (:idRecepcion, :idProducto, :cantidad, :costo)";
    $stmtDetalle = $co->prepare($sqlDetalle);
    $stmtDetalle->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
    $stmtDetalle->bindParam(':idProducto', $idproducto[$i], PDO::PARAM_INT);
    $stmtDetalle->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
    $stmtDetalle->bindParam(':costo', $costo[$i], PDO::PARAM_INT);
    $stmtDetalle->execute();

    // Obtener nombre del producto
    $sqlNombre = "SELECT nombre_producto FROM tbl_productos WHERE id_producto = ?";
    $stmtNombre = $co->prepare($sqlNombre);
    $stmtNombre->execute([$idproducto[$i]]);
    $nombreProducto = $stmtNombre->fetchColumn();

    // Para el egreso
    $descripcion .= "{$nombreProducto} (x{$cantidad[$i]}), ";
    $monto_total += $costo[$i] * $cantidad[$i];
}
            $descripcion = rtrim($descripcion, ', ');

            // Registrar egreso en tbl_ingresos_egresos
            $sqlEgreso = "INSERT INTO tbl_ingresos_egresos (tipo, monto, descripcion, fecha, estado, id_detalle_recepcion_productos)
                          VALUES ('egreso', ?, ?, ?, 1, ?)";
            $stmtEgreso = $co->prepare($sqlEgreso);
            $stmtEgreso->execute([$monto_total, $descripcion, $tiempo, $idRecepcion]);

            $d['resultado'] = 'registrar';
            $d['mensaje'] = 'Se registró la nota de entrada correctamente y el egreso fue registrado.';
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
        $sqlRecepcion = "UPDATE tbl_recepcion_productos 
                         SET id_proveedor = :idproveedor, fecha = :fecha, correlativo = :correlativo 
                         WHERE id_recepcion = :idRecepcion";
        $stmt = $co->prepare($sqlRecepcion);
        $stmt->bindParam(':idproveedor', $this->idproveedor, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los detalles actuales
        $sqlExistentes = "SELECT id_detalle_recepcion_productos FROM tbl_detalle_recepcion_productos WHERE id_recepcion = :idRecepcion";
        $stmt = $co->prepare($sqlExistentes);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();
        $detallesExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        // Detectar detalles que deben ser eliminados
        $idsConservados = array_filter($iddetalle);
        $idsEliminar = array_diff($detallesExistentes, $idsConservados);

        if (!empty($idsEliminar)) {
            $in = implode(',', array_fill(0, count($idsEliminar), '?'));
            $sqlDelete = "DELETE FROM tbl_detalle_recepcion_productos WHERE id_detalle_recepcion_productos IN ($in)";
            $stmt = $co->prepare($sqlDelete);
            foreach (array_values($idsEliminar) as $k => $id) {
                $stmt->bindValue($k + 1, $id, PDO::PARAM_INT);
            }
            $stmt->execute();
        }

        // Insertar o actualizar productos
        $cap = count($idproducto);
        $descripcion = "Compra: ";
        $monto_total = 0;

for ($i = 0; $i < $cap; $i++) {
    if (!empty($iddetalle[$i])) {
        // Producto existente → actualizar
        $sqlUpdate = "UPDATE tbl_detalle_recepcion_productos 
                      SET id_producto = :idproducto, cantidad = :cantidad, costo = :costo 
                      WHERE id_detalle_recepcion_productos = :iddetalle";
        $stmt = $co->prepare($sqlUpdate);
        $stmt->bindParam(':idproducto', $idproducto[$i], PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
        $stmt->bindParam(':costo', $costo[$i], PDO::PARAM_INT);
        $stmt->bindParam(':iddetalle', $iddetalle[$i], PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // Producto nuevo → insertar
        $sqlInsert = "INSERT INTO tbl_detalle_recepcion_productos (id_recepcion, id_producto, cantidad, costo) 
                      VALUES (:idRecepcion, :idproducto, :cantidad, :costo)";
        $stmt = $co->prepare($sqlInsert);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->bindParam(':idproducto', $idproducto[$i], PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
        $stmt->bindParam(':costo', $costo[$i], PDO::PARAM_INT);
        $stmt->execute();
    }
    // Obtener nombre del producto
    $sqlNombre = "SELECT nombre_producto FROM tbl_productos WHERE id_producto = ?";
    $stmtNombre = $co->prepare($sqlNombre);
    $stmtNombre->execute([$idproducto[$i]]);
    $nombreProducto = $stmtNombre->fetchColumn();

    // Para el egreso
    $descripcion .= "{$nombreProducto} (x{$cantidad[$i]}), ";
    $monto_total += $costo[$i] * $cantidad[$i];
}
        $descripcion = rtrim($descripcion, ', ');

        // Actualizar o insertar egreso en tbl_ingresos_egresos
        $sqlCheck = "SELECT id_finanzas FROM tbl_ingresos_egresos WHERE id_detalle_recepcion_productos = ?";
        $stmt = $co->prepare($sqlCheck);
        $stmt->execute([$idRecepcion]);
        $egreso = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($egreso) {
            // Actualizar egreso existente
            $sqlEgreso = "UPDATE tbl_ingresos_egresos SET monto = ?, descripcion = ?, fecha = ?, estado = 1 WHERE id_detalle_recepcion_productos = ?";
            $stmt = $co->prepare($sqlEgreso);
            $stmt->execute([$monto_total, $descripcion, $this->fecha, $idRecepcion]);
        } else {
            // Insertar nuevo egreso
            $sqlEgreso = "INSERT INTO tbl_ingresos_egresos (tipo, monto, descripcion, fecha, estado, id_detalle_recepcion_productos)
                          VALUES ('egreso', ?, ?, ?, 1, ?)";
            $stmt = $co->prepare($sqlEgreso);
            $stmt->execute([$monto_total, $descripcion, $this->fecha, $idRecepcion]);
        }

        $co->commit();
        $d['resultado'] = 'modificarRecepcion';
        $d['mensaje'] = 'Se modificó la recepción y sus productos correctamente, y el egreso fue actualizado.';

    } catch (Exception $e) {
        if ($co->inTransaction()) {
            $co->rollBack();
        }
        $d['resultado'] = 'error';
        $d['mensaje'] = $e->getMessage();
    }

    return $d;
}

	
	
	public function obtenerproveedor(){
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p = $co->prepare("SELECT id_proveedor,nombre_proveedor FROM tbl_proveedores ");
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
    

public function getrecepcion() {
    $queryrecepciones = 
    'SELECT d.id_detalle_recepcion_productos,
        r.id_recepcion, pro.id_producto, pr.id_proveedor,
        r.fecha, r.correlativo, pr.nombre_proveedor, pro.nombre_producto, d.cantidad, d.costo
    FROM tbl_recepcion_productos AS r 
    INNER JOIN tbl_detalle_recepcion_productos AS d ON d.id_recepcion = r.id_recepcion 
    INNER JOIN tbl_proveedores AS pr ON pr.id_proveedor = r.id_proveedor 
    INNER JOIN tbl_productos AS pro ON pro.id_producto = d.id_producto
    ORDER BY r.fecha ASC, r.correlativo ASC, pro.nombre_producto ASC';

    $stmtrecepciones = $this->getConexion()->prepare($queryrecepciones);
    $stmtrecepciones->execute();
    $recepciones = $stmtrecepciones->fetchAll(PDO::FETCH_ASSOC);

    return $recepciones;
}

	public function obtenerDetallesPorRecepcion($idRecepcion) {
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