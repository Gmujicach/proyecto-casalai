<?php
require_once 'Modelo/Permisos.php';

class Base {
    protected $permisos;
    
    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Instanciar modelo de permisos
        $this->permisos = new Permisos();
    }
    
    /**
     * Método para verificar acceso
     */
    protected function checkAccess($moduloRequerido) {
        // Si no está logueado
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login?redirect='.urlencode($_SERVER['REQUEST_URI']));
            exit();
        }
        
        // Verificar permiso
        if (!$this->permisos->verificarPermiso($_SESSION['usuario']['id_usuario'], $moduloRequerido)) {
            // Registrar intento
            $this->permisos->registrarIntentoNoAutorizado(
                $_SESSION['usuario']['id_usuario'],
                $moduloRequerido
            );
            
            // Redirigir a acceso denegado
            header('Location: /acceso-denegado');
            exit();
        }
    }
    
    /**
     * Obtener conexión a la base de datos (debes implementar según tu configuración)
     */
    protected function getDatabaseConnection() {
        // Retorna tu objeto de conexión PDO
        // Ejemplo:
        return new PDO('mysql:host=localhost;dbname=seguridadcasalai', 'root', '');
    }
}
?>