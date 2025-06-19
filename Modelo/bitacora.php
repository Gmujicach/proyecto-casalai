<?php
require_once 'Config/Config.php';

class Bitacora extends BD {
    private $conex;

    public function __construct() {
        parent::__construct('S');
        $this->conex = parent::getConexion();
    }

    public function registrarAccion($accion, $id_modulo, $id_usuario) {
        try {
            $sql = "INSERT INTO tbl_bitacora (fecha_hora, accion, id_modulo, id_usuario) 
                    VALUES (NOW(), :accion, :id_modulo, :id_usuario)";
            
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
            $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar en bitácora: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene estadísticas detalladas de accesos al catálogo
     */
    public function obtenerEstadisticasAccesos() {
    try {
        // Accesos por semana
        $sqlSemanas = "SELECT 
                        YEARWEEK(fecha_hora) as semana,
                        COUNT(*) as total_accesos,
                        COUNT(DISTINCT id_usuario) as usuarios_unicos,
                        DAYNAME(fecha_hora) as dia_semana,
                        COUNT(*) / COUNT(DISTINCT DAY(fecha_hora)) as promedio_diario
                    FROM tbl_bitacora 
                    WHERE id_modulo = 1
                    GROUP BY YEARWEEK(fecha_hora)
                    ORDER BY semana DESC
                    LIMIT 8";
        
        $stmtSemanas = $this->conex->prepare($sqlSemanas);
        $stmtSemanas->execute();
        $semanas = $stmtSemanas->fetchAll(PDO::FETCH_ASSOC);

        // Total de accesos
        $sqlTotal = "SELECT COUNT(*) as total FROM tbl_bitacora WHERE id_modulo = 1";
        $stmtTotal = $this->conex->prepare($sqlTotal);
        $stmtTotal->execute();
        $total = $stmtTotal->fetch(PDO::FETCH_ASSOC);

        // Usuarios únicos totales
        $sqlUnicos = "SELECT COUNT(DISTINCT id_usuario) as unicos FROM tbl_bitacora WHERE id_modulo = 1";
        $stmtUnicos = $this->conex->prepare($sqlUnicos);
        $stmtUnicos->execute();
        $unicos = $stmtUnicos->fetch(PDO::FETCH_ASSOC);

        return [
            'semanas' => $semanas,
            'total' => $total['total'],
            'unicos' => $unicos['unicos'],
            'promedio_diario' => $total['total'] / 30 // Promedio mensual
        ];
    } catch (PDOException $e) {
        error_log("Error al obtener estadísticas de accesos: " . $e->getMessage());
        return [];
    }
}


    /**
     * Obtiene los usuarios más activos con detalles completos
     */
    public function obtenerUsuariosMasActivos($limit = 5) {
    try {
        $sql = "SELECT 
                    u.id_usuario,
                    u.username,
                    u.nombres,
                    u.apellidos,
                    COUNT(b.id_bitacora) as total_accesos,
                    MAX(b.fecha_hora) as ultimo_acceso,
                    MIN(b.fecha_hora) as primer_acceso
                FROM tbl_bitacora b
                JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario
                WHERE b.id_modulo = 1
                GROUP BY b.id_usuario
                ORDER BY total_accesos DESC
                LIMIT :limit";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar porcentaje de participación
        $totalAccesos = $this->obtenerTotalAccesos();
        foreach ($usuarios as &$usuario) {
            $usuario['porcentaje'] = $totalAccesos > 0 ? 
                round(($usuario['total_accesos'] / $totalAccesos * 100), 2) : 0;
        }

        return $usuarios;
    } catch (PDOException $e) {
        error_log("Error al obtener usuarios más activos: " . $e->getMessage());
        return [];
    }
}

    private function obtenerTotalAccesos() {
    $sql = "SELECT COUNT(*) as total FROM tbl_bitacora WHERE id_modulo = 1";
    $stmt = $this->conex->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

    /**
     * Obtiene registros detallados de la bitácora
     */
    public function obtenerRegistrosDetallados($limit = 100) {
        try {
            $sql = "SELECT 
                        b.id_bitacora,
                        b.fecha_hora,
                        b.accion,
                        u.username,
                        u.nombres,
                        u.apellidos,
                        m.nombre_modulo
                    FROM tbl_bitacora b
                    JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario
                    JOIN tbl_modulos m ON b.id_modulo = m.id_modulo
                    WHERE b.id_modulo = 1
                    ORDER BY b.fecha_hora DESC
                    LIMIT :limit";
            
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener registros detallados: " . $e->getMessage());
            return [];
        }
    }
}
?>