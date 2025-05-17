<?php
require_once 'config.php';

class PasareladePago extends BD {
    private $id_detalles;
    private $cuenta;
    private $factura;
    private $tipo;
    private $observaciones;    
    private $referencia;    
    private $fecha;
    private $estatus;

    function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Setters y Getters

    // ID Detalles
public function getIdDetalles() {
    return $this->id_detalles;
}

public function setIdDetalles($id_detalles) {
    $this->id_detalles = $id_detalles;
}

// Cuenta
public function getCuenta() {
    return $this->cuenta;
}

public function setCuenta($cuenta) {
    $this->cuenta = $cuenta;
}

// Factura
public function getFactura() {
    return $this->factura;
}

public function setFactura($factura) {
    $this->factura = $factura;
}

// Tipo
public function getTipo() {
    return $this->tipo;
}

public function setTipo($tipo) {
    $this->tipo = $tipo;
}

// Observaciones
public function getObservaciones() {
    return $this->observaciones;
}

public function setObservaciones($observaciones) {
    $this->observaciones = $observaciones;
}

// Referencia
public function getReferencia() {
    return $this->referencia;
}

public function setReferencia($referencia) {
    $this->referencia = $referencia;
}

// Fecha
public function getFecha() {
    return $this->fecha;
}

public function setFecha($fecha) {
    $this->fecha = $fecha;
}

// Estatus
public function getEstatus() {
    return $this->estatus;
}

public function setEstatus($estatus) {
    $this->estatus = $estatus;
}

public function validarCodigoReferencia() {
    $sql = "SELECT COUNT(*) FROM tbl_detalles_pago WHERE referencia = :referencia";
    $stmt = $this->conexion()->prepare($sql);
    $stmt->bindParam(':referencia', $this->referencia);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // Retorna true si no existe un producto con el mismo código interno
    return $count == 0;
}
    public function pasarelaTransaccion($transaccion) {
        switch ($transaccion) {
            case 'Ingresar':
                return $this->pagoIngresar();                 
            case 'Consultar':
                return $this->pagoConsultar();
            case 'Cancelar':
                return $this->pagoModificar();
            case 'Procesar':
                return $this->pagoProcesar();
            default:
                throw new Exception("Transacción no válida.");
        }
    }

    private function pagoIngresar() {
    
        try {


            $stmt = $this->conexion()->prepare("INSERT INTO `tbl_detalles_pago`
                (`id_factura`, `id_cuenta`, `observaciones`, `tipo`, `referencia`, `fecha`)
                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $this->factura,
                $this->cuenta,
                $this->observaciones,
                $this->tipo,
                $this->referencia,
                $this->fecha
            ]);

 
            return true;

        } catch (PDOException $e) {
        
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function pagoConsultar() {
        $sql = "SELECT `id_detalles`, `id_factura`, `id_cuenta`, `observaciones`, `tipo`, `referencia`, `fecha`, `estatus` FROM `tbl_detalles_pago`";
        $stmt = $this->conexion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function pagoModificar() {
        $sql = "UPDATE `tbl_detalles_pago` 
                SET `id_factura` = :id_factura,
                    `id_cuenta` = :id_cuenta,
                    `observaciones` = :observaciones,
                    `tipo` = :tipo,
                    `referencia` = :referencia,
                    `fecha` = :fecha 
                WHERE id_detalles = :id_detalles";
        $stmt = $this->conexion()->prepare($sql);
        $stmt->bindParam(':id_detalles', $this->id_detalles);
        $stmt->bindParam(':id_factura', $this->factura);
        $stmt->bindParam(':id_cuenta', $this->cuenta);
        $stmt->bindParam(':observaciones', $this->observaciones);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':referencia', $this->referencia);
        $stmt->bindParam(':fecha', $this->fecha);
        return $stmt->execute();
    }

    private function pagoProcesar() {
        $sql = "UPDATE `tbl_detalles_pago` 
                SET `estatus` = :estatus 
                WHERE id_detalles = :id_detalles";
        $stmt = $this->conexion()->prepare($sql);
        $stmt->bindParam(':estatus', $this->estatus);
        $stmt->bindParam(':id_detalles', $this->id_detalles);
        return $stmt->execute();
    }
}
?>
