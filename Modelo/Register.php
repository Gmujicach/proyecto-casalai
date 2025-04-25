<?php
// modelo.php
require_once 'Conexion.php';

class UserModel extends Conexion {
    private $nombre;
    private $apellido;
    private $username;
    private $rif;
    private $correo;
    private $numero_contacto;
    private $numero_contacto_secundario;
    private $password;
    private $conex;

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Getter y Setter para Apellido
    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    // Getter y Setter para Username
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter y Setter para Rif
    public function getRif() {
        return $this->rif;
    }

    public function setRif($rif) {
        $this->rif = $rif;
    }

    // Getter y Setter para Correo
    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    // Getter y Setter para Numero de Contacto
    public function getNumeroContacto() {
        return $this->numero_contacto;
    }

    public function setNumeroContacto($numero_contacto) {
        $this->numero_contacto = $numero_contacto;
    }

    // Getter y Setter para Numero de Contacto Secundario
    public function getNumeroContactoSecundario() {
        return $this->numero_contacto_secundario;
    }

    public function setNumeroContactoSecundario($numero_contacto_secundario) {
        $this->numero_contacto_secundario = $numero_contacto_secundario;
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

    public function verificarUsuarioExistente() {
        $stmt = $this->conex->prepare("SELECT * FROM usuarios WHERE usuario = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function verificarCorreoExistente($correo) {
        $stmt = $this->conex->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function insertarUsuario($userModel) {
        // Obtener los datos del usuario usando los getters del objeto UserModel
        $Nombre = $userModel->getNombre();
        $Apellido = $userModel->getApellido();
        $Rif = $userModel->getRif();
        $Numero_Contacto = $userModel->getNumeroContacto();
        $Numero_Contacto_Secundario = $userModel->getNumeroContactoSecundario();
        $Username = $userModel->getUsername();
        $correo = $userModel->getCorreo();
        $password = $userModel->getPassword();
    
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Preparar la consulta con los bind parameters
        $stmt = $this->conex->prepare("INSERT INTO usuarios (Nombre, Apellido, Rif, Numero_Contacto, Numero_Contacto_Secundario, Username, correo, password, Id_Cargo) VALUES (:Nombre, :Apellido, :Rif, :Numero_Contacto, :Numero_Contacto_Secundario, :Username, :correo, :hashed_password, 1)");
    
        // Asociar los valores a los parámetros
        $stmt->bindParam(':Nombre', $Nombre);
        $stmt->bindParam(':Apellido', $Apellido);
        $stmt->bindParam(':Rif', $Rif);
        $stmt->bindParam(':Numero_Contacto', $Numero_Contacto);
        $stmt->bindParam(':Numero_Contacto_Secundario', $Numero_Contacto_Secundario);
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':hashed_password', $hashed_password);
    
        // Ejecutar la consulta
        return $stmt->execute();
    }
}
?>