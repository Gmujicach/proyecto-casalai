<?php

require_once('config/config.php');

class Login extends BD
{


    private $username;
    private $password;
    private $co;
    private $cop;

    function set_username($valor)
    {
        $this->username = $valor;
    }

    function set_password($valor)
    {
        $this->password = $valor;
    }


    function get_username()
    {
        return $this->username;
    }

    function get_password()
    {
        return $this->password;
    }

    public function __construct() {
        $conexion = new BD('S');
        $this->co = $conexion->getConexion();
    
        $conexion2 = new BD('P');
        $this->cop = $conexion2->getConexion();
    }

    function existe() {
    
    $this->co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $r = array();
    
    try {
        // Consultar el hash de la contraseña almacenada
        $p = $this->co->prepare("SELECT 
    u.id_usuario, 
    u.id_rol,
    r.nombre_rol, 
    u.username, 
    u.password,
    u.cedula
FROM 
    tbl_usuarios u 
INNER JOIN 
    tbl_rol r 
ON 
    r.id_rol = u.id_rol
WHERE username = :username");
        $p->bindParam(':username', $this->username);
        $p->execute();

        $fila = $p->fetch(PDO::FETCH_ASSOC); // Usar fetch() en lugar de fetchAll()

        if ($fila) {
            // Verificar la contraseña ingresada contra el hash almacenado
            if (password_verify($this->password, $fila['password'])) {
                $r['resultado'] = 'existe';
                $r['mensaje'] = $fila['username'];
                $r['nombre_rol'] = $fila['nombre_rol'];
                $r['id_usuario'] = $fila['id_usuario']; 
                $r['id_rol'] = $fila['id_rol']; 
                $r['cedula'] = $fila['cedula'];
            } else {
                $r['resultado'] = 'noexiste';
                $r['mensaje'] = "Error en usuario o contraseña!!!";
            }
        } else {
            $r['resultado'] = 'noexiste';
            $r['mensaje'] = "Error en usuario o contraseña!!!";
        }
    } catch (Exception $e) {
        $r['resultado'] = 'error';
        $r['mensaje'] = $e->getMessage();
    }
    
    return $r;
}



public function registrarUsuarioYCliente($datos) {
    $this->co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $respuesta = ['status' => 'error', 'mensaje' => ''];

    try {
        // Iniciar transacción
        $this->co->beginTransaction();

        // Verifica si el usuario ya existe
        $p = $this->co->prepare("SELECT COUNT(*) FROM tbl_usuarios WHERE username = ?");
        $p->execute([$datos['nombre_usuario']]);
        if ($p->fetchColumn() > 0) {
            throw new Exception("El nombre de usuario ya está en uso. Por favor elige otro.");
        }

        // Hashea la contraseña
        $hash = password_hash($datos['clave'], PASSWORD_DEFAULT);

        // ID del rol Cliente (3 REVISAR LA BASE DE DATOS)
        $id_rol_cliente = 3;

        // Inserta en tbl_usuarios
        $p = $this->co->prepare("INSERT INTO tbl_usuarios 
                            (username, password, cedula, nombres, apellidos, correo, telefono, id_rol, estatus)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'habilitado')");
        $p->execute([
            $datos['nombre_usuario'],
            $hash,
            $datos['cedula'],
            $datos['nombre'],
            $datos['apellido'],
            $datos['correo'],
            $datos['telefono'],
            $id_rol_cliente // Usamos el ID numérico del rol Cliente
        ]);

        // Inserta en tbl_clientes
        $p = $this->cop->prepare("INSERT INTO tbl_clientes 
                            (nombre, cedula, telefono, direccion, correo, activo)
                            VALUES (?, ?, ?, ?, ?, ?)");
        $p->execute([
            $datos['nombre'] . ' ' . $datos['apellido'],
            $datos['cedula'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['correo'],
            1
        ]);

        // Confirmar transacción
        $this->co->commit();

        $respuesta['status'] = 'success';
        $respuesta['mensaje'] = 'Usuario y cliente registrados correctamente.';
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        if ($this->co->inTransaction()) {
            $this->co->rollBack();
        }
        $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
}
}
