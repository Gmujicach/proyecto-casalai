<?php
require_once 'config.php';

class Catalogo extends BD {
    private $tablaCombo = 'tbl_combo';
    private $conex;
    private $cantidad;
    private $id_producto;

    public function __construct() {
        $this->conex = (new Conexion())->Conex();
    }

    // Getters and Setters

    public function setIdProducto($id_producto){
        $this->id_producto = $id_producto;
    }

    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }


    public function insertarCombo(){
        $sql = "INSERT INTO {$this->tablaCombo} (id_producto, cantidad)
                VALUES (:id_producto, :cantidad)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_producto', $this->id_producto);
        $stmt->bindParam(':cantidad', $this->cantidad);
        return $stmt->execute();
    }

    /*public function obtenerProductos(){
        $sql = "SELECT id_producto, nombre_producto, precio
                FROM productos";
                $stmt = $this->conex->prepare($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

    public function obtenerProductos() {
        $sql = "SELECT p.id_producto, p.nombre_producto, m.nombre_modelo, c.nombre_caracteristicas AS categoria, p.stock, p.precio
                FROM productos p
                INNER JOIN modelo m ON p.id_modelo = m.id_modelo
                INNER JOIN categoria c ON p.id_categoria = c.id_categoria
                WHERE p.estado = 1";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*public function obtenerCombos() {
        $sql = "SELECT c.id_combo, c.id_producto, c.cantidad, p.nombre_producto, p.precio
                FROM {$this->tablaCombo} c
                INNER JOIN productos p ON c.id_producto = p.id
                ORDER BY c.id_combo";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/

    public function obtenerCombos() {
        $sql = "SELECT c.id_combo, GROUP_CONCAT(p.nombre_producto SEPARATOR ', ') AS productos,
                SUM(p.precio * c.cantidad) AS precio_total
                FROM tbl_combo c
                INNER JOIN productos p ON c.id_producto = p.id_producto
                GROUP BY c.id_combo
                ORDER BY c.id_combo DESC";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function eliminarCombo($id_combo){
        $sql = "DELETE FROM {$this->tablaCombo} WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        return $stmt->execute();
    }

    public function obtenerUltimoIdCombo(){
        $sql = "SELECT MAX(id_combo) AS ultimo_id FROM {$this->tablaCombo}";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['ultimo_id'];
    }


    // Function to create a new combo and return its ID
    public function crearNuevoCombo() {
        $sql = "INSERT INTO tbl_combo (fecha_creacion) VALUES (NOW())"; // 'combos' table for general combo info
        $stmt = $this->conex->prepare($sql);
        if($stmt->execute()) {
            return $this->conex->lastInsertId();
        }
        return false;
    }

    // Function to insert a product into a specific combo
    public function insertarProductoEnCombo($id_combo, $id_producto, $cantidad) {
        $sql = "INSERT INTO {$this->tablaCombo} (id_combo, id_producto, cantidad) VALUES (:id_combo, :id_producto, :cantidad)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }
}
?>