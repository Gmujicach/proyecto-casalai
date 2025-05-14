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

    // Setters
    public function setDatos($data) {
        $this->id_detalles   = $data['id_detalles'] ?? null;
        $this->cuenta        = $data['cuenta'] ?? null;
        $this->factura       = $data['factura'] ?? null;
        $this->tipo          = $data['tipo'] ?? null;
        $this->observaciones = $data['observaciones'] ?? null;
        $this->referencia    = $data['referencia'] ?? null;
        $this->fecha         = $data['fecha'] ?? null;
        $this->estatus       = $data['estatus'] ?? 'Pendiente';
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
                (`id_factura`, `id_cuenta`, `observaciones`, `tipo`, `referencia`, `fecha`, `estatus`)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $this->factura,
                $this->cuenta,
                $this->observaciones,
                $this->tipo,
                $this->referencia,
                $this->fecha,
                $this->estatus
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
