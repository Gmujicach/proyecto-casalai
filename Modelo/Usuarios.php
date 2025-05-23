<?php
require_once 'Config/config.php';

class Usuarios extends BD {
    
    private $conex;
    private $id;
    private $username;
    private $clave;
    private $rango="usuario";
    private $activo=1;
    private $tableusuarios = 'tbl_usuarios';
    private $nombre;
    private $apellido;
    private $correo;
    private $telefono;
    private $estatus=1;
    private $usuarios;


    function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Getters y Setters
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getActivo() {
        return $this->activo;
    }
    public function setActivo($activo) {
        $this->activo = $activo;
    }
    public function getUsuario() {
        return $this->usuarios;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getEstatus() {
        return $this->estatus;
    }
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }
    public function getRango() {
        return $this->rango;
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

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function getCorreo() {
        return $this->correo;
    }
    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    private function verificarCampoEstatus() {
        $sql = "SHOW COLUMNS FROM tbl_usuarios LIKE 'estatus'";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $alterSql = "ALTER TABLE tbl_usuarios 
                         ADD estatus ENUM('habilitado','deshabilitado') NOT NULL DEFAULT 'habilitado'";
            $this->conex->exec($alterSql);
        }
    }


     // Método para guardar el proveedor

     public function validarUsuario() {
        $sql = "SELECT COUNT(*) FROM tbl_usuarios WHERE username = :username";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarUsuario() {

        $claveEncriptada = password_hash($this->clave, PASSWORD_BCRYPT);

        $sql = "INSERT INTO tbl_usuarios (`username`, `password`, `rango`, `correo`, `nombres`, `apellidos`, `telefono`)
                VALUES (:nombre, :clave, :rango, :correo, :nombres, :apellidos, :telefono)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $this->username);
        $stmt->bindParam(':clave',$claveEncriptada);
        $stmt->bindParam(':rango', $this->rango);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':nombres', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        
        return $stmt->execute();
    }

    // Obtener Producto por ID
    public function obtenerUsuarioPorId($id) {
        $query = "SELECT * FROM tbl_usuarios WHERE id_usuario = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuarios;
    }

    // Modificar Producto
    public function modificarUsuario($id) {

        $claveEncriptada = !empty($this->clave) ? password_hash($this->clave, PASSWORD_BCRYPT) : null;

        $sql = "UPDATE tbl_usuarios SET username = :nombre, " . 
           (!empty($this->clave) ? "`password` = :clave, " : "") . 
           "rango = :rango WHERE id_usuario = :id_usuario";

        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_usuario', $id);
        $stmt->bindParam(':nombre', $this->username);
        if (!empty($this->clave)) {
                $stmt->bindParam(':clave', $claveEncriptada);
            }
        $stmt->bindParam(':rango', $this->rango);
        
        return $stmt->execute();
    }

    // Eliminar Producto
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM tbl_usuarios WHERE id_usuario = :id";
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
            error_log("Error al cambiar estatus: " . $e->getMessage());
            return false;
        }
    }

    


    public function getusuarios() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $queryusuarios = 'SELECT * FROM ' . $this->tableusuarios;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtusuarios = $this->conex->prepare($queryusuarios);
        $stmtusuarios->execute();
        $usuarios = $stmtusuarios->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }
}