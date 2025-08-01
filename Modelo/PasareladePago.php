<?php
require_once 'config/config.php';
require_once 'factura.php';

class PasareladePago extends Factura {
    private $id_detalles;
    private $cuenta;
    private $factura;
    private $tipo;
    private $observaciones;    
    private $referencia;    
    private $fecha;
    private $estatus;
    private $comprobante;


public function __construct() {
    parent::__construct();
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
// Comprobante
public function getComprobante() {
    return $this->comprobante;
}
public function setComprobante($comprobante) {
    $this->comprobante = $comprobante;
}

public function validarCodigoReferencia() {
    $sql = "SELECT COUNT(*) FROM tbl_detalles_pago WHERE referencia = :referencia";
    $stmt = $this->getConexion()->prepare($sql);
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
            case 'Modificar':
                return $this->pagoModificar();
            case 'Procesar':
                return $this->pagoProcesar();
            default:
                throw new Exception("Transacción no válida.");
        }
    }

    
        private function pagoIngresar() {
    try {
        // Insertar detalles del pago
        $stmt = $this->getConexion()->prepare("INSERT INTO `tbl_detalles_pago`
            (`id_factura`, `id_cuenta`, `observaciones`, `tipo`, `referencia`, `fecha`, `comprobante`)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $this->factura,
            $this->cuenta,
            $this->observaciones,
            $this->tipo,
            $this->referencia,
            $this->fecha,
            $this->comprobante
        ]);

        // Actualizar estatus de la factura a 'Procesada'
        $updateStmt = $this->getConexion()->prepare("UPDATE `tbl_facturas` SET `estatus` = 'En Proceso' WHERE `id_factura` = ?");
        $updateStmt->execute([$this->factura]);

        return true;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
    }


    private function pagoConsultar() {
        $sql = "SELECT 
    dp.id_detalles,
    dp.id_factura,
    dp.id_cuenta,
    c.nombre_banco AS tbl_cuentas,
    dp.observaciones,
    dp.tipo,
    dp.referencia,
    dp.fecha,
    dp.comprobante,
    dp.estatus
FROM tbl_detalles_pago dp
INNER JOIN tbl_cuentas c ON dp.id_cuenta = c.id_cuenta;";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function pagoModificar() {
        $sql = "UPDATE `tbl_detalles_pago` 
                SET `id_factura` = :id_factura,
                    `id_cuenta` = :id_cuenta,
                    `tipo` = :tipo,
                    `referencia` = :referencia,
                    `fecha` = :fecha 
                WHERE id_detalles = :id_detalles";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bindParam(':id_detalles', $this->id_detalles);
        $stmt->bindParam(':id_factura', $this->factura);
        $stmt->bindParam(':id_cuenta', $this->cuenta);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':referencia', $this->referencia);
        $stmt->bindParam(':fecha', $this->fecha);
        return $stmt->execute();
    }

private function pagoProcesar() {
    $sql = "UPDATE `tbl_detalles_pago` 
            SET `estatus` = :estatus, `observaciones` = :observaciones
            WHERE id_detalles = :id_detalles";
    
    $stmt = $this->getConexion()->prepare($sql);
    $stmt->bindParam(':estatus', $this->estatus);
    $stmt->bindParam(':observaciones', $this->observaciones);
    $stmt->bindParam(':id_detalles', $this->id_detalles);
    
    $resultado = $stmt->execute();

    if ($resultado) {
        $this->facturaProcesar($this->factura, $this->estatus);
    }

    return $resultado;
}



        public function cambiarEstatus($nuevoEstatus) {
        try {
            $sql = "UPDATE tbl_detalles_pago SET estatus = :estatus WHERE id_detalles = :id";
            $stmt = $this->getConexion()->prepare($sql);
            $stmt->bindParam(':estatus', $nuevoEstatus);
            $stmt->bindParam(':id', $this->id_detalles);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
        public function obtenerPagoPorId($id) {
        $sql = "SELECT 
                    dp.id_detalles,
                    dp.id_factura,
                    dp.id_cuenta,
                    c.nombre_banco AS tbl_cuentas,
                    dp.observaciones,
                    dp.tipo,
                    dp.referencia,
                    dp.fecha,
                    dp.estatus
                FROM tbl_detalles_pago dp
                INNER JOIN tbl_cuentas c ON dp.id_cuenta = c.id_cuenta
                WHERE dp.id_detalles = :id";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

        private function pagoEliminar() {
        $sql = "DELETE FROM tbl_detalles_pago WHERE id_detalles = :id_detalles";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bindParam(':id_detalles', $this->id_detalles, PDO::PARAM_INT);
        return $stmt->execute();
    }


}
?>
