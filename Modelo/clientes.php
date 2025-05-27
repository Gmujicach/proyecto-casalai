<?php
require_once 'Config/config.php';

class cliente extends BD {
    private $tableclientes = 'tbl_clientes';
    private $conex;
    private $nombre;
    private $direccion;
    private $telefono;
    private $cedula;
    private $correo;
    private $activo = 1;
    private $id;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getnombre() {
        return $this->nombre;
    }

    public function setdireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getdireccion() {
        return $this->direccion;
    }

    public function settelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function gettelefono() {
        return $this->telefono;
    }


    public function setcedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getcedula() {
        return $this->cedula;
    }

    public function setcorreo($correo) {
        $this->correo = $correo;
    }

    public function getcorreo() {
        return $this->correo;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validaCedulaCliente() {
        $sql = "SELECT COUNT(*) FROM tbl_clientes WHERE cedula = :cedula";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':cedula', $this->cedula);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarclientes() {
        $sql = "INSERT INTO tbl_clientes (`nombre`, `cedula`, `direccion`, `telefono`, `correo`, `activo`)
                VALUES (:nombre, :cedula, :direccion, :telefono, :correo, 1)";
        $stmt = $this->conex->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':cedula', $this->cedula);
        $stmt->bindParam(':correo', $this->correo);
        
        return $stmt->execute();
    }

    // Obtener Producto por ID
    public function obtenerclientesPorId($id) {
        $query = "SELECT * FROM tbl_clientes WHERE id_clientes = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $clientes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $clientes;
    }

    // Modificar Producto
    public function modificarclientes($id) {
    $sql = "UPDATE tbl_clientes SET nombre = :nombre, cedula = :cedula, direccion = :direccion, telefono = :telefono, correo = :correo, activo = :activo WHERE id_clientes = :id_clientes";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_clientes', $id);
    $stmt->bindParam(':nombre', $this->nombre);
    $stmt->bindParam(':direccion', $this->direccion);
    $stmt->bindParam(':telefono', $this->telefono);
    $stmt->bindParam(':cedula', $this->cedula);
    $stmt->bindParam(':correo', $this->correo);
    $stmt->bindParam(':activo', $this->activo);
    
    return $stmt->execute();
}

    function eliminar_l($id) {
        $sql = "UPDATE tbl_clientes SET activo = 0 WHERE id = :id_clientes";
        $conexion = $this->conex->prepare($sql);
        $conexion->bindParam(':id_clientes', $id);
        return $conexion->execute();
    }


    // Eliminar cliente
    public function eliminarclientes($id) {
        $sql = "DELETE FROM tbl_clientes WHERE id_clientes = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getclientes() {
        // Punto de depuración: Iniciando getclientes
        //echo "Iniciando getclientes.<br>";
        
        // Primera consulta para obtener datos de marcas
        $queryclientes = 'SELECT * FROM ' . $this->tableclientes;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtclientes = $this->conex->prepare($queryclientes);
        $stmtclientes->execute();
        $clientes = $stmtclientes->fetchAll(PDO::FETCH_ASSOC);

        return $clientes;
    }

    
}






