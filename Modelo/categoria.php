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
        return $this->id_rol; 
    }
    public function setIdCategoria($id_rol) { 
        $this->id = $id_rol; 
    }

    public function getNombreCategoria() { 
        return $this->nombre_rol; 
    }
    public function setNombreCategoria($nombre_rol) { 
        $this->nombre_rol = $nombre_rol; 
    } 

    public function registrarRol() {
        return $this->r_Rol();
    }
    private function r_Rol() {
        $sql = "INSERT INTO tbl_rol (nombre_rol) VALUES (:nombre_rol)";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_rol', $this->nombre_rol);

        return $stmt->execute();
    }

    public function existeNombreRol($nombre_rol, $excluir_id = null) {
        return $this->existeNomRol($nombre_rol, $excluir_id); 
    }
    private function existeNomRol($nombre_rol, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_rol WHERE nombre_rol = ?";
        $params = [$nombre_rol];
        if ($excluir_id !== null) {
            $sql .= " AND id_rol != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimoRol() {
        return $this->obtUltimoRol(); 
    }
    private function obtUltimoRol() {
        try {
            $sql = "SELECT * FROM tbl_rol ORDER BY id_rol DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $rol = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $rol ? $rol : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el último rol: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

    public function obtenerRolPorId($id_rol) {
        return $this->rolporid($id_rol); 
    }
    private function rolporid($id_rol) {
        $sql = "SELECT id_rol, nombre_rol FROM tbl_rol WHERE id_rol = :id_rol";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute([$id_rol]);
        $roles = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $roles;
    }

    public function consultarRoles() {
        return $this->c_roles(); 
    }
    private function c_roles() {
        $sql = "SELECT id_rol, nombre_rol FROM tbl_rol";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $roles_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $roles_obt;
    }

    public function modificarRol($id_rol) {
        return $this->m_rol($id_rol); 
    }
    private function m_rol($id_rol) {
        $sql = "UPDATE tbl_rol SET nombre_rol = :nombre_rol WHERE id_rol = :id_rol";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->bindParam(':nombre_rol', $this->nombre_rol);

        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function eliminarRol($id_rol) {
        return $this->e_rol($id_rol); 
    }
    private function e_rol($id_rol) {
        $sql = "DELETE FROM tbl_rol WHERE id_rol = :id_rol";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol);
        
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }
}
?>