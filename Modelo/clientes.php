<?php
require_once 'Conexion.php';

class cliente extends Conexion {
    private $tableclientes = 'tbl_clientes';
    private $conex;
    private $nombre;
    private $persona;
    private $direccion;
    private $telefono_1;
    private $telefono_2;
    private $rif;
    private $correo;
    private $observacion;
    private $activo = 1;
    private $id;

    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }

    // Getters y Setters
    public function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getnombre() {
        return $this->nombre;
    }

    public function setpersona($persona) {
        $this->persona = $persona;
    }

    public function getpersona() {
        return $this->persona;
    }

    public function setdireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getdireccion() {
        return $this->direccion;
    }

    public function settelefono_1($telefono_1) {
        $this->telefono_1 = $telefono_1;
    }

    public function gettelefono_1() {
        return $this->telefono_1;
    }

    public function settelefono_2($telefono_2) {
        $this->telefono_2 = $telefono_2;
    }

    public function gettelefono_2() {
        return $this->telefono_2;
    }

    public function setrif($rif) {
        $this->rif = $rif;
    }

    public function getrif() {
        return $this->rif;
    }

    public function setcorreo($correo) {
        $this->correo = $correo;
    }

    public function getcorreo() {
        return $this->correo;
    }

    public function setobservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getobservacion() {
        return $this->observacion;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validaRifCliente() {
        $sql = "SELECT COUNT(*) FROM tbl_clientes WHERE rif = :rif";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':rif', $this->rif);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarclientes() {
        $sql = "INSERT INTO tbl_clientes (nombre, persona_contacto, direccion, telefono, telefono_secundario, rif, correo, observaciones, activo)
                VALUES (:nombre, :persona, :direccion, :telefono_1, :telefono_2, :rif, :correo, :observacion, :activo)";
        $stmt = $this->conex->prepare($sql);
        // Asignar valores a los parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':persona', $this->persona);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono_1', $this->telefono_1);
        $stmt->bindParam(':telefono_2', $this->telefono_2);
        $stmt->bindParam(':rif', $this->rif);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':observacion', $this->observacion);
        $stmt->bindParam(':activo', $this->activo);
        
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
    $sql = "UPDATE tbl_clientes SET nombre = :nombre, persona_contacto = :persona_contacto, direccion = :direccion, telefono = :telefono_1, telefono_secundario = :telefono_2, rif = :rif, correo = :correo, observaciones = :observacion, activo = :activo WHERE id_clientes = :id_clientes";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_clientes', $id);
    $stmt->bindParam(':nombre', $this->nombre);
    $stmt->bindParam(':persona_contacto', $this->persona);
    $stmt->bindParam(':direccion', $this->direccion);
    $stmt->bindParam(':telefono_1', $this->telefono_1);
    $stmt->bindParam(':telefono_2', $this->telefono_2);
    $stmt->bindParam(':rif', $this->rif);
    $stmt->bindParam(':correo', $this->correo);
    $stmt->bindParam(':observacion', $this->observacion);
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
        $queryclientes = 'SELECT id_clientes, nombre, persona_contacto, direccion, telefono, telefono_secundario, rif, correo, observaciones, activo FROM ' . $this->tableclientes;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtclientes = $this->conex->prepare($queryclientes);
        $stmtclientes->execute();
        $clientes = $stmtclientes->fetchAll(PDO::FETCH_ASSOC);

        return $clientes;
    }

    
}






