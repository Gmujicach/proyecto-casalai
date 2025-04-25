<?php
require_once 'modelo/config.php';

class Proveedores extends BD {
    
    private $conex;
    private $id;
    private $nombre;
    private $representante;
    private $rif1;
    private $rif2;
    private $telefono1;
    private $telefono2;
    private $direccion;
    private $correo;
    private $observacion;
    private $activo=1;
    private $tableproveedor= 'tbl_proveedores';

    function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Getters y Setters
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getRepresentante() {
        return $this->representante;
    }

    public function setRepresentante($representante) {
        $this->representante = $representante;
    }

    public function getRif1() {
        return $this->rif1;
    }

    public function setRif1($rif1) {
        $this->rif1 = $rif1;
    }

    public function getRif2() {
        return $this->rif2;
    }

    public function setRif2($rif2) {
        $this->rif2 = $rif2;
    }

    public function getTelefono1() {
        return $this->telefono1;
    }

    public function setTelefono1($telefono1) {
        $this->telefono1 = $telefono1;
    }

    public function getTelefono2() {
        return $this->telefono2;
    }

    public function setTelefono2($telefono2) {
        $this->telefono2 = $telefono2;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    

     // Método para guardar el proveedor

     public function validarProveedor() {
        $sql = "SELECT COUNT(*) FROM tbl_proveedores WHERE nombre = :nombre";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function validarProveedorRif() {
        $sql = "SELECT COUNT(*) FROM tbl_proveedores WHERE rif_proveedor = :rif1";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':rif1', $this->rif1);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }

    public function ingresarProveedor() {
        $sql = "INSERT INTO tbl_proveedores (`nombre`, `presona_contacto`, `direccion`, `telefono`, `telefono_secundario`, `rif_representante`, `rif_proveedor`, `correo`, `observaciones`)
                VALUES (:nombre, :representante, :direccion, :telefono1, :telefono2, :rif2, :rif1, :correo, :observacion)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':representante', $this->representante);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono1', $this->telefono1);
        $stmt->bindParam(':telefono2', $this->telefono2);
        $stmt->bindParam(':rif1', $this->rif1);
        $stmt->bindParam(':rif2', $this->rif2);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':observacion', $this->observacion);
        
        return $stmt->execute();
    }

    // Obtener Producto por ID
    public function obtenerProveedorPorId($id) {
        $query = "SELECT * FROM tbl_proveedores WHERE id_proveedor = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $proveedores = $stmt->fetch(PDO::FETCH_ASSOC);
        return $proveedores;
    }

    // Modificar Producto
    public function modificarProveedor($id) {
        $sql = "UPDATE tbl_proveedores SET nombre = :nombre, presona_contacto = :representante, direccion = :direccion, telefono = :telefono1, telefono_secundario = :telefono2, rif_representante = :rif2, rif_proveedor = :rif1, correo = :correo, observaciones = :observacion WHERE id_proveedor = :id_proveedor";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':representante', $this->representante);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono1', $this->telefono1);
        $stmt->bindParam(':telefono2', $this->telefono2);
        $stmt->bindParam(':rif1', $this->rif1);
        $stmt->bindParam(':rif2', $this->rif2);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':observacion', $this->observacion);
        
        return $stmt->execute();
    }

    // Eliminar Producto
    public function eliminarProveedor($id) {
        $sql = "DELETE FROM tbl_proveedores WHERE id_proveedor = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getproveedores() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $queryproveedores = 'SELECT * FROM ' . $this->tableproveedor;
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtproveedores = $this->conex->prepare($queryproveedores);
        $stmtproveedores->execute();
        $proveedores = $stmtproveedores->fetchAll(PDO::FETCH_ASSOC);

        return $proveedores;
    }
}

