<?php
require_once 'Config/config.php';

class rango extends BD {
    private $id_rango;
    private $nombre_rango;
    private $conex;

    public function __construct() {
        $conexion = new BD('S');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function getIdRango() { 
        return $this->id_rango; 
    }
    public function setIdRango($id_rango) { 
        $this->id = $id_rango; 
    }

    public function getNombreRango() { 
        return $this->nombre_rango; 
    }
    public function setNombreRango($nombre_rango) { 
        $this->nombre_rango = $nombre_rango; 
    } 

    // Registrar Rango
    public function registrarRango() {
        return $this->r_Rango(); 
    }
    private function r_Rango() {
        $sql = "INSERT INTO tbl_rango (nombre_rango) VALUES (:nombre_rango)";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_rango', $this->nombre_rango);

        return $stmt->execute();
    }

    // Obtener Rango por ID
    public function obtenerRangoPorId($id_rango) {
        return $this->rangoporid($id_rango); 
    }
    private function rangoporid($id_rango) {
        $sql = "SELECT id_rango, nombre_rango FROM tbl_rango WHERE id_rango = :id_rango";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rango', $id_rango);
        $stmt->execute();
        $rango_obt = $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro

        return $rango_obt;
    }

    // Consultar Rangos
    public function consultarRangos() {
        return $this->c_rangos(); 
    }
    private function c_rangos() {
        $sql = "SELECT id_rango, nombre_rango FROM tbl_rango";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $rangos_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rangos_obt;
    }

    // Modificar Rango
    public function modificarRango($id_rango) {
        return $this->m_rango($id_rango); 
    }
    private function m_rango($id_rango) {
        $sql = "UPDATE tbl_rango SET nombre_rango = :nombre_rango WHERE id_rango = :id_rango";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rango', $id_rango);
        $stmt->bindParam(':nombre_rango', $this->nombre_rango);

        return $stmt->execute();
    }

    // Eliminar Rango
    public function eliminarRango($id_rango) {
        return $this->e_rango($id_rango); 
    }
    private function e_rango($id_rango) {
        $sql = "DELETE FROM tbl_rango WHERE id_rango = :id_rango";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rango', $id_rango);
        
        return $stmt->execute();
    }
}
?>