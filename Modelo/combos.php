<?php
require_once 'Config/config.php';

class Combos extends BD {
    private $conex;
    //private $productos;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }
    
    //Metodos para los combos
    public function obtenerCombos() {
        $sql = "SELECT id_combo, id_producto, cantidad FROM tbl_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*public function obtenerComboPorId($id_combo) {
        $sql = "SELECT id_combo, id_producto, cantidad FROM tbl_combo WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }*/


    public function agregarCombo($id_producto, $cantidad) {
        $sql = "INSERT INTO tbl_combo (id_producto, cantidad) VALUES (:id_producto, :cantidad)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }

    public function eliminarCombo($id_combo) {
        $sql = "DELETE FROM tbl_combo WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        return $stmt->execute();
    }

    public function modificarCombo($id_combo, $id_producto, $cantidad) {
        $sql = "UPDATE tbl_combo SET id_producto = :id_producto, cantidad = :cantidad WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }


}




