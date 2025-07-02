<?php
require_once 'Config/Config.php';

class Bitacora extends BD {
    private $conex;

    public function __construct() {
        parent::__construct('S'); // Conexión a seguridadlai
        $this->conex = parent::getConexion();
    }

    // Registrar acción en la bitácora
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

    // Obtener registros detallados de la bitácora (con usuario y módulo)
    public function obtenerRegistrosDetallados($limit = 100) {
        try {
            $sql = "SELECT 
                        b.id_bitacora,
                        b.fecha_hora,
                        b.accion,
                        b.id_modulo,
                        b.id_usuario
                    FROM tbl_bitacora b
                    ORDER BY b.fecha_hora DESC
                    LIMIT :limit";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener registros detallados: " . $e->getMessage());
            return [];
        }
    }

    // Estadísticas de accesos semanales al catálogo
    public function obtenerEstadisticasAccesos() {
        // Agrupa por semana (formato: YYYYWW)
        $sql = "SELECT 
                    YEAR(fecha_hora) * 100 + WEEK(fecha_hora, 1) AS semana,
                    COUNT(*) AS total_accesos,
                    COUNT(DISTINCT id_usuario) AS usuarios_unicos,
                    ROUND(COUNT(*) / 7, 1) AS promedio_diario
                FROM tbl_bitacora
                WHERE id_modulo = 1
                GROUP BY semana
                ORDER BY semana DESC
                LIMIT 10";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        $semanas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Totales generales
        $sqlTotal = "SELECT COUNT(*) AS total, COUNT(DISTINCT id_usuario) AS unicos FROM tbl_bitacora WHERE id_modulo = 1";
        $stmtTotal = $this->conex->prepare($sqlTotal);
        $stmtTotal->execute();
        $totales = $stmtTotal->fetch(PDO::FETCH_ASSOC);

        // Promedio diario global
        $sqlDias = "SELECT DATEDIFF(MAX(fecha_hora), MIN(fecha_hora)) + 1 AS dias FROM tbl_bitacora WHERE id_modulo = 1";
        $stmtDias = $this->conex->prepare($sqlDias);
        $stmtDias->execute();
        $dias = $stmtDias->fetchColumn();
        $promedio_diario = ($dias > 0 && $totales['total'] > 0) ? round($totales['total'] / $dias, 1) : 0;

        return [
            'total' => $totales['total'],
            'unicos' => $totales['unicos'],
            'promedio_diario' => $promedio_diario,
            'semanas' => $semanas
        ];
    }

    // Top usuarios más activos en el catálogo
    public function obtenerUsuariosMasActivos($limite = 10) {
        $sql = "SELECT 
                    u.id_usuario,
                    u.username,
                    u.nombres,
                    u.apellidos,
                    COUNT(b.id_bitacora) AS total_accesos,
                    MIN(b.fecha_hora) AS primer_acceso
                FROM tbl_bitacora b
                JOIN tbl_usuarios u ON b.id_usuario = u.id_usuario
                WHERE b.id_modulo = 1
                GROUP BY u.id_usuario
                ORDER BY total_accesos DESC
                LIMIT :limite";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calcular porcentaje de participación
        $totalAccesos = array_sum(array_column($usuarios, 'total_accesos'));
        foreach ($usuarios as &$usuario) {
            $usuario['porcentaje'] = $totalAccesos > 0 ? round(($usuario['total_accesos'] / $totalAccesos) * 100, 2) : 0;
        }
        return $usuarios;
    }

    // Puedes agregar más métodos según necesidades del sistema...
}
?>