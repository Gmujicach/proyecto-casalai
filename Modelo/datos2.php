<?php
class datos2{
	private $ip = "localhost";
    private $bd = "prueba";
    private $usuario = "root";
    private $contrasena = "";
   
    
    
    function conecta(){
        //tira de coneccion a la base de datos
        //varia segun el gestor en este caso es mysql
        $pdo = new PDO("mysql:host=".$this->ip.";dbname=".$this->bd."",$this->usuario,$this->contrasena);
	   //$pdo = new PDO("pgsql:host=".$this->ip.";port=5432;dbname=".$this->bd."",$this->usuario,$this->contraseña);
        $pdo->exec("set names utf8");
        return $pdo;
    }
}
?>