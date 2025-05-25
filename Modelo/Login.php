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
}
