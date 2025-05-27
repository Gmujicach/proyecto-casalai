<?php
require_once 'Modelo/Proveedores.php';
require_once 'Modelo/Productos.php';
require_once 'Config/config.php';

// Configuración de PHPMailer
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['accion'] == 'realizar_pedido') {
    try {
        // Obtener datos del formulario
        $id_producto = $_POST['id_producto'];
        $id_proveedor = $_POST['id_proveedor'];
        $cantidad = $_POST['cantidad'];
        
        // Obtener información del producto
        $productoModel = new Producto();
        $producto = $productoModel->obtenerProductoPorId($id_producto);
        
        // Obtener información del proveedor
        $proveedorModel = new Proveedores();
        $proveedor = $proveedorModel->obtenerProveedorPorId($id_proveedor);
        
        if (!$producto || !$proveedor) {
            throw new Exception("No se pudo obtener la información del producto o proveedor");
        }
        
        // Registrar el pedido en la base de datos (necesitarás crear esta tabla)
        $conexion = new BD('P');
        $conn = $conexion->getConexion();
        
        $query = "INSERT INTO tbl_pedidos_proveedores 
                 (id_producto, id_proveedor, cantidad, fecha_pedido, estado) 
                 VALUES (?, ?, ?, NOW(), 'pendiente')";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_producto, $id_proveedor, $cantidad]);
        
        // Configurar y enviar correo
        $mail = new PHPMailer(true);
        
        // Configuración del servidor SMTP (ajusta según tu configuración)
        $mail->isSMTP();
        $mail->Host = 'smtp.tudominio.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@tudominio.com';
        $mail->Password = 'tu_contraseña';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Remitente y destinatario
        $mail->setFrom('inventario@tudominio.com', 'Sistema de Inventario');
        $mail->addAddress($proveedor['correo'], $proveedor['nombre']);
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo Pedido de Producto - ' . $producto['nombre_producto'];
        
        $mail->Body = "
            <h1>Solicitud de Pedido</h1>
            <p>Estimado proveedor <strong>{$proveedor['nombre']}</strong>,</p>
            <p>Le informamos que hemos realizado un pedido con los siguientes detalles:</p>
            
            <table border='1' cellpadding='5' cellspacing='0'>
                <tr>
                    <th>Producto</th>
                    <th>Modelo</th>
                    <th>Cantidad Solicitada</th>
                </tr>
                <tr>
                    <td>{$producto['nombre_producto']}</td>
                    <td>{$producto['nombre_modelo']}</td>
                    <td>{$cantidad}</td>
                </tr>
            </table>
            
            <p>Por favor confirme la recepción de este pedido y la fecha estimada de entrega.</p>
            <p>Atentamente,</p>
            <p>El equipo de Inventario</p>
        ";
        
        $mail->send();
        
        // Redirigir con mensaje de éxito
        session_start();
        $_SESSION['mensaje'] = "Pedido realizado correctamente y notificación enviada al proveedor.";
        header('Location: ../Vista/Proveedores.php');
    } catch (Exception $e) {
        // En caso de error
        session_start();
        $_SESSION['error'] = "Error al procesar el pedido: " . $e->getMessage();
        header('Location: ../Vista/Proveedores.php');
    }
    exit();
}
?>