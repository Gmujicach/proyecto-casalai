<?php 
require_once __DIR__ . '/../config/config.php';

class Usuarios extends BD {
    
    private $conex;
    private $conex2;
    private $con;

    private $id_usuario;
    private $username;
    private $clave;
    private $id_rol;
    private $activo = 1;
    private $tableusuarios = 'tbl_usuarios';
    private $nombre;
    private $apellido;
    private $correo;
    private $telefono;
    private $estatus = 1;
    private $usuarios;
    private $cedula;

    public function __construct() {
        $conexion = new BD('S');
        $this->conex = $conexion->getConexion();

        $conexion2 = new BD('P');
        $this->con = $conexion2->getConexion();
    }

    // Getters y Setters
    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function getActivo() { return $this->activo; }
    public function setActivo($activo) { $this->activo = $activo; }

    public function getUsuario() { return $this->usuarios; }
    public function setUsuario($usuario) { $this->usuario = $usuario; }

    public function getEstatus() { return $this->estatus; }
    public function setEstatus($estatus) { $this->estatus = $estatus; }

    public function getClave() { return $this->clave; }
    public function setClave($clave) { $this->clave = $clave; }

    public function getRango() { return $this->id_rol; }
    public function setRango($id_rol) { $this->id_rol = $id_rol; }

    public function getId() { return $this->id_usuario; }
    public function setId($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getApellido() { return $this->apellido; }
    public function setApellido($apellido) { $this->apellido = $apellido; }

    public function getCorreo() { return $this->correo; }
    public function setCorreo($correo) { $this->correo = $correo; }

    public function getTelefono() { return $this->telefono; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getCedula() { return $this->cedula; }
    public function setCedula($cedula) { $this->cedula = $cedula; }

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

    private function clienteExiste($cedula) {
        $sql = "SELECT COUNT(*) FROM tbl_clientes WHERE cedula = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$cedula]);
        return $stmt->fetchColumn() > 0;
    }

    public function ingresarUsuario() {
        $this->conex->beginTransaction();
        try {
            $claveEncriptada = password_hash($this->clave, PASSWORD_BCRYPT);

            $sql = "INSERT INTO tbl_usuarios (username, password, id_rol, correo, nombres, apellidos, telefono, cedula)
                    VALUES (:username, :clave, :id_rol, :correo, :nombres, :apellidos, :telefono, :cedula)";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':clave', $claveEncriptada);
            $stmt->bindParam(':id_rol', $this->id_rol);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':nombres', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellido);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':cedula', $this->cedula);
            $stmt->execute();

            if (!$this->clienteExiste($this->cedula)) {
                $sqlCliente = "INSERT INTO tbl_clientes (nombre, cedula, telefono, direccion, correo, activo)
                               VALUES (:nombre, :cedula, :telefono, '', :correo, 1)";
                $stmtCliente = $this->con->prepare($sqlCliente);
                $nombreCompleto = $this->nombre . ' ' . $this->apellido;
                $stmtCliente->bindParam(':nombre', $nombreCompleto);
                $stmtCliente->bindParam(':cedula', $this->cedula);
                $stmtCliente->bindParam(':telefono', $this->telefono);
                $stmtCliente->bindParam(':correo', $this->correo);
                $stmtCliente->execute();
            }

            $this->conex->commit();
            return true;
        } catch (PDOException $e) {
            $this->conex->rollBack();
            return false;
        }
    }

    public function modificarUsuario($id_usuario) {
        $this->conex->beginTransaction();
        try {
            $claveEncriptada = !empty($this->clave) ? password_hash($this->clave, PASSWORD_BCRYPT) : null;

            $sql = "UPDATE tbl_usuarios SET 
                        username = :username, 
                        id_rol = :id_rol,
                        nombres = :nombre,
                        apellidos = :apellido,
                        correo = :correo,
                        telefono = :telefono,
                        cedula = :cedula";
            if (!empty($this->clave)) {
                $sql .= ", password = :clave";
            }
            $sql .= " WHERE id_usuario = :id_usuario";

            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':id_rol', $this->id_rol);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
            $stmt->bindParam(':correo', $this->correo);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':cedula', $this->cedula);
            $stmt->bindParam(':id_usuario', $id_usuario);
            if (!empty($this->clave)) {
                $stmt->bindParam(':clave', $claveEncriptada);
            }
            $stmt->execute();

            if ($this->clienteExiste($this->cedula)) {
                $sqlCliente = "UPDATE tbl_clientes SET 
                                nombre = :nombre,
                                telefono = :telefono,
                                correo = :correo
                                WHERE cedula = :cedula";
                $stmtCliente = $this->con->prepare($sqlCliente);
                $nombreCompleto = $this->nombre . ' ' . $this->apellido;
                $stmtCliente->bindParam(':nombre', $nombreCompleto);
                $stmtCliente->bindParam(':telefono', $this->telefono);
                $stmtCliente->bindParam(':correo', $this->correo);
                $stmtCliente->bindParam(':cedula', $this->cedula);
                $stmtCliente->execute();
            }

            $this->conex->commit();
            return true;
        } catch (PDOException $e) {
            $this->conex->rollBack();
            return false;
        }
    }

    public function existeUsuario($username, $excluir_id = null) {
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
        try {
            $sql = "SELECT usuarios.*, rol.nombre_rol 
                    FROM tbl_usuarios AS usuarios
                    INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
                    ORDER BY usuarios.id_usuario DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario ? $usuario : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function obtenerUsuarioPorId($id_usuario) {
        $query = "SELECT usuarios.*, rol.nombre_rol 
                  FROM tbl_usuarios AS usuarios
                  INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
                  WHERE usuarios.id_usuario = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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
            return false;
        }
    }

    public function obtenerReporteRoles() {
        $sql = "SELECT rol.nombre_rol, COUNT(u.id_usuario) as cantidad
                FROM tbl_rol rol
                LEFT JOIN tbl_usuarios u ON rol.id_rol = u.id_rol
                GROUP BY rol.id_rol, rol.nombre_rol
                ORDER BY cantidad DESC";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getusuarios() {
        $queryusuarios = "SELECT usuarios.*, rol.nombre_rol 
                          FROM tbl_usuarios AS usuarios
                          INNER JOIN tbl_rol AS rol ON usuarios.id_rol = rol.id_rol
                          ORDER BY usuarios.id_usuario DESC";
        $stmtusuarios = $this->conex->prepare($queryusuarios);
        $stmtusuarios->execute();
        return $stmtusuarios->fetchAll(PDO::FETCH_ASSOC);
    }
}
