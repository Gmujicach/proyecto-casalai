<?php
require_once 'Conexion.php';

class Productos {
    private $conex;
    private $id_centro;
    private $nombre_p;
    private $descripcion_p;
    private $id_modelo;
    private $stock_actual;
    private $stock_max;
    private $stock_min;
    private $peso;
    private $largo;
    private $alto;
    private $ancho;
    private $clausula_de_garantia;
    private $servicio;
    private $codigo;
    private $activo;
    private $lleva_lote;
    private $lleva_serial;
    private $categoria;
    private $id;
    
    public function __construct() {
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();
    }

    // Getters y Setters
    public function getNombreP() {
        return $this->nombre_p;
    }

    public function setNombreP($nombre_p) {
        $this->nombre_p = $nombre_p;
    }

    public function getDescripcionP() {
        return $this->descripcion_p;
    }

    public function setDescripcionP($descripcion_p) {
        $this->descripcion_p = $descripcion_p;
    }

    public function getIdModelo() {
        return $this->id_modelo;
    }

    public function setIdModelo($id_modelo) {
        $this->id_modelo = $id_modelo;
    }

    public function getStockActual() {
        return $this->stock_actual;
    }

    public function setStockActual($stock_actual) {
        $this->stock_actual = $stock_actual;
    }

    public function getStockMax() {
        return $this->stock_max;
    }

    public function setStockMax($stock_max) {
        $this->stock_max = $stock_max;
    }

    public function getStockMin() {
        return $this->stock_min;
    }

    public function setStockMin($stock_min) {
        $this->stock_min = $stock_min;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

    public function getLargo() {
        return $this->largo;
    }

    public function setLargo($largo) {
        $this->largo = $largo;
    }

    public function getAlto() {
        return $this->alto;
    }

    public function setAlto($alto) {
        $this->alto = $alto;
    }

    public function getAncho() {
        return $this->ancho;
    }

    public function setAncho($ancho) {
        $this->ancho = $ancho;
    }

    public function getClausulaDeGarantia() {
        return $this->clausula_de_garantia;
    }

    public function setClausulaDeGarantia($clausula_de_garantia) {
        $this->clausula_de_garantia = $clausula_de_garantia;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function setServicio($servicio) {
        $this->servicio = $servicio;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getLlevaLote() {
        return $this->lleva_lote;
    }

    public function setLlevaLote($lleva_lote) {
        $this->lleva_lote = $lleva_lote;
    }

    public function getLlevaSerial() {
        return $this->lleva_serial;
    }

    public function setLlevaSerial($lleva_serial) {
        $this->lleva_serial = $lleva_serial;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function validarNombreProducto() {
        $sql = "SELECT COUNT(*) FROM tbl_productos WHERE nombre_p = :Nombre_P";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':Nombre_P', $this->nombre_p);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }
    
    public function validarCodigoProducto() {
        $sql = "SELECT COUNT(*) FROM tbl_productos WHERE codigo = :Codigo_Interno";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':Codigo_Interno', $this->codigo);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo código interno
        return $count == 0;
    }
        public function ingresarProducto() {
        $sql = "INSERT INTO tbl_productos (nombre_p, descripcion_p, id_modelo, stock, stock_max, stock_min, peso, largo, alto, ancho, clausula_de_garantia, servicio, codigo, activo, lleva_lote, lleva_serial, categoria)
                VALUES (:Nombre_P, :Descripcion_P, :Modelo, :Stock_Actual, :Stock_Maximo, :Stock_Minimo, :Peso, :Largo, :Alto, :Ancho, :Clausula_de_garantia, :Servicio, :Codigo_Interno, 1, :Lote, :Serial, :Categoria)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':Nombre_P', $this->nombre_p);
        $stmt->bindParam(':Descripcion_P', $this->descripcion_p);
        $stmt->bindParam(':Modelo', $this->id_modelo);
        $stmt->bindParam(':Stock_Actual', $this->stock_actual);
        $stmt->bindParam(':Stock_Maximo', $this->stock_max);
        $stmt->bindParam(':Stock_Minimo', $this->stock_min);
        $stmt->bindParam(':Peso', $this->peso);
        $stmt->bindParam(':Largo', $this->largo);
        $stmt->bindParam(':Alto', $this->alto);
        $stmt->bindParam(':Ancho', $this->ancho);
        $stmt->bindParam(':Clausula_de_garantia', $this->clausula_de_garantia);
        $stmt->bindParam(':Servicio', $this->servicio);
        $stmt->bindParam(':Codigo_Interno', $this->codigo);
        $stmt->bindParam(':Lote', $this->lleva_lote);
        $stmt->bindParam(':Serial', $this->lleva_serial);
        $stmt->bindParam(':Categoria', $this->categoria);       
        return $stmt->execute();
    }

    public function obtenerProductoPorId($id) {
        $query = "SELECT nombre_p, descripcion_p, id_modelo, stock, stock_max, stock_min, peso, largo, alto, ancho, clausula_de_garantia, servicio, codigo, activo, lleva_lote, lleva_serial, categoria FROM tbl_productos WHERE id_producto = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function obtenerProductoStock() {
        $queryProductos = 'SELECT id_producto, nombre_p, stock, id_modelo, codigo FROM tbl_productos';
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function modificarProducto($id) {
        $sql = "UPDATE tbl_productos SET nombre_p = :Nombre_P, descripcion_p = :Descripcion_P, id_modelo = :Modelo, stock = :Stock_Actual, stock_max = :Stock_Maximo, stock_min = :Stock_Minimo, peso = :Peso, largo = :Largo, alto = :Alto, ancho = :Ancho, clausula_de_garantia = :Clausula_de_garantia, servicio = :Servicio, codigo = :Codigo_Interno, lleva_lote = :Lote, lleva_serial = :Serial, categoria = :Categoria WHERE id_producto = :id_producto";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_producto', $id);
        $stmt->bindParam(':Nombre_P', $this->nombre_p);
        $stmt->bindParam(':Descripcion_P', $this->descripcion_p);
        $stmt->bindParam(':Modelo', $this->id_modelo);
        $stmt->bindParam(':Stock_Actual', $this->stock_actual);
        $stmt->bindParam(':Stock_Maximo', $this->stock_max);
        $stmt->bindParam(':Stock_Minimo', $this->stock_min);
        $stmt->bindParam(':Peso', $this->peso);
        $stmt->bindParam(':Largo', $this->largo);
        $stmt->bindParam(':Alto', $this->alto);
        $stmt->bindParam(':Ancho', $this->ancho);
        $stmt->bindParam(':Clausula_de_garantia', $this->clausula_de_garantia);
        $stmt->bindParam(':Servicio', $this->servicio);
        $stmt->bindParam(':Codigo_Interno', $this->codigo);
        $stmt->bindParam(':Lote', $this->lleva_lote);
        $stmt->bindParam(':Serial', $this->lleva_serial);
        $stmt->bindParam(':Categoria', $this->categoria);
        
        return $stmt->execute();
    }


    public function eliminarProducto($id) {
        $sql = "UPDATE tbl_productos SET activo = 0 WHERE id_producto = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function obtenerModelos() {
        $query = "SELECT id_modelo, descripcion_mo FROM tbl_modelos";
        $stmt = $this->conex->query($query);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errorInfo = $this->conex->errorInfo();
            echo "Debug: Error en el query: " . $errorInfo[2] . "\n";
            return [];
        }
    }
}



class Producto {
    private $conex;
    private $tableProductos = 'tbl_productos';
    private $tableModelos = 'tbl_modelos';
    public $id_producto;
    public $id_modelo;
    public $nombre_p;
    public $stock_actual;
    public $codigo;

    public function __construct() {
        
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();

    }

    public function obtenerProductos() {
       
        $queryProductos = 'SELECT id_producto, nombre_p, stock, id_modelo, codigo FROM ' . $this->tableProductos . ' WHERE Activo = 1';
       
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        $idsModelos = array_column($productos, 'id_modelo');
        $idsModelos = array_unique($idsModelos);

        if (!empty($idsModelos)) {
            $idsModelos = implode(',', $idsModelos);

            $queryModelos = 'SELECT id_modelo, descripcion_mo FROM ' . $this->tableModelos . ' WHERE id_modelo IN (' . $idsModelos . ')';

            $stmtModelos = $this->conex->prepare($queryModelos);
            $stmtModelos->execute();
            $modelos = $stmtModelos->fetchAll(PDO::FETCH_ASSOC);
            $descripcionModelos = [];
            foreach ($modelos as $modelo) {
                $descripcionModelos[$modelo['id_modelo']] = $modelo['descripcion_mo'];
            }
            foreach ($productos as &$producto) {
                if (isset($descripcionModelos[$producto['id_modelo']])) {
                    $producto['descripcion_mo'] = $descripcionModelos[$producto['id_modelo']];
                } else {
                    $producto['descripcion_mo'] = null;
                }
            }
        } else {

            foreach ($productos as &$producto) {
                $producto['descripcion_mo'] = null;
            }
        }

        return $productos;
    }
}