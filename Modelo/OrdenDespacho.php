<?php
require_once 'config/config.php';

class OrdenDespacho extends BD {
    
    private $conex;
    private $id;
    private $correlativo;
    private $fecha;
    private $activo = 1;
    private $factura;
    private $tableordendespacho = 'tbl_orden_despachos';



    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function getCorrelativo() {
        return $this->correlativo;
    }

    public function setCorrelativo($correlativo) {
        $this->correlativo = $correlativo;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function getFactura() {
        return $this->factura;
    }
    public function setFactura($factura) {
        $this->factura = $factura;
    }
    
    public function setRango($rango) {
        $this->rango = $rango;
    }

        public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    
    
    // Método para obtener las facturas disponibles

    public function obtenerFacturasDisponibles() {
    $sql = "SELECT f.id_factura, f.fecha, c.nombre
FROM tbl_facturas f
INNER JOIN tbl_clientes c ON f.cliente = c.id_clientes
WHERE f.estatus = 'Borrador';
";
    $stmt = $this->conex->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Método para validar si el correlativo ya existe

     public function validarCorrelativo() {
        $sql = "SELECT COUNT(*) FROM tbl_orden_despachos WHERE correlativo = :correlativo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':correlativo', $this->correlativo);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    // Método para ingresar una nueva orden de despacho
    public function ingresarOrdenDespacho() {
    $sql = "INSERT INTO tbl_orden_despachos (fecha_despacho, id_factura, correlativo, activo)
            VALUES (:fecha, :factura, :correlativo, :activo)";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':fecha', $this->fecha);
    $stmt->bindParam(':factura', $this->factura);
    $stmt->bindParam(':correlativo', $this->correlativo);
    $stmt->bindParam(':activo', $this->activo, PDO::PARAM_INT);
    
    return $stmt->execute();
}

    // Método para obtener una orden de despacho por su ID
    public function obtenerOrdenPorId($id) {
        $query = "SELECT * FROM tbl_orden_despachos WHERE id_orden_despachos = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $ordendespacho = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ordendespacho;
    }

    // Método para modificar una orden de despacho
    public function modificarOrdenDespacho($id) {
        $sql = "UPDATE tbl_orden_despachos SET fecha_despacho = :fecha, correlativo=:correlativo, id_factura=:factura  WHERE id_orden_despachos = :id_despacho";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_despacho', $id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':correlativo', $this->correlativo);
        $stmt->bindParam(':factura', $this->factura);
        
        return $stmt->execute();
    }

    // Método para eliminar una orden de despacho
    public function eliminarOrdenDespacho($id) {
        $sql = "DELETE FROM tbl_orden_despachos WHERE id_orden_despachos = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
    public function cambiarEstatus($nuevoEstatus) {
        try {
            $sql = "UPDATE tbl_usuarios SET estatus = :estatus WHERE id_usuario = :id";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':estatus', $nuevoEstatus);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
           return false;
        }
    }

    


    public function getordendespacho() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $queryordendespacho = 'SELECT * FROM ' . $this->tableordendespacho;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtordendespacho = $this->conex->prepare($queryordendespacho);
        $stmtordendespacho->execute();
        $ordendespacho = $stmtordendespacho->fetchAll(PDO::FETCH_ASSOC);

        return $ordendespacho;
    }
}