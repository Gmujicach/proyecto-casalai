<?php
require_once 'config/config.php';

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

            $productosArray = [];

            for ($i = 0; $i < $cap; $i++) {
                $sqlDetalle = "INSERT INTO tbl_detalle_recepcion_productos (id_recepcion, id_producto, cantidad, costo) 
                               VALUES (:idRecepcion, :idProducto, :cantidad, :costo)";
                $stmtDetalle = $co->prepare($sqlDetalle);
                $stmtDetalle->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':idProducto', $idproducto[$i], PDO::PARAM_INT);
                $stmtDetalle->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
                $stmtDetalle->bindParam(':costo', $costo[$i], PDO::PARAM_INT);
                $stmtDetalle->execute();
                $idDetalle = $co->lastInsertId(); // ✅ ID del detalle recién insertado

      // Obtener nombre del producto
                $sqlNombre = "SELECT id_producto FROM tbl_productos WHERE id_producto = ?";
                $stmtNombre = $co->prepare($sqlNombre);
                $stmtNombre->execute([$idproducto[$i]]);
                $idProducto = $stmtNombre->fetchColumn();

                $sqlNombre = "SELECT nombre_producto FROM tbl_productos WHERE id_producto = ?";
                $stmtNombre = $co->prepare($sqlNombre);
                $stmtNombre->execute([$idproducto[$i]]);
                $nombreProducto = $stmtNombre->fetchColumn();

                $productosArray[] = [
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad[$i],
                    'costo' => $costo[$i],
                    'iddetalles' => $idDetalle
                ];

                $monto_total = $costo[$i] * $cantidad[$i];
                $descripcion = "Compra: {$nombreProducto} (x{$cantidad[$i]})";

                // Registrar egreso
                $sqlEgreso = "INSERT INTO tbl_ingresos_egresos (tipo, monto, descripcion, fecha, estado, id_detalle_recepcion_productos)
                              VALUES ('egreso', ?, ?, ?, 1, LAST_INSERT_ID())";
                $stmtEgreso = $co->prepare($sqlEgreso);
                $stmtEgreso->execute([$monto_total, $descripcion, $tiempo]);
            }

            $d['resultado'] = 'registrar';
            $d['mensaje'] = 'Se registró la nota de entrada correctamente.';
            $d['data'] = [
                'fecha' => $tiempo,
                'correlativo' => $this->correlativo,
                'proveedor' => $this->idproveedor,
                'productos' => $productosArray,
                'nombre_producto' => $nombreProducto,
                'id_recepcion' => $idRecepcion
            ];

        } catch (Exception $e) {
            $d['resultado'] = 'error';
            $d['mensaje'] = $e->getMessage();
        }
    } else {
        $d['resultado'] = 'encontro';
        $d['mensaje'] = 'El número correlativo ya existe!';
    }
    return $d;
}

    

public function modificar($idRecepcion, $idproducto, $cantidad, $costo, $iddetalle)
{
    $d = [];

    try {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $co->beginTransaction();

        // Validación básica
        if (empty($idRecepcion) || !is_array($idproducto) || !is_array($cantidad) || !is_array($costo)) {
            throw new Exception("Datos de entrada inválidos");
        }

        // Actualizar cabecera de recepción
        $sqlRecepcion = "UPDATE tbl_recepcion_productos 
                         SET id_proveedor = :idproveedor, fecha = :fecha, correlativo = :correlativo 
                         WHERE id_recepcion = :idRecepcion";
        $stmt = $co->prepare($sqlRecepcion);
        $stmt->bindParam(':idproveedor', $this->idproveedor, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
        $stmt->bindParam(':correlativo', $this->correlativo, PDO::PARAM_STR);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener IDs actuales de detalles
        $sqlExistentes = "SELECT id_detalle_recepcion_productos FROM tbl_detalle_recepcion_productos WHERE id_recepcion = :idRecepcion";
        $stmt = $co->prepare($sqlExistentes);
        $stmt->bindParam(':idRecepcion', $idRecepcion, PDO::PARAM_INT);
        $stmt->execute();
        $detallesExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $idsConservados = array_filter($iddetalle);
        $idsEliminar = array_diff($detallesExistentes, $idsConservados);

        // Eliminar egresos y detalles que ya no están
        if (!empty($idsEliminar)) {
            $in = implode(',', array_fill(0, count($idsEliminar), '?'));

            $sqlDeleteEgresos = "DELETE FROM tbl_ingresos_egresos WHERE id_detalle_recepcion_productos IN ($in)";
            $stmt = $co->prepare($sqlDeleteEgresos);
            foreach (array_values($idsEliminar) as $k => $id) {
                $stmt->bindValue($k + 1, $id, PDO::PARAM_INT);
            }
            $stmt->execute();

            $sqlDeleteDetalles = "DELETE FROM tbl_detalle_recepcion_productos WHERE id_detalle_recepcion_productos IN ($in)";
            $stmt = $co->prepare($sqlDeleteDetalles);
            foreach (array_values($idsEliminar) as $k => $id) {
                $stmt->bindValue($k + 1, $id, PDO::PARAM_INT);
            }
            $stmt->execute();
        }

        // Insertar o actualizar detalles y egresos
        for ($i = 0; $i < count($idproducto); $i++) {
            $idProd = (int)$idproducto[$i];
            $cant = (int)$cantidad[$i];
            $cost = (float)$costo[$i];
            $idDet = $iddetalle[$i] ?? null;

            // Obtener nombre del producto
            $stmtNombre = $co->prepare("SELECT nombre_producto FROM tbl_productos WHERE id_producto = ?");
            $stmtNombre->execute([$idProd]);
            $nombreProducto = $stmtNombre->fetchColumn();
            if (!$nombreProducto) {
                throw new Exception("Producto no encontrado con ID $idProd");
            }

            $descripcion = "Compra: {$nombreProducto} (x{$cant})";
            $monto_total = $cant * $cost;

            if (!empty($idDet)) {
                // Actualizar detalle existente
                $sqlUpdateDetalle = "UPDATE tbl_detalle_recepcion_productos 
                                     SET id_producto = ?, cantidad = ?, costo = ? 
                                     WHERE id_detalle_recepcion_productos = ?";
                $stmt = $co->prepare($sqlUpdateDetalle);
                $stmt->execute([$idProd, $cant, $cost, $idDet]);

                // Actualizar egreso asociado
                $sqlUpdateEgreso = "UPDATE tbl_ingresos_egresos 
                                    SET monto = ?, descripcion = ?, fecha = ?, estado = 1 
                                    WHERE id_detalle_recepcion_productos = ?";
                $stmt = $co->prepare($sqlUpdateEgreso);
                $stmt->execute([$monto_total, $descripcion, $this->fecha, $idDet]);

            } else {
                // Insertar nuevo detalle
                $sqlInsertDetalle = "INSERT INTO tbl_detalle_recepcion_productos 
                                     (id_recepcion, id_producto, cantidad, costo) 
                                     VALUES (?, ?, ?, ?)";
                $stmt = $co->prepare($sqlInsertDetalle);
                $stmt->execute([$idRecepcion, $idProd, $cant, $cost]);

                $nuevoIdDetalle = $co->lastInsertId();

                // Insertar nuevo egreso
                $sqlInsertEgreso = "INSERT INTO tbl_ingresos_egresos 
                                    (tipo, monto, descripcion, fecha, estado, id_detalle_recepcion_productos) 
                                    VALUES ('egreso', ?, ?, ?, 1, ?)";
                $stmt = $co->prepare($sqlInsertEgreso);
                $stmt->execute([$monto_total, $descripcion, $this->fecha, $nuevoIdDetalle]);
            }
        }

        // Confirmar transacción
        $co->commit();
        // Después de commit
$d['resultado'] = 'modificarRecepcion';
$d['mensaje'] = 'Recepción modificada correctamente.';
$d['data'] = [
    'id_recepcion' => $idRecepcion,
    'fecha' => $this->fecha,
    'correlativo' => $this->correlativo,
    'proveedor' => $this->idproveedor,
    'productos' => [] // Aquí incluyes los productos modificados
];

$d['data']['productos'] = [];
foreach ($idproducto as $i => $idProd) {
    $stmtNombre = $co->prepare("SELECT nombre_producto FROM tbl_productos WHERE id_producto = ?");
    $stmtNombre->execute([$idProd]);
    $nombreProdActual = $stmtNombre->fetchColumn();

    $d['data']['productos'][] = [
        'id_producto' => $idProd,
        'nombre_producto' => $nombreProdActual,
        'cantidad' => $cantidad[$i],
        'costo' => $costo[$i]
    ];
}



    } catch (PDOException $pdoEx) {
        if ($co->inTransaction()) {
            $co->rollBack();
        }
        $d['resultado'] = 'error';
        $d['mensaje'] = 'Error de base de datos: ' . $pdoEx->getMessage();
    } catch (Exception $ex) {
        if ($co->inTransaction()) {
            $co->rollBack();
        }
        $d['resultado'] = 'error';
        $d['mensaje'] = 'Excepción: ' . $ex->getMessage();
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
       public function obtenerUltimaRecepcion() {
        return $this->obtUltimaRecepcion();
    }

    private function obtUltimaRecepcion() {
        $sql = "SELECT d.id_detalle_recepcion_productos,
        r.id_recepcion, pro.id_producto, pr.id_proveedor,
        r.fecha, r.correlativo, pr.nombre_proveedor, pro.nombre_producto, d.cantidad, d.costo
    FROM tbl_recepcion_productos AS r 
    INNER JOIN tbl_detalle_recepcion_productos AS d ON d.id_recepcion = r.id_recepcion 
    INNER JOIN tbl_proveedores AS pr ON pr.id_proveedor = r.id_proveedor 
    INNER JOIN tbl_productos AS pro ON pro.id_producto = d.id_producto
    ORDER BY r.fecha ASC, r.correlativo ASC, pro.nombre_producto ASC
                ORDER BY r.id_recepcion DESC LIMIT 1";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->execute();
        $orden = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $orden ? $orden : null;
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