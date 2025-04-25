<?php
require_once 'Conexion.php';

class User extends Conexion {
    private $username;
    private $password;
    private $conex;

    // Getter y Setter para Username
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter y Setter para Contraseña
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }



    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }
    public function authenticateUser($username, $password) {
        $stmt = $this->conex->prepare("SELECT * FROM tbl_usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
    public function verificarUsuarioExistente($username) {
        $stmt = $this->conex->prepare("SELECT * FROM tbl_usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function insertarUsuario($user) {
        // Obtener los datos del usuario usando los getters del objeto UserModel
        
        $Username = $user->getUsername();       
        $password = $user->getPassword();
            // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Preparar la consulta con los bind parameters
        $stmt = $this->conex->prepare("INSERT INTO tbl_usuarios (username, password) VALUES (:Username, :hashed_password)");
    
        // Asociar los valores a los parámetros
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':hashed_password', $hashed_password);
    
        // Ejecutar la consulta
        return $stmt->execute();
    }

}
?>