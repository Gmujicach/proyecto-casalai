<?php
require_once 'config/config.php';

class Cuentabanco extends BD {
    private $id_cuenta;
    private $nombre_banco;
    private $numero_cuenta;
    private $rif_cuenta;
    private $telefono_cuenta;
    private $correo_cuenta;
    private $metodos_pago;
    private $estado;
    private $db;

    public function __construct() {
        $conexion = new BD('P');
        $this->db = $conexion->getConexion();
    }

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
    public function getMetodosPago() {
        return $this->metodos_pago;
    }
 public function setMetodosPago($metodos_pago) {
    if (is_array($metodos_pago)) {
        $this->metodos_pago = implode(',', $metodos_pago);
    } else {
        $this->metodos_pago = $metodos_pago;
    }
}
     

    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function registrarCuentabanco() {
        return $this->r_cuentabanco(); 
    }
    private function r_cuentabanco() {
        $sql = "INSERT INTO tbl_cuentas 
        (nombre_banco, numero_cuenta, rif_cuenta, telefono_cuenta, correo_cuenta, metodos)
        VALUES (:nombre_banco, :numero_cuenta, :rif_cuenta, :telefono_cuenta, :correo_cuenta, :metodos)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre_banco', $this->nombre_banco);
        $stmt->bindParam(':numero_cuenta', $this->numero_cuenta);
        $stmt->bindParam(':rif_cuenta', $this->rif_cuenta);
        $stmt->bindParam(':telefono_cuenta', $this->telefono_cuenta);
        $stmt->bindParam(':correo_cuenta', $this->correo_cuenta);
        $stmt->bindParam(':metodos', $this->metodos_pago);
        return $stmt->execute();
    }

    public function existeNumeroCuenta($numero_cuenta, $excluir_id = null) {
        return $this->existeNumCuenta($numero_cuenta, $excluir_id); 
    }
    private function existeNumCuenta($numero_cuenta, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_cuentas WHERE numero_cuenta = ?";
        $params = [$numero_cuenta];
        if ($excluir_id !== null) {
            $sql .= " AND id_cuenta != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimaCuenta() {
        return $this->obtUltimaCuenta(); 
    }
    private function obtUltimaCuenta() {
        try {
            $sql = "SELECT * FROM tbl_cuentas ORDER BY id_cuenta DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->db = null;
            return $cuenta ? $cuenta : null;
        } catch (PDOException $e) {
            $this->db = null;
            return null;
        }
    }
    
    public function obtenerCuentaPorId($id_cuenta) {
        return $this->cuentaporid($id_cuenta); 
    }
    private function cuentaporid($id_cuenta) {
        $query = "SELECT * FROM tbl_cuentas WHERE id_cuenta = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_cuenta]);
        $cuenta_obt = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db = null;
        return $cuenta_obt;
    }

    public function consultarCuentabanco() {
        return $this->c_cuentabanco(); 
    }
    private function c_cuentabanco() {
        $sql = "SELECT * FROM tbl_cuentas";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $cuentas_obt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db = null;
        return $cuentas_obt;
    }

    public function modificarCuentabanco($id_cuenta) {
        return $this->m_cuentabanco($id_cuenta); 
    }
    private function m_cuentabanco($id_cuenta) {
        $sql = "UPDATE tbl_cuentas SET nombre_banco = :nombre_banco, numero_cuenta = :numero_cuenta, 
        rif_cuenta = :rif_cuenta, telefono_cuenta = :telefono_cuenta, correo_cuenta = :correo_cuenta, 
        metodos = :metodos
        WHERE id_cuenta = :id_cuenta";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cuenta', $id_cuenta);
        $stmt->bindParam(':nombre_banco', $this->nombre_banco);
        $stmt->bindParam(':numero_cuenta', $this->numero_cuenta);
        $stmt->bindParam(':rif_cuenta', $this->rif_cuenta);
        $stmt->bindParam(':telefono_cuenta', $this->telefono_cuenta);
        $stmt->bindParam(':correo_cuenta', $this->correo_cuenta);
        $stmt->bindParam(':metodos', $this->metodos_pago);
        return $stmt->execute();
    }

    public function eliminarCuentabanco($id_cuenta) {
        return $this->e_cuentabanco($id_cuenta); 
    }
    private function e_cuentabanco($id_cuenta) {
        try {
            $sql = "DELETE FROM tbl_cuentas WHERE id_cuenta = :id_cuenta";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cuenta', $id_cuenta, PDO::PARAM_INT);
            
            $result = $stmt->execute();

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Cuenta bancaria eliminada exitosamente.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se pudo eliminar la cuenta bancaria.'
                ];
            }

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return [
                    'success' => false,
                    'message' => 'No se puede eliminar la cuenta bancaria porque tiene registros asociados.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error inesperado: ' . $e->getMessage()
                ];
            }
        }
    }

    public function verificarEstado() {
        return $this->v_estadoCuenta(); 
    }
    private function v_estadoCuenta() {
        $sql = "SHOW COLUMNS FROM tbl_cuentas LIKE 'estado'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $alterSql = "ALTER TABLE tbl_cuentas 
            ADD estado ENUM('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado'";
            $this->db->exec($alterSql);
        }
        $this->db = null;
    }

    public function cambiarEstado($nuevoEstado) {
        return $this->estadoCuenta($nuevoEstado); 
    }
    private function estadoCuenta($nuevoEstado) {
        try {
            $sql = "UPDATE tbl_cuentas SET estado = :estado WHERE id_cuenta = :id_cuenta";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $nuevoEstado);
            $stmt->bindParam(':id_cuenta', $this->id_cuenta);
            $result = $stmt->execute();
            $this->db = null;
            return $result;
        } catch (PDOException $e) {
           $this->db = null;
            return false;
        }
    }
}
?>