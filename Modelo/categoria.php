<?php
require_once 'Config/config.php';

class Categoria extends BD {
    private $id_categoria;
    private $nombre_categoria;
    private $conex;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    public function getIdCategoria() { 
        return $this->id_categoria; 
    }
    public function setIdCategoria($id_categoria) { 
        $this->id_categoria = $id_categoria; 
    }

    public function getNombreCategoria() { 
        return $this->nombre_categoria; 
    }
    public function setNombreCategoria($nombre_categoria) { 
        $this->nombre_categoria = $nombre_categoria; 
    } 

    public function registrarCategoria() {
        return $this->r_Categoria();
    }
    private function r_Categoria() {
        $sql = "INSERT INTO tbl_categoria (nombre_categoria) VALUES (:nombre_categoria)";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_categoria', $this->nombre_categoria);

        return $stmt->execute();
    }

    public function existeNombreCategoria($nombre_categoria, $excluir_id = null) {
        return $this->existeNomCategoria($nombre_categoria, $excluir_id); 
    }
    private function existeNomCategoria($nombre_categoria, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_categoria WHERE nombre_categoria = ?";
        $params = [$nombre_categoria];
        if ($excluir_id !== null) {
            $sql .= " AND id_categoria != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimoCategoria() {
        return $this->obtUltimoCategoria(); 
    }
    private function obtUltimoCategoria() {
        try {
            $sql = "SELECT * FROM tbl_categoria ORDER BY id_categoria DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $categoria ? $categoria : null;
        } catch (PDOException $e) {
            error_log("Error al obtener la última categoria: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

    public function obtenerCategoriaPorId($id_categoria) {
        return $this->categoriaporid($id_categoria); 
    }
    private function categoriaporid($id_categoria) {
        $sql = "SELECT id_categoria, nombre_categoria FROM tbl_categoria WHERE id_categoria = :id_categoria";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute([$id_categoria]);
        $categorias = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $categorias;
    }

    public function consultarCategorias() {
        return $this->c_categorias(); 
    }
    private function c_categorias() {
        $sql = "SELECT id_categoria, nombre_categoria FROM tbl_categoria";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $categorias_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $categorias_obt;
    }

    public function modificarCategoria($id_categoria) {
        return $this->m_categoria($id_categoria); 
    }
    private function m_categoria($id_categoria) {
        $sql = "UPDATE tbl_categoria SET nombre_categoria = :nombre_categoria WHERE id_categoria = :id_categoria";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':nombre_categoria', $this->nombre_categoria);

        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function eliminarCategoria($id_categoria) {
        return $this->e_categoria($id_categoria); 
    }
    private function e_categoria($id_categoria) {
        $sql = "DELETE FROM tbl_categoria WHERE id_categoria = :id_categoria";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }
}
?>