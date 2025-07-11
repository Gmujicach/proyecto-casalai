<?php
require_once 'config/config.php';

class cliente extends BD {
    private $tableclientes = 'tbl_clientes';
    private $conex;
    private $nombre;
    private $direccion;
    private $telefono;
    private $cedula;
    private $correo;
    private $activo = 1;
    private $id;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    // Getters y Setters
    public function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getnombre() {
        return $this->nombre;
    }

    public function setdireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getdireccion() {
        return $this->direccion;
    }

    public function settelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function gettelefono() {
        return $this->telefono;
    }


    public function setcedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getcedula() {
        return $this->cedula;
    }

    public function setcorreo($correo) {
        $this->correo = $correo;
    }

    public function getcorreo() {
        return $this->correo;
    }

    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function ingresarclientes() {
        return $this->r_cliente();
    }
    private function r_cliente() {
        $sql = "INSERT INTO tbl_clientes (`nombre`, `cedula`, `direccion`, `telefono`, `correo`, `activo`)
                VALUES (:nombre, :cedula, :direccion, :telefono, :correo, 1)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':cedula', $this->cedula);
        $stmt->bindParam(':correo', $this->correo);
        
        return $stmt->execute();
    }

    public function existeNumeroCedula($cedula, $excluir_id = null) {
        return $this->existeNumCedula($cedula, $excluir_id); 
    }
    private function existeNumCedula($cedula, $excluir_id) {
        $sql = "SELECT COUNT(*) FROM tbl_clientes WHERE cedula = ?";
        $params = [$cedula];
        if ($excluir_id !== null) {
            $sql .= " AND id_clientes != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimoCliente() {
        return $this->obtUltimaCliente(); 
    }
    private function obtUltimaCliente() {
        try {
            $sql = "SELECT * FROM tbl_clientes ORDER BY id_clientes DESC LIMIT 1";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conex = null;
            return $cliente ? $cliente : null;
        } catch (PDOException $e) {
           $this->conex = null;
            return null;
        }
    }

    function obtenerReporteComprasClientes() {
    $db = new cliente();
    $sql = "SELECT c.nombre, COUNT(d.id_producto) AS cantidad
FROM tbl_clientes c
JOIN tbl_despachos ds ON c.id_clientes = ds.id_clientes
JOIN tbl_despacho_detalle d ON ds.id_despachos = d.id_despacho
GROUP BY c.id_clientes, c.nombre
ORDER BY cantidad DESC
LIMIT 10;";
    $stmt = $db->conex->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function obtenerclientesPorId($id) {
        return $this->obtClientePorId($id);
    }
    private function obtClientePorId($id) {
        $query = "SELECT * FROM tbl_clientes WHERE id_clientes = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $clientes = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->conex = null;
        return $clientes;
    }

    public function modificarclientes($id) {
        return $this->m_cliente($id);
    }
    private function m_cliente($id) {
        $sql = "UPDATE tbl_clientes SET nombre = :nombre, cedula = :cedula, direccion = :direccion, telefono = :telefono, correo = :correo, activo = :activo WHERE id_clientes = :id_clientes";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_clientes', $id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':cedula', $this->cedula);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':activo', $this->activo);
        
        return $stmt->execute();
    }

    function eliminar_l($id) {
        $sql = "UPDATE tbl_clientes SET activo = 0 WHERE id_clientes = :id_clientes";
        $conexion = $this->conex->prepare($sql);
        $conexion->bindParam(':id_clientes', $id);
        return $conexion->execute();
    }

    public function eliminarclientes($id) {
        return $this->e_cliente($id);
    }
    private function e_cliente($id) {
        $sql = "DELETE FROM tbl_clientes WHERE id_clientes = :id_clientes";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_clientes', $id);
        $result = $stmt->execute();
        $this->conex = null;
        return $result;
    }

    public function getclientes() {
        return $this->g_clientes();
    }
    private function g_clientes() {
        $queryclientes = 'SELECT * FROM ' . $this->tableclientes;
        
        $stmtclientes = $this->conex->prepare($queryclientes);
        $stmtclientes->execute();
        $clientes = $stmtclientes->fetchAll(PDO::FETCH_ASSOC);

        return $clientes;
    }
}






