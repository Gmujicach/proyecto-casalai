<?php

require_once('datos.php');

class Login extends conexion
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


    function existe(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {

			
            $p = $co->prepare("SELECT rango,username FROM tbl_usuarios
			WHERE 
			username=:username
			AND 
			password=:password"); // se cambio el rango por username
            $p->bindParam(':username', $this->username);
            $p->bindParam(':password', $this->password);
            $p->execute();

            $fila = $p->fetchAll(PDO::FETCH_BOTH);
            if ($fila) {

                $r['resultado'] = 'existe';
                $r['mensaje'] = $fila[0]['username']; // Asumiendo que quieres el username
                $r['rango'] = $fila[0]['rango'];
            } else {
                $r['resultado'] = 'noexiste';
                $r['mensaje'] =  "Error en usuario o contraseña!!!";
            }
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] =  $e->getMessage();
        }
        return $r;
    }
}
