<?php
require_once 'Config/Config.php';

class Carrito extends BD{
    private $conex;


    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }


    // Métodos básicos del carrito
    public function crearCarrito($id_cliente) {
        $sql = "INSERT INTO tbl_carrito (id_cliente) VALUES (:id_cliente)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        return $stmt->execute();
    }

    public function obtenerCarritoPorCliente($id_cliente) {
        $sql = "SELECT id_carrito, id_cliente FROM tbl_carrito WHERE id_cliente = :id_cliente";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarProductoAlCarrito($id_carrito, $id_producto, $cantidad = 1) {
        // Verificar si el producto ya está en el carrito
        $sqlCheck = "SELECT id_carrito_detalle, cantidad FROM tbl_carritodetalle 
                     WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
        $stmtCheck = $this->conex->prepare($sqlCheck);
        $stmtCheck->bindParam(':id_carrito', $id_carrito);
        $stmtCheck->bindParam(':id_producto', $id_producto);
        $stmtCheck->execute();
        $existente = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existente) {
            // Actualizar cantidad si ya existe
            $nuevaCantidad = $existente['cantidad'] + $cantidad;
            $sqlUpdate = "UPDATE tbl_carritodetalle SET cantidad = :cantidad 
                          WHERE id_carrito_detalle = :id_carrito_detalle";
            $stmtUpdate = $this->conex->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':cantidad', $nuevaCantidad);
            $stmtUpdate->bindParam(':id_carrito_detalle', $existente['id_carrito_detalle']);
            return $stmtUpdate->execute();
        } else {
            // Insertar nuevo producto en el carrito
            $sqlInsert = "INSERT INTO tbl_carritodetalle (id_carrito, id_producto, cantidad) 
                          VALUES (:id_carrito, :id_producto, :cantidad)";
            $stmtInsert = $this->conex->prepare($sqlInsert);
            $stmtInsert->bindParam(':id_carrito', $id_carrito);
            $stmtInsert->bindParam(':id_producto', $id_producto);
            $stmtInsert->bindParam(':cantidad', $cantidad);
            return $stmtInsert->execute();
        }
    }

    public function obtenerProductosDelCarrito($id_carrito) {
        $sql = "SELECT cd.id_carrito_detalle, p.id_producto, p.nombre_producto AS nombre, 
                       cd.cantidad, p.precio, (cd.cantidad * p.precio) AS subtotal
                FROM tbl_carritodetalle cd
                INNER JOIN tbl_productos p ON cd.id_producto = p.id_producto
                WHERE cd.id_carrito = :id_carrito";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarCantidadProducto($id_carrito_detalle, $cantidad) {
        $sql = "UPDATE tbl_carritodetalle SET cantidad = :cantidad 
                WHERE id_carrito_detalle = :id_carrito_detalle";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_carrito_detalle', $id_carrito_detalle);
        return $stmt->execute();
    }

    public function eliminarProductoDelCarrito($id_carrito_detalle) {
        $sql = "DELETE FROM tbl_carritodetalle WHERE id_carrito_detalle = :id_carrito_detalle";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito_detalle', $id_carrito_detalle);
        return $stmt->execute();
    }

    public function eliminarTodoElCarrito($id_carrito) {
        $sql = "DELETE FROM tbl_carritodetalle WHERE id_carrito = :id_carrito";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        return $stmt->execute();
    }

    // Métodos para combos
    public function agregarComboAlCarrito($id_carrito, $id_combo) {
        try {
            $this->conex->beginTransaction();
            
            // Obtener los detalles del combo
            $sqlDetalles = "SELECT id_producto, cantidad FROM combo_detalle WHERE id_combo = :id_combo";
            $stmtDetalles = $this->conex->prepare($sqlDetalles);
            $stmtDetalles->bindParam(':id_combo', $id_combo);
            $stmtDetalles->execute();
            $detalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
            
            // Agregar cada producto del combo al carrito
            foreach ($detalles as $detalle) {
                $this->agregarProductoAlCarrito($id_carrito, $detalle['id_producto'], $detalle['cantidad']);
            }
            
            $this->conex->commit();
            return true;
        } catch (PDOException $e) {
            $this->conex->rollBack();
            error_log("Error al agregar combo al carrito: " . $e->getMessage());
            return false;
        }
    }

    // Métodos para compras
public function registrarCompra($id_carrito, $id_cliente, $productos)
{
    try {
        // Validar que todos los productos estén completos antes de iniciar la transacción
        foreach ($productos as $detalle) {
            if (empty($detalle['id_producto']) || empty($detalle['cantidad']) || !is_numeric($detalle['cantidad'])) {
                error_log("Producto con datos incompletos o inválidos: " . json_encode($detalle));
                throw new Exception("Uno o más productos tienen datos incompletos o inválidos.");
            }
        }

        // Iniciar transacción
        $this->conex->beginTransaction();

        // Insertar la factura principal
        $sqlCompra = "INSERT INTO tbl_facturas (fecha, cliente, descuento, estatus) 
                      VALUES (NOW(), :id_cliente, 0, 'Borrador')";
        $stmtCompra = $this->conex->prepare($sqlCompra);
        $stmtCompra->bindValue(':id_cliente', $id_cliente);
        $stmtCompra->execute();
        $id_factura = $this->conex->lastInsertId();

        // Preparar consultas para detalle y stock
        $sqlDetalle = "INSERT INTO tbl_factura_detalle (factura_id, id_producto, cantidad) 
                       VALUES (:id_factura, :id_producto, :cantidad)";
        $stmtDetalle = $this->conex->prepare($sqlDetalle);

        $sqlUpdateStock = "UPDATE tbl_productos SET stock = stock - :cantidad WHERE id_producto = :id_producto";
        $stmtUpdateStock = $this->conex->prepare($sqlUpdateStock);

        // Insertar cada detalle de producto
        foreach ($productos as $detalle) {
            $stmtDetalle->bindValue(':id_factura', $id_factura);
            $stmtDetalle->bindValue(':id_producto', $detalle['id_producto']);
            $stmtDetalle->bindValue(':cantidad', $detalle['cantidad']);
            $stmtDetalle->execute();

            $stmtUpdateStock->bindValue(':cantidad', $detalle['cantidad']);
            $stmtUpdateStock->bindValue(':id_producto', $detalle['id_producto']);
            $stmtUpdateStock->execute();
        }

        // Vaciar el carrito
        $this->eliminarTodoElCarrito($id_carrito);

        // Confirmar la transacción
        $this->conex->commit();
        return true;
    } catch (Exception $e) {
    $this->conex->rollBack();
    error_log("Error al registrar compra: " . $e->getMessage());
    return ['error' => $e->getMessage()];
}

}



}