<?php
require_once 'Config/Config.php';

class Proveedores extends BD {
    
    private $conex;
    private $id_proveedor;
    private $nombre;
    private $representante;
    private $rif1;
    private $rif2;
    private $telefono1;
    private $telefono2;
    private $direccion;
    private $correo;
    private $observacion;
    private $activo=1;
    private $tableproveedor= 'tbl_proveedores';

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getRepresentante() {
        return $this->representante;
    }

    public function setRepresentante($representante) {
        $this->representante = $representante;
    }

    public function getRif1() {
        return $this->rif1;
    }

    public function setRif1($rif1) {
        $this->rif1 = $rif1;
    }

    public function getRif2() {
        return $this->rif2;
    }

    public function setRif2($rif2) {
        $this->rif2 = $rif2;
    }

    public function getTelefono1() {
        return $this->telefono1;
    }

    public function setTelefono1($telefono1) {
        $this->telefono1 = $telefono1;
    }

    public function getTelefono2() {
        return $this->telefono2;
    }

    public function setTelefono2($telefono2) {
        $this->telefono2 = $telefono2;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getIdProveedor() {
        return $this->id_proveedor;
    }

    public function setIdProveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }

    public function existeNombreProveedor($nombre, $excluir_id = null) {
        return $this->existeNomProveedor($nombre, $excluir_id); 
    }
    private function existeNomProveedor($nombre, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_proveedores WHERE nombre_proveedor = ?";
        $params = [$nombre];
        if ($excluir_id !== null) {
            $sql .= " AND id_proveedor != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function registrarProveedor() {
        return $this->r_proveedor();
    }
    private function r_proveedor() {
        $sql = "INSERT INTO tbl_proveedores (`nombre_proveedor`, `rif_proveedor`, `nombre_representante`, `rif_representante`, `correo_proveedor`, `direccion_proveedor`, `telefono_1`, `telefono_2`, `observacion`)
                VALUES (:nombre, :rif1, :representante, :rif2, :correo, :direccion, :telefono1, :telefono2, :observacion)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':rif1', $this->rif1);
        $stmt->bindParam(':representante', $this->representante);
        $stmt->bindParam(':rif2', $this->rif2);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono1', $this->telefono1);
        $stmt->bindParam(':telefono2', $this->telefono2);
        $stmt->bindParam(':observacion', $this->observacion);

        return $stmt->execute();
    }

    public function obtenerUltimoProveedor() {
        return $this->obtUltimoProveedor(); 
    }
    private function obtUltimoProveedor() {
        try {
            $sql = "SELECT * FROM tbl_proveedores ORDER BY id_proveedor DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $proveedor ? $proveedor : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el último proveedor: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

public function obtenerReporteSuministroProveedores() {
    $sql = "SELECT p.nombre_proveedor, SUM(dp.cantidad) AS cantidad
            FROM tbl_proveedores p
            JOIN tbl_recepcion_productos r ON p.id_proveedor = r.id_proveedor
            JOIN tbl_detalle_recepcion_productos dp ON r.id_recepcion = dp.id_recepcion
            GROUP BY p.id_proveedor, p.nombre_proveedor
            ORDER BY cantidad DESC
            LIMIT 10";
    $stmt = $this->conex->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function obtenerProveedorPorId($id_proveedor) {
        return $this->obtProveedorPorId($id_proveedor);
    }
    private function obtProveedorPorId($id_proveedor) {
        $query = "SELECT * FROM tbl_proveedores WHERE id_proveedor = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id_proveedor]);
        $proveedores = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $proveedores;
    }

    public function modificarProveedor($id_proveedor) {
        return $this->m_proveedor($id_proveedor);
    }
    private function m_proveedor($id_proveedor) {
        $sql = "UPDATE tbl_proveedores SET nombre_proveedor = :nombre, rif_proveedor = :rif1, nombre_representante = :representante, rif_representante = :rif2, correo_proveedor = :correo, direccion_proveedor = :direccion, telefono_1 = :telefono1, telefono_2 = :telefono2, observacion = :observacion WHERE id_proveedor = :id_proveedor";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':rif1', $this->rif1);
        $stmt->bindParam(':representante', $this->representante);
        $stmt->bindParam(':rif2', $this->rif2);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono1', $this->telefono1);
        $stmt->bindParam(':telefono2', $this->telefono2);
        $stmt->bindParam(':observacion', $this->observacion);
        
        return $stmt->execute();
    }

    public function eliminarProveedor($id_proveedor) {
        return $this->e_proveedor($id_proveedor);
    }
    private function e_proveedor($id_proveedor) {
        $sql = "DELETE FROM tbl_proveedores WHERE id_proveedor = :id_proveedor";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor);
        
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function getproveedores() {
        return $this->g_proveedores();
    }
    private function g_proveedores() {
        $queryproveedores = 'SELECT * FROM ' . $this->tableproveedor;
        
        $stmtproveedores = $this->conex->prepare($queryproveedores);
        $stmtproveedores->execute();
        $proveedores = $stmtproveedores->fetchAll(PDO::FETCH_ASSOC);

        return $proveedores;
    }

    public function cambiarEstatus($nuevoEstatus) {
        return $this->cam_Estatus($nuevoEstatus); 
    }
    private function cam_Estatus($nuevoEstatus) {
        try {
            $sql = "UPDATE tbl_proveedores SET estado = :estatus WHERE id_proveedor = :id_proveedor";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':estatus', $nuevoEstatus);
            $stmt->bindParam(':id_proveedor', $this->id_proveedor);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al cambiar estatus: " . $e->getMessage());
            return false;
        }
    }
}

