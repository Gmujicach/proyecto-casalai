<?php
require_once('config/config.php');
require_once('modelo/permiso.php');

// Registro de depuración
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_notificacion = $_POST['id_notificacion'] ?? null;
    
    file_put_contents('debug.log', "ID recibido: $id_notificacion\n", FILE_APPEND);
    
    if ($id_notificacion) {
        try {
            $bd_seguridad = new BD('S');
            $pdo_seguridad = $bd_seguridad->getConexion();
            
            $stmt = $pdo_seguridad->prepare("UPDATE tbl_notificaciones SET leido = 1 WHERE id_notificacion = ?");
            $result = $stmt->execute([$id_notificacion]);
            
            file_put_contents('debug.log', "Resultado actualización: " . ($result ? "éxito" : "fallo") . "\n", FILE_APPEND);
            
            echo json_encode(['success' => $result, 'rows_affected' => $stmt->rowCount()]);
        } catch (PDOException $e) {
            file_put_contents('debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de notificación no proporcionado']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}