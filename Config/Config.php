<?php
require_once 'database.php';

class BD {
    private $pdo = null;

    // $tipo: 'P' para principal, 'S' para seguridad
    public function __construct($tipo = 'P') {
        $config = ($tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->pdo;
    }

    public function cerrar() {
        $this->pdo = null;
    }
}
?>