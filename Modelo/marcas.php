<?php
require_once 'Conexion.php';

class marca extends Conexion {
    private $tablemarcas = 'tbl_marcas';
    private $conex;
    private $descripcion_ma;
    private $id;

    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }

    // Getters y Setters
    public function getdescripcion_ma() {
        return $this->descripcion_ma;
    }

    public function setdescripcion_ma($descripcion_ma) {
        $this->descripcion_ma = $descripcion_ma;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validarmarca() {
        $sql = "SELECT COUNT(*) FROM marcas WHERE descripcion_ma = :descripcion_ma";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':descripcion_ma', $this->descripcion_ma);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarmarcas() {
        $sql = "INSERT INTO tbl_marcas (descripcion_ma)
                VALUES (:descripcion_ma)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':descripcion_ma', $this->descripcion_ma);
        
        return $stmt->execute();
    }

    // Obtener Producto por ID
    public function obtenermarcasPorId($id) {
        $query = "SELECT * FROM tbl_marcas WHERE id_marca = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $marcas = $stmt->fetch(PDO::FETCH_ASSOC);
        return $marcas;
    }

    // Modificar Producto
    public function modificarmarcas($id) {
        $sql = "UPDATE tbl_marcas SET descripcion_ma = :descripcion_ma WHERE id_marca = :id_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_marca', $id);
        $stmt->bindParam(':descripcion_ma', $this->descripcion_ma);
        
        return $stmt->execute();
    }

    // Eliminar Producto
    public function eliminarmarcas($id) {
        $sql = "DELETE FROM tbl_marcas WHERE id_marca = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getmarcas() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querymarcas = 'SELECT id_marca, descripcion_ma FROM ' . $this->tablemarcas;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtmarcas = $this->conex->prepare($querymarcas);
        $stmtmarcas->execute();
        $marcas = $stmtmarcas->fetchAll(PDO::FETCH_ASSOC);

        return $marcas;
    }
    
}

?>