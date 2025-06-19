<?php

require_once 'Config/Config.php';

class Permisos extends BD {
    protected $db;
    
   public function __construct() {
        $db = new BD('S');
        $this->conex = $db->getConexion();
    }
    
    /**
     * Verifica si un usuario tiene permiso para un módulo específico
     */
        public function verificarPermiso($usuarioId, $modulo) {
            $query = "SELECT COUNT(*) FROM usuarios u
                    JOIN rol_permiso rp ON u.rol_id = rp.rol_id
                    JOIN permisos p ON rp.permiso_id = p.id
                    WHERE u.id = ? AND p.modulo = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$usuarioId, $modulo]);
            return $stmt->fetchColumn() > 0;
        }
    
    /**
     * Obtiene todos los permisos de un usuario
     */
    public function obtenerPermisosUsuario($usuarioId) {
        $query = "SELECT p.modulo FROM usuarios u
                 JOIN rol_permiso rp ON u.rol_id = rp.rol_id
                 JOIN permisos p ON rp.permiso_id = p.id
                 WHERE u.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    /**
     * Registra intento de acceso no autorizado
     */
    public function registrarIntentoNoAutorizado($usuarioId, $modulo) {
        $query = "INSERT INTO tbl_bitacora (id_usuario, id_modulo, fecha_hora)
                 VALUES (?, ?, NOW(), ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $usuarioId,
            $modulo,
            $_SERVER['REMOTE_ADDR']
        ]);
    }
}
?>