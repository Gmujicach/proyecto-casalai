<?php
require_once 'Config/config.php';

class Finanza extends BD {
    private $id_finanzas;
    private $tipo; // 'ingreso' o 'egreso'
    private $monto;
    private $descripcion;
    private $fecha;
    private $estado;
    private $id_despacho;
    private $id_recepcion;

    private $conex;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }
public function getConexion() {
    return $this->conex;
}

    // Getters y setters
    public function getIdFinanzas() { 
        return $this->id_finanzas; 
    }
    public function setIdFinanzas($id_finanzas) {
        $this->id_finanzas = $id_finanzas; 
    }

    public function getTipo() { 
        return $this->tipo; 
    }
    public function setTipo($tipo) { 
        $this->tipo = $tipo; 
    }

    public function getMonto() { 
        return $this->monto; 
    }
    public function setMonto($monto) { 
        $this->monto = $monto; 
    }

    public function getDescripcion() { 
        return $this->descripcion; 
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion; 
    }

    public function getFecha() { 
        return $this->fecha; 
    }
    public function setFecha($fecha) { 
        $this->fecha = $fecha; 
    }

    public function getEstado() { 
        return $this->estado; 
    }
    public function setEstado($estado) { 
        $this->estado = $estado; 
    }

    public function getIdDespacho() { 
        return $this->id_despacho; 
    }
    public function setIdDespacho($id) { 
        $this->id_despacho = $id; 
    }

    public function getIdRecepcion() { 
        return $this->id_recepcion; 
    }
    public function setIdRecepcion($id) { 
        $this->id_recepcion = $id; 
    }

    // REGISTRAR INGRESO (automático)
    public function registrarIngreso($id_despacho) {
        return $this->r_ingreso($id_despacho); 
    }


    private function r_ingreso($id_despacho) {

        // Obtener factura y productos
        $sql = "SELECT f.id_factura FROM tbl_despachos d
                JOIN tbl_facturas f ON d.id_factura = f.id_factura
                WHERE d.id_despachos = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->execute([$id_despacho]);
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$factura) return false;

        $sql = "SELECT p.nombre_producto, fd.cantidad, p.precio
                FROM tbl_factura_detalle fd
                JOIN tbl_productos p ON fd.id_producto = p.id_producto
                WHERE fd.factura_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->execute([$factura['id_factura']]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $descripcion = "Venta: ";
        $monto_total = 0;
        foreach ($productos as $prod) {
            $descripcion .= "{$prod['nombre_producto']} (x{$prod['cantidad']}), ";
            $monto_total += $prod['precio'] * $prod['cantidad'];
        }
        $descripcion = rtrim($descripcion, ', ');

        $sql = "INSERT INTO tbl_ingresos_egresos (tipo, monto, descripcion, fecha, estado, id_despacho)
                VALUES ('ingreso', ?, ?, NOW(), 1, ?)";
        $stmt = $this->getConexion()->prepare($sql);
        return $stmt->execute([$monto_total, $descripcion, $id_despacho]);
    }

    // REGISTRAR EGRESO (automático)
    public function registrarEgreso($id_recepcion) {
        return $this->r_egreso($id_recepcion); 
    }
    private function r_egreso($id_recepcion) {
        $sql = "SELECT p.nombre_producto, drp.cantidad, drp.costo
                FROM tbl_detalle_recepcion_productos drp
                JOIN tbl_productos p ON drp.id_producto = p.id_producto
                WHERE drp.id_recepcion = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->execute([$id_recepcion]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $descripcion = "Compra: ";
        $monto_total = 0;
        foreach ($productos as $prod) {
            $descripcion .= "{$prod['nombre_producto']} (x{$prod['cantidad']}), ";
            $monto_total += $prod['costo'] * $prod['cantidad'];
        }
        $descripcion = rtrim($descripcion, ', ');

        $sql = "INSERT INTO tbl_ingresos_egresos (tipo, monto, descripcion, fecha, estado, id_recepcion)
                VALUES ('egreso', ?, ?, NOW(), 1, ?)";
        $stmt = $this->getConexion()->prepare($sql);
        return $stmt->execute([$monto_total, $descripcion, $id_recepcion]);
    }

    // CONSULTAR INGRESOS
    public function consultarIngresos() {
        return $this->c_ingresos(); 
    }
    private function c_ingresos() {
        $sql = "SELECT * FROM tbl_ingresos_egresos WHERE tipo='ingreso' ORDER BY fecha DESC";
        return $this->getConexion()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // CONSULTAR EGRESOS
    public function consultarEgresos() {
        return $this->c_egresos(); 
    }
    private function c_egresos() {
        $sql = "SELECT * FROM tbl_ingresos_egresos WHERE tipo='egreso' ORDER BY fecha DESC";
        return $this->getConexion()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // ANULAR
    public function anularRegistro($id_finanzas) {
        return $this->anular_r($id_finanzas); 
    }
    private function anular_r($id_finanzas) {
        $sql = "UPDATE tbl_ingresos_egresos SET estado=0 WHERE id_finanzas=?";
        $stmt = $this->getConexion()->prepare($sql);
        return $stmt->execute([$id_finanzas]);
    }
}