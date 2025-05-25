<?php
require_once 'Config/config.php';

class marca extends BD {
    private $tablemarcas = 'tbl_marcas';
    private $conex;
    private $nombre_marca;
    private $id;

    function __construct() {
        parent::__construct();
        $this->conex = parent::getConexion();
    }

    // Getters y Setters
    public function getnombre_marca() {
        return $this->nombre_marca;
    }

    public function setnombre_marca($nombre_marca) {
        $this->nombre_marca = $nombre_marca;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validarmarca() {
        $sql = "SELECT COUNT(*) FROM tbl_marcas WHERE nombre_marca = :nombre_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarmarcas() {
        $sql = "INSERT INTO tbl_marcas (nombre_marca)
                VALUES (:nombre_marca)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        
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
        $sql = "UPDATE tbl_marcas SET nombre_marca = :nombre_marca WHERE id_marca = :id_marca";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_marca', $id);
        $stmt->bindParam(':nombre_marca', $this->nombre_marca);
        
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
        $querymarcas = 'SELECT id_marca, nombre_marca FROM ' . $this->tablemarcas;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtmarcas = $this->conex->prepare($querymarcas);
        $stmtmarcas->execute();
        $marcas = $stmtmarcas->fetchAll(PDO::FETCH_ASSOC);

        return $marcas;
    }
    
}

?>