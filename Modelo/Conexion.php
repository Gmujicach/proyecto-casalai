<?php  
require_once 'Config/Config.php';

class Conexion {
    private $conex;

    public function __construct() {
        $dsn = "mysql:host="._DB_HOST_.";dbname="._DB_NAME_.";charset=utf8";
        try {
            $this->conex = new PDO($dsn, _DB_USER_, _DB_PASS_);
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function Conex() {
        return $this->conex;
    }
}

?>
