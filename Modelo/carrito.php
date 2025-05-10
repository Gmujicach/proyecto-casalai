<?php
require_once 'config.php';

class Carrito extends BD{
    private $conex;

    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }

    // Métodos para el carrito
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

    public function agregarProductoAlCarrito($id_carrito, $id_producto, $cantidad) {
        $sql = "INSERT INTO tbl_carritodetalle (id_carrito, id_producto, cantidad) VALUES (:id_carrito, :id_producto, :cantidad)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }

    public function obtenerProductosDelCarrito($id_carrito) {
        $sql = "SELECT cd.id_carrito_detalle, p.nombre_producto AS nombre, cd.cantidad, p.precio, (cd.cantidad * p.precio) AS subtotal
                FROM tbl_carritodetalle cd
                INNER JOIN tbl_productos p ON cd.id_producto = p.id_producto
                WHERE cd.id_carrito = :id_carrito";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarCantidadProducto($id_carrito_detalle, $cantidad) {
        $sql = "UPDATE tbl_carritodetalle SET cantidad = :cantidad WHERE id_carrito_detalle = :id_carrito_detalle";
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

    public function registrarCompra($id_carrito, $id_cliente) {
        // Obtener los detalles del carrito
        $detallesCarrito = $this->obtenerProductosDelCarrito($id_carrito);

        // Calcular el total de la compra
        $total = 0;
        foreach ($detallesCarrito as $detalle) {
            $total += $detalle['subtotal'];
        }

        // Insertar la compra en la tabla tbl_compra
        $sqlCompra = "INSERT INTO tbl_compra (id_cliente, total) VALUES (:id_cliente, :total)";
        $stmtCompra = $this->conex->prepare($sqlCompra);
        $stmtCompra->bindParam(':id_cliente', $id_cliente);
        $stmtCompra->bindParam(':total', $total);
        $stmtCompra->execute();

        // Obtener el ID de la compra recién insertada
        $id_compra = $this->conex->lastInsertId();

        // Insertar los detalles de la compra en la tabla tbl_detallecompra
        foreach ($detallesCarrito as $detalle) {
            $sqlDetalle = "INSERT INTO tbl_detallecompra (id_compra, id_producto, cantidad, precio_unitario)
                           VALUES (:id_compra, :id_producto, :cantidad, :precio_unitario)";
            $stmtDetalle = $this->conex->prepare($sqlDetalle);
            $stmtDetalle->bindParam(':id_compra', $id_compra);
            $stmtDetalle->bindParam(':id_producto', $detalle['id_producto']);
            $stmtDetalle->bindParam(':cantidad', $detalle['cantidad']);
            $stmtDetalle->bindParam(':precio_unitario', $detalle['precio']);
            $stmtDetalle->execute();
        }

        // Eliminar los productos del carrito después de registrar la compra
        $this->eliminarTodoElCarrito($id_carrito);

        return true;
    }
}