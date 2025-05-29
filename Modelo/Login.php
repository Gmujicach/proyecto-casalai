<?php

require_once('Config/config.php');

class Login extends BD
{


    private $username;
    private $password;

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


    function existe() {
    $co = $this->getConexion();
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $r = array();
    
    try {
        // Consultar el hash de la contraseña almacenada
        $p = $co->prepare("SELECT id_usuario, rango, username, password FROM tbl_usuarios 
                          WHERE username = :username");
        $p->bindParam(':username', $this->username);
        $p->execute();

        $fila = $p->fetch(PDO::FETCH_ASSOC); // Usar fetch() en lugar de fetchAll()

        if ($fila) {
            // Verificar la contraseña ingresada contra el hash almacenado
            if (password_verify($this->password, $fila['password'])) {
                $r['resultado'] = 'existe';
                $r['mensaje'] = $fila['username'];
                $r['rango'] = $fila['rango'];
                $r['id_usuario'] = $fila['id_usuario']; // Opcional: útil para sesiones
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
    $co = $this->getConexion();
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $respuesta = ['status' => 'error', 'mensaje' => ''];

    try {
        // Verifica si el usuario ya existe
        $p = $co->prepare("SELECT COUNT(*) FROM tbl_usuarios WHERE username = ?");
        $p->execute([$datos['nombre_usuario']]);
        if ($p->fetchColumn() > 0) {
            $respuesta['mensaje'] = "El nombre de usuario ya está en uso. Por favor elige otro.";
            return $respuesta;
        }

        // Hashea la contraseña
        $hash = password_hash($datos['clave'], PASSWORD_DEFAULT);

        // Inserta en tbl_usuarios
        $p = $co->prepare("INSERT INTO tbl_usuarios (username, password, nombres, apellidos, correo, telefono, rango, estatus)
                           VALUES (?, ?, ?, ?, ?, ?, 'Cliente', 'habilitado')");
        $p->execute([
            $datos['nombre_usuario'],
            $hash,
            $datos['nombre'],
            $datos['apellido'],
            $datos['correo'],
            $datos['telefono']
        ]);

        // Inserta en tbl_clientes
        $p = $co->prepare("INSERT INTO tbl_clientes (nombre, cedula, telefono, direccion, correo, activo)
                           VALUES (?, ?, ?, ?, ?, ?)");
        $p->execute([
            $datos['nombre'] . ' ' . $datos['apellido'],
            $datos['cedula'],
            $datos['telefono'],
            $datos['direccion'],
            $datos['correo'],
            1
        ]);

        $respuesta['status'] = 'success';
        $respuesta['mensaje'] = 'Usuario y cliente registrados correctamente.';
    } catch (Exception $e) {
        $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
}
}
