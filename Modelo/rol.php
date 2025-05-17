<?php
require_once 'config.php';

class rol extends BD {
    private $id_rol;
    private $nombre_rol;
    private $conex;

    function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Getters y Setters
    public function getIdRol() { 
        return $this->id_rol; 
    }
    public function setIdRol($id_rol) { 
        $this->id = $id_rol; 
    }

    public function getNombreRol() { 
        return $this->nombre_rol; 
    }
    public function setNombreRol($nombre_rol) { 
        $this->nombre_rol = $nombre_rol; 
    } 

    // Registrar Rol
    public function registrarRol() {
        return $this->r_Rol(); 
    }
    private function r_Rol() {
        $sql = "INSERT INTO tbl_roles (nombre_rol) VALUES (:nombre_rol)";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_rol', $this->nombre_rol);

        return $stmt->execute();
    }

    // Obtener Rol por ID
    public function obtenerRolPorId($id_rol) {
        return $this->rolporid($id_rol); 
    }
    private function rolporid($id_rol) {
        $sql = "SELECT id_rol, nombre_rol FROM tbl_roles WHERE id_rol = :id_rol";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->execute();
        $rol_obt = $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro

        return $rol_obt;
    }

    // Consultar Roles
    public function consultarRoles() {
        return $this->c_roles(); 
    }
    private function c_roles() {
        $sql = "SELECT id_rol, nombre_rol FROM tbl_roles";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $roles_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $roles_obt;
    }

    // Modificar Rol
    public function modificarRol($id_rol) {
        return $this->m_rol($id_rol); 
    }
    private function m_rol($id_rol) {
        $sql = "UPDATE tbl_roles SET nombre_rol = :nombre_rol WHERE id_rol = :id_rol";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->bindParam(':nombre_rol', $this->nombre_rol);

        return $stmt->execute();
    }

    // Eliminar Rol
    public function eliminarRol($id_rol) {
        return $this->e_rol($id_rol); 
    }
    private function e_rol($id_rol) {
        $sql = "DELETE FROM tbl_roles WHERE id_rol = :id_rol";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_rol', $id_rol);
        
        return $stmt->execute();
    }
}
?>