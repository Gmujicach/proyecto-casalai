<?php
require_once 'Config/config.php';

class marca extends BD {
    private $tablemarcas = 'tbl_marcas';
    private $conex;
    private $nombre_marca;
    private $id_marca;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    public function getnombre_marca() {
        return $this->nombre_marca;
    }
    public function setnombre_marca($nombre_marca) {
        $this->nombre_marca = $nombre_marca;
    }
    
    public function getIdMarca() {
        return $this->id_marca;
    }
    public function setIdMarca($id_marca) {
        $this->id_marca = $id_marca;
    }

    public function existeNombreMarca($nombre_marca, $excluir_id = null) {
        return $this->existeNomMarca($nombre_marca, $excluir_id); 
    }
    private function existeNomMarca($nombre_marca, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_marcas WHERE nombre_marca = ?";
        $params = [$nombre_marca];
        if ($excluir_id !== null) {
            $sql .= " AND id_marca != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function registrarMarca() {
        return $this->r_marca();
    }
    private function r_marca() {
        $sql = "INSERT INTO tbl_marcas (nombre_marca)
                VALUES (:nombre_marca)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        
        return $stmt->execute();
    }

    public function obtenerUltimaMarca() {
        return $this->obtUltimaMarca(); 
    }
    private function obtUltimaMarca() {
        try {
            $sql = "SELECT * FROM tbl_marcas ORDER BY id_marca DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $marca = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $marca ? $marca : null;
        } catch (PDOException $e) {
            error_log("Error al obtener la última marca: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

    public function obtenermarcasPorId($id_marca) {
        return $this->obtmarcasPorId($id_marca);
    }
    private function obtmarcasPorId($id_marca) {
        $query = "SELECT * FROM tbl_marcas WHERE id_marca = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id_marca]);
        $marcas = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $marcas;
    }

    public function modificarmarcas($id_marca) {
        return $this->m_marcas($id_marca);
    }
    private function m_marcas($id_marca) {
        $sql = "UPDATE tbl_marcas SET nombre_marca = :nombre_marca WHERE id_marca = :id_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        
        return $stmt->execute();
    }

    public function eliminarmarcas($id_marca) {
        return $this->e_marcas($id_marca);
    }
    private function e_marcas($id_marca) {
        $sql = "DELETE FROM tbl_marcas WHERE id_marca = :id_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_marca', $id_marca);
        
        $result = $stmt->execute();
        //$this->conex = null;
        return $result;
    }

    public function getmarcas() {
        return $this->g_marcas();
    }
    private function g_marcas() {
        $querymarcas = 'SELECT id_marca, nombre_marca FROM ' . $this->tablemarcas;
        
        $stmtmarcas = $this->conex->prepare($querymarcas);
        $stmtmarcas->execute();
        $marcas = $stmtmarcas->fetchAll(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $marcas;
    }
}
?>