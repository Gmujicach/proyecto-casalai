<?php
require_once 'config/config.php';

class Rol extends BD {
    private $id_rol;
    private $nombre_rol;
    private $conex;

    public function __construct() {
        $conexion = new BD('S');
        $this->conex = $conexion->getConexion();
    }

    public function getIdRol() { 
        return $this->id_rol; 
    }
    public function setIdRol($id_rol) { 
        $this->id_rol = $id_rol; 
    }

    public function getNombreRol() { 
        return $this->nombre_rol; 
    }
    public function setNombreRol($nombre_rol) { 
        $this->nombre_rol = $nombre_rol; 
    } 

    public function registrarRol() {
        return $this->r_Rol();
    }
private function r_Rol() {
    try {
        // 1. Insertar el nuevo rol
        $sql = "INSERT INTO tbl_rol (nombre_rol) VALUES (:nombre_rol)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_rol', $this->nombre_rol);
        $stmt->execute();

        // 2. Obtener el ID del nuevo rol
        $id_rol = $this->conex->lastInsertId();

        // 3. Obtener todos los módulos
        $sqlModulos = "SELECT id_modulo FROM tbl_modulos";
        $stmtMod = $this->conex->prepare($sqlModulos);
        $stmtMod->execute();
        $modulos = $stmtMod->fetchAll(PDO::FETCH_COLUMN);

        // 4. Acciones disponibles
        $acciones = ['Ingresar', 'Incluir', 'Consultar', 'Modificar', 'Eliminar', 'Reportar'];

        // 5. Insertar permisos como "No Permitido"
        $sqlPermiso = "INSERT INTO tbl_permisos (id, accion, id_rol, id_modulo, estatus) 
                       VALUES (:id, :accion, :id_rol, :id_modulo, 'No Permitido')";
        $stmtPermiso = $this->conex->prepare($sqlPermiso);

        foreach ($modulos as $id_modulo) {
            foreach ($acciones as $accion) {
                $stmtPermiso->execute([
                    ':id' => $id++,
                    ':accion' => $accion,
                    ':id_rol' => $id_rol,
                    ':id_modulo' => $id_modulo
                ]);
            }
        }

        return true;

    } catch (PDOException $e) {
        echo "Error al registrar el rol y asignar permisos: " . $e->getMessage();
        return false;
    }
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
            $this->conex = null;
            return null;
        }
    }

    public function obtenerRolPorId($id_rol) {
        return $this->rolporid($id_rol); 
    }
    private function rolporid($id_rol) {
        $query = "SELECT * FROM tbl_rol WHERE id_rol = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id_rol]);
        $rol_obt = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $rol_obt;
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

        return $stmt->execute();
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