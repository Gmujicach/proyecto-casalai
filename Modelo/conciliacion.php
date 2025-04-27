<?php
require_once 'Conexion.php';

class Conciliacion extends Conexion {
    private $id_cuenta;
    private $nombre_banco;
    private $numero_cuenta;
    private $rif_cuenta;
    private $telefono_cuenta;
    private $correo_cuenta;
    private $estado;
    private $conex;

    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
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
    public function registrarConciliacion() {
        return $this->r_conciliacion(); 
    }
    private function r_conciliacion() {
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
        $cuenta = $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro

        return $cuenta;
    }

    // Consultar Cuentas
    public function consultarConciliacion() {
        return $this->c_conciliacion(); 
    }
    private function c_conciliacion() {
        $sql = "SELECT id_cuenta, nombre_banco, numero_cuenta, rif_cuenta, telefono_cuenta, correo_cuenta 
        FROM tbl_cuentas";

        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $cuentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $cuentas;
    }

    // Modificar Cuenta
    public function modificarConciliacion($id_cuenta) {
        return $this->m_conciliacion($id_cuenta); 
    }
    private function m_conciliacion($id_cuenta) {
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
    public function eliminarConciliacion($id_cuenta) {
        return $this->e_conciliacion($id_cuenta); 
    }
    private function e_conciliacion($id_cuenta) {
        $sql = "DELETE FROM tbl_cuentas WHERE id_cuenta = :id_cuenta";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cuenta', $id_cuenta);
        
        return $stmt->execute();
    }

    // Habilitar o Deshabilitar Cuenta
    public function estadoCuenta($id_cuenta) {
        return $this->etd_cuenta($id_cuenta); 
    }
    private function etd_cuenta($id_cuenta) {
        $sql = "SELECT estado FROM tbl_cuentas WHERE id_cuenta = :id_cuenta";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cuenta', $id_cuenta);
        
        $stmt->execute();

        $estado_actual = $stmt->fetchColumn();
        $nuevo_estado = $estado_actual ? 0 : 1; // Invertimos el estado

        $sql_update = "UPDATE tbl_cuentas SET estado = :nuevo_estado WHERE id_cuenta = :id_cuenta";
        
        $stmt_update = $this->conex->prepare($sql_update);
        $stmt_update->bindParam(':nuevo_estado', $nuevo_estado);
        $stmt_update->bindParam(':id_cuenta', $id_cuenta);
        
        return $stmt_update->execute();
    }
}
?>