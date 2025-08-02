<?php
class NotificacionModel {
    private $pdo_seguridad;
    
    public function __construct($pdo_seguridad) {
        $this->pdo_seguridad = $pdo_seguridad;
    }
    
    public function crear($id_usuario, $tipo, $titulo, $mensaje, $id_referencia = null, $prioridad = 'media') {
        $stmt = $this->pdo_seguridad->prepare("INSERT INTO tbl_notificaciones 
            (id_usuario, tipo, titulo, mensaje, id_referencia, prioridad) 
            VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$id_usuario, $tipo, $titulo, $mensaje, $id_referencia, $prioridad]);
    }
    
    // Métodos específicos para tipos comunes
    public function notificarPago($id_usuario, $id_pago, $estado) {
        $titulo = "Estado de pago actualizado";
        $mensaje = "Su pago ha sido " . ($estado == 'procesado' ? "aprobado" : ($estado == 'pendiente' ? "recibido" : "rechazado"));
        return $this->crear($id_usuario, 'pago', $titulo, $mensaje, $id_pago, 'alta');
    }
    
    public function notificarDespacho($id_usuario, $id_despacho, $estado) {
        $titulo = "Estado de despacho";
        $mensaje = "Su pedido ha sido " . ($estado == 'enviado' ? "despachado" : "preparado para envío");
        return $this->crear($id_usuario, 'despacho', $titulo, $mensaje, $id_despacho, 'media');
    }

    // Agregar este método a NotificacionModel (notificacion.php)
    public function marcarComoLeido($id_notificacion) {
        $stmt = $this->pdo_seguridad->prepare("UPDATE tbl_notificaciones SET leido = 1 WHERE id_notificacion = ?");
        return $stmt->execute([$id_notificacion]);
    }
}