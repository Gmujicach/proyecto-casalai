<?php
require_once 'Config/config.php';

class Cuentabanco extends BD {
    private $id_cuenta;
    private $nombre_banco;
    private $numero_cuenta;
    private $rif_cuenta;
    private $telefono_cuenta;
    private $correo_cuenta;
    private $estado;
    private $conex;

    public function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Getters y Setters
    public function getIdCuenta() { 
        return $this->id_cuenta; 
    }
    public function setIdCuenta($id_cuenta) { 
        $this->id_cuenta = $id_cuenta; 
    }

    public function getNombreBanco() { 
        return $this->nombre_banco; 
    }
    public function setNombreBanco($nombre_banco) { 
        $this->nombre_banco = $nombre_banco; 
    }

    public function getNumeroCuenta() { 
        return $this->numero_cuenta; 
    }
    public function setNumeroCuenta($numero_cuenta) { 
        $this->numero_cuenta = $numero_cuenta; 
    }

    public function getRifCuenta() { 
        return $this->rif_cuenta; 
    }
    public function setRifCuenta($rif_cuenta) { 
        $this->rif_cuenta = $rif_cuenta; 
    }

    public function getTelefonoCuenta() { 
        return $this->telefono_cuenta; 
    }
    public function setTelefonoCuenta($telefono_cuenta) { 
        $this->telefono_cuenta = $telefono_cuenta; 
    }

    public function getCorreoCuenta() { 
        return $this->correo_cuenta; 
    }
    public function setCorreoCuenta($correo_cuenta) { 
        $this->correo_cuenta = $correo_cuenta; 
    } 

    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    // Registrar Cuenta
    public function registrarCuentabanco() {
        return $this->r_cuentabanco(); 
    }
    private function r_cuentabanco() {
        $sql = "INSERT INTO tbl_cuentas 
        (nombre_banco, numero_cuenta, rif_cuenta, telefono_cuenta, correo_cuenta)
        VALUES (:nombre_banco, :numero_cuenta, :rif_cuenta, :telefono_cuenta, :correo_cuenta)";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_banco', $this->nombre_banco);
        $stmt->bindParam(':numero_cuenta', $this->numero_cuenta);
        $stmt->bindParam(':rif_cuenta', $this->rif_cuenta);
        $stmt->bindParam(':telefono_cuenta', $this->telefono_cuenta);
        $stmt->bindParam(':correo_cuenta', $this->correo_cuenta);

        return $stmt->execute();
    }

    public function obtenerUltimaCuenta() {
        return $this->obtUltimaCuenta(); 
    }
    private function obtUltimaCuenta() {
        try {
            $sql = "SELECT * FROM tbl_cuentas ORDER BY id_cuenta DESC LIMIT 1";
            $stmt = $this->conexion()->prepare($sql);
            $stmt->execute();
            $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);
            return $cuenta ? $cuenta : null;
        } catch (PDOException $e) {
            error_log("Error al obtener la última cuenta: " . $e->getMessage());
            return null;
        }
    }
    
    // Obtener Cuenta por ID
    public function obtenerCuentaPorId($id_cuenta) {
        return $this->cuentaporid($id_cuenta); 
    }
    private function cuentaporid($id_cuenta) {
        $sql = "SELECT id_cuenta, nombre_banco, numero_cuenta, rif_cuenta, telefono_cuenta, correo_cuenta 
        FROM tbl_cuentas WHERE id_cuenta = :id_cuenta";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cuenta', $id_cuenta);
        $stmt->execute();
        $cuenta_obt = $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro

        return $cuenta_obt;
    }

    // Consultar Cuentas
    public function consultarCuentabanco() {
        return $this->c_cuentabanco(); 
    }
    private function c_cuentabanco() {
        $sql = "SELECT id_cuenta, nombre_banco, numero_cuenta, rif_cuenta, telefono_cuenta, correo_cuenta, estado 
        FROM tbl_cuentas";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $cuentas_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $cuentas_obt;
    }

    // Modificar Cuenta
    public function modificarCuentabanco($id_cuenta) {
        return $this->m_cuentabanco($id_cuenta); 
    }
    private function m_cuentabanco($id_cuenta) {
        $sql = "UPDATE tbl_cuentas SET nombre_banco = :nombre_banco, numero_cuenta = :numero_cuenta, 
        rif_cuenta = :rif_cuenta, telefono_cuenta = :telefono_cuenta, correo_cuenta = :correo_cuenta
        WHERE id_cuenta = :id_cuenta";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_banco', $this->nombre_banco);
        $stmt->bindParam(':numero_cuenta', $this->numero_cuenta);
        $stmt->bindParam(':rif_cuenta', $this->rif_cuenta);
        $stmt->bindParam(':telefono_cuenta', $this->telefono_cuenta);
        $stmt->bindParam(':correo_cuenta', $this->correo_cuenta);
        $stmt->bindParam(':id_cuenta', $id_cuenta);

        return $stmt->execute();
    }

    // Eliminar Cuenta
    public function eliminarCuentabanco($id_cuenta) {
        return $this->e_cuentabanco($id_cuenta); 
    }
    private function e_cuentabanco($id_cuenta) {
        $sql = "DELETE FROM tbl_cuentas WHERE id_cuenta = :id_cuenta";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cuenta', $id_cuenta);
        
        return $stmt->execute();
    }

    public function verificarEstado() {
        return $this->v_estadoCuenta(); 
    }
    private function v_estadoCuenta() {
        $sql = "SHOW COLUMNS FROM tbl_cuentas LIKE 'estado'";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $alterSql = "ALTER TABLE tbl_cuentas 
            ADD estado ENUM('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado'";
            $this->conex->exec($alterSql);
        }
    }

    // Habilitar e Inhabilitar Cuenta
    public function cambiarEstado($nuevoEstado) {
        return $this->estadoCuenta($nuevoEstado); 
    }
    private function estadoCuenta($nuevoEstado) {
        try {
            $sql = "UPDATE tbl_cuentas SET estado = :estado WHERE id_cuenta = :id_cuenta";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':estado', $nuevoEstado);
            $stmt->bindParam(':id_cuenta', $this->id_cuenta);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al cambiar estado: " . $e->getMessage());
            return false;
        }
    }
}
?>