<?php
require_once 'Config/config.php';

class Usuarios extends BD {
    
    private $conex;
    private $id_usuario;
    private $username;
    private $clave;
    private $id_rol;
    private $activo=1;
    private $tableusuarios = 'tbl_usuarios';
    private $nombre;
    private $apellido;
    private $correo;
    private $telefono;
    private $estatus=1;
    private $usuarios;


    public function __construct() {
        $conexion = new BD('S');
        $this->conex = $conexion->getConexion();
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
        return $this->id_rol;
    }

    public function setRango($id_rol) {
        $this->id_rol = $id_rol;
    }

        public function getId() {
        return $this->id_usuario;
    }

    public function setId($id_usuario) {
        $this->id_usuario = $id_usuario;
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

public function ingresarUsuario() {
    $claveEncriptada = password_hash($this->clave, PASSWORD_BCRYPT);

    $sql = "INSERT INTO tbl_usuarios (`username`, `password`, `id_rol`, `correo`, `nombres`, `apellidos`, `telefono`)
            VALUES (:username, :clave, :id_rol, :correo, :nombres, :apellidos, :telefono)";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':clave', $claveEncriptada);
    $stmt->bindParam(':id_rol', $this->id_rol);
    $stmt->bindParam(':correo', $this->correo);
    $stmt->bindParam(':nombres', $this->nombre);
    $stmt->bindParam(':apellidos', $this->apellido);
    $stmt->bindParam(':telefono', $this->telefono);

    return $stmt->execute();
}

    // Verificar si existe el número de cuenta
    public function existeUsuario($username, $excluir_id = null) {
        return $this->existeUsu($username, $excluir_id); 
    }
    private function existeUsu($username, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_usuarios WHERE username = ?";
        $params = [$username];
        if ($excluir_id !== null) {
            $sql .= " AND id_usuario != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimoUsuario() {
        return $this->obtUltimoUsu(); 
    }
    private function obtUltimoUsu() {
        try {
            $sql = "SELECT usuarios.*, rol.nombre_rol 
                FROM tbl_usuarios AS usuarios
                INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
                ORDER BY usuarios.id_usuario DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $usuario ? $usuario : null;
        } catch (PDOException $e) {
            error_log("Error al obtener la última cuenta: " . $e->getMessage());
            $this->conex = null;
            return null;
        }
    }

    // Obtener Producto por ID
public function obtenerUsuarioPorId($id_usuario) {
    $query = "SELECT usuarios.*, rol.nombre_rol 
              FROM tbl_usuarios AS usuarios
              INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
              WHERE usuarios.id_usuario = ?";
    $stmt = $this->conex->prepare($query);
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    return $usuario;
}

    // Modificar Producto
public function modificarUsuario($id_usuario) {
    $claveEncriptada = !empty($this->clave) ? password_hash($this->clave, PASSWORD_BCRYPT) : null;

    $sql = "UPDATE tbl_usuarios SET 
                username = :username, 
                id_rol = :id_rol,
                nombres = :nombre,
                apellidos = :apellido,
                correo = :correo,
                telefono = :telefono
            WHERE id_usuario = :id_usuario";

    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':username', $this->username);
    if (!empty($this->clave)) {
        $stmt->bindParam(':clave', $claveEncriptada);
    }
    $stmt->bindParam(':id_rol', $this->id_rol);
    $stmt->bindParam(':nombre', $this->nombre);
    $stmt->bindParam(':apellido', $this->apellido);
    $stmt->bindParam(':correo', $this->correo);
    $stmt->bindParam(':telefono', $this->telefono);

    return $stmt->execute();
}


    // Eliminar Producto
    public function eliminarUsuario($id_usuario) {
        $sql = "DELETE FROM tbl_usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

    public function cambiarEstatus($nuevoEstatus) {
        try {
            $sql = "UPDATE tbl_usuarios SET estatus = :estatus WHERE id_usuario = :id_usuario";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':estatus', $nuevoEstatus);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            
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
        $queryusuarios = 'SELECT usuarios.*, rol.nombre_rol 
FROM tbl_usuarios AS usuarios
INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
ORDER BY usuarios.id_usuario DESC;
';
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtusuarios = $this->conex->prepare($queryusuarios);
        $stmtusuarios->execute();
        $usuarios = $stmtusuarios->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }
}