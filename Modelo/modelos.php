<?php
require_once 'Config/config.php';

class modelo extends BD{
    private $id_marca;
    private $conex;
    private $nombre_modelo;
    private $id_modelo;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function getnombre_modelo() {
        return $this->nombre_modelo;
    }

    public function setnombre_modelo($nombre_modelo) {
        $this->nombre_modelo = $nombre_modelo;
    }

    public function getid_marca() {
        return $this->id_marca;
    }

    public function setid_marca($id_marca) {
        $this->id_marca = $id_marca;
    }

    
    public function getIdModelo() {
        return $this->id_modelo;
    }
    public function setIdModelo($id_modelo) {
        $this->id_modelo = $id_modelo;
    }

    public function existeNombreModelo($nombre_modelo, $excluir_id = null) {
        return $this->existeNomModelo($nombre_modelo, $excluir_id);
    }
    private function existeNomModelo($nombre_modelo, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_modelos WHERE nombre_modelo = ?";
        $params = [$nombre_modelo];
        if ($excluir_id !== null) {
            $sql .= " AND id_modelo != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function registrarModelo() {
        return $this->r_modelos();
    }
    private function r_modelos() {
        $sql = "INSERT INTO tbl_modelos (nombre_modelo, id_marca)
                VALUES (:nombre_modelo, :id_marca)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_modelo', $this->nombre_modelo);
        $stmt->bindParam(':id_marca', $this->id_marca);
        
        return $stmt->execute();
    }

    public function obtenerUltimoModelo() {
        return $this->obtUltimoModelo();
    }
    private function obtUltimoModelo() {
        $sql = "SELECT m.id_modelo, m.nombre_modelo, m.id_marca, ma.nombre_marca
            FROM tbl_modelos m
            JOIN tbl_marcas ma ON m.id_marca = ma.id_marca
            ORDER BY m.id_modelo DESC LIMIT 1";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $modelo = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $modelo ? $modelo : null;
    }

    public function obtenerModeloPorId($id_modelo) {
        return $this->obtModeloPorId($id_modelo);
    }
    private function obtModeloPorId($id_modelo) {
        $sql = "SELECT m.*, ma.nombre_marca 
                FROM tbl_modelos m
                JOIN tbl_marcas ma ON m.id_marca = ma.id_marca
                WHERE m.id_modelo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_modelo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*private function obtModeloPorId($id_modelo) {
        $sql = "SELECT * FROM tbl_modelos WHERE id_modelo = ?";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute([$id_modelo]);
        $modelo = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $modelo;
    }*/

    public function getmarcas() {
        return $this->g_marcas();
    }
    private function g_marcas() {
        $query = "SELECT id_marca, nombre_marca FROM tbl_marcas";
        $stmt = $this->conex->query($query);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errorInfo = $this->conex->errorInfo();
            echo "Debug: Error en el query: " . $errorInfo[2] . "\n";
            return [];
        }
    }

    // Modificar Modelo
    public function modificarModelo($id_modelo) {
        return $this->m_modelo($id_modelo);
    }
    private function m_modelo($id_modelo) {
        $sql = "UPDATE tbl_modelos SET nombre_modelo = :nombre_modelo WHERE id_modelo = :id_modelo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_modelo', $id_modelo);
        $stmt->bindParam(':id_marca', $this->id_marca);
        $stmt->bindParam(':nombre_modelo', $this->nombre_modelo);
        
        return $stmt->execute();
    }

    // Eliminar Modelo
    public function eliminarModelo($id_modelo) {
        return $this->e_modelo($id_modelo);
    }
    public function e_modelo($id_modelo) {
        $sql = "DELETE FROM tbl_modelos WHERE id_modelo = :id_modelo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_modelo', $id_modelo);
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function getModelos() {
        return $this->g_modelos();
    }
    public function g_modelos() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querymodelos = 'SELECT mo.id_modelo,
                                mo.id_marca,
                                mo.nombre_modelo,
                                ma.nombre_marca 
                                FROM tbl_modelos AS mo
                                INNER JOIN tbl_marcas AS ma ON mo.id_marca = ma.id_marca';
        
        
        
        $stmtmodelos = $this->conex->prepare($querymodelos);
        $stmtmodelos->execute();
        $modelos = $stmtmodelos->fetchAll(PDO::FETCH_ASSOC);

        return $modelos;
    }
    
}
?>