<?php
require_once 'Config/config.php';

class marca extends BD {
    private $tablemarcas = 'tbl_marcas';
    private $conex;
    private $nombre_marca;
    private $id;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function getnombre_marca() {
        return $this->nombre_marca;
    }
    public function setnombre_marca($nombre_marca) {
        $this->nombre_marca = $nombre_marca;
    }
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // Verificar si existe el número de cuenta
    public function existeNumeroMarca($nombre_marca, $excluir_id = null) {
        return $this->existeNumMarca($nombre_marca, $excluir_id); 
    }
    private function existeNumMarca($nombre_marca, $excluir_id) {
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

    // Ingresar Marca
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
            error_log("Error al obtener la última cuenta: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

    // Obtener Producto por ID
    public function obtenermarcasPorId($id) {
        return $this->obtmarcasPorId($id);
    }
    private function obtmarcasPorId($id) {
        $query = "SELECT * FROM tbl_marcas WHERE id_marca = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $marcas = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $marcas;
    }

    // Modificar Producto
    public function modificarmarcas($id) {
        return $this->m_marcas($id);
    }
    private function m_marcas($id) {
        $sql = "UPDATE tbl_marcas SET nombre_marca = :nombre_marca WHERE id_marca = :id_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_marca', $id);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    // Eliminar Producto
    public function eliminarmarcas($id) {
        return $this->e_marcas($id);
    }
    private function e_marcas($id) {
        $sql = "DELETE FROM tbl_marcas WHERE id_marca = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function getmarcas() {
        return $this->g_marcas();
    }
    private function g_marcas() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querymarcas = 'SELECT id_marca, nombre_marca FROM ' . $this->tablemarcas;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtmarcas = $this->conex->prepare($querymarcas);
        $stmtmarcas->execute();
        $marcas = $stmtmarcas->fetchAll(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $marcas;
    }
    
}

?>