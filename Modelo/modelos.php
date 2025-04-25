<?php
require_once 'Conexion.php';

class modelo extends Conexion{
    private $id_marca;
    private $conex;
    private $descripcion_mo;
    private $id;

    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }

    // Getters y Setters
    public function getdescripcion_mo() {
        return $this->descripcion_mo;
    }

    public function setdescripcion_mo($descripcion_mo) {
        $this->descripcion_mo = $descripcion_mo;
    }

    public function getid_marca() {
        return $this->id_marca;
    }

    public function setid_marca($id_marca) {
        $this->id_marca = $id_marca;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validarmodelo() {
        $sql = "SELECT COUNT(*) FROM tbl_modelos WHERE descripcion_mo = :descripcion_mo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':descripcion_mo', $this->descripcion_mo);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarmodelos() {
        $sql = "INSERT INTO tbl_modelos (descripcion_mo, id_marca)
                VALUES (:descripcion_mo, :id_marca)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':descripcion_mo', $this->descripcion_mo);
        $stmt->bindParam(':id_marca', $this->id_marca);
        
        return $stmt->execute();
    }

    // Obtener Producto por ID
    public function obtenermodelosPorId($id) {
        $query = "SELECT * FROM tbl_modelos WHERE id_modelo = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $modelos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $modelos;
    }

    public function getmarcas() {
        $query = "SELECT id_marca, descripcion_ma FROM tbl_marcas";
        $stmt = $this->conex->query($query);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errorInfo = $this->conex->errorInfo();
            echo "Debug: Error en el query: " . $errorInfo[2] . "\n";
            return [];
        }
    }

    // Modificar Producto
    public function modificarmodelos($id) {
        $sql = "UPDATE tbl_modelos SET descripcion_mo = :descripcion_mo WHERE id_modelo = :id_modelo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_modelo', $id);
        $stmt->bindParam(':descripcion_mo', $this->descripcion_mo);
        
        return $stmt->execute();
    }

    // Eliminar Producto
    public function eliminarmodelos($id) {
        $sql = "DELETE FROM tbl_modelos WHERE id_modelo = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getmodelos() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querymodelos = 'SELECT mo.id_modelo,
                                mo.descripcion_mo,
                                ma.descripcion_ma 
                                FROM tbl_modelos AS mo
                                INNER JOIN tbl_marcas AS ma ON mo.id_marca = ma.id_marca';
        
        
        
        $stmtmodelos = $this->conex->prepare($querymodelos);
        $stmtmodelos->execute();
        $modelos = $stmtmodelos->fetchAll(PDO::FETCH_ASSOC);

        return $modelos;
    }
    
}

?>