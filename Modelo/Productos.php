<?php
require_once 'Conexion.php';

class Productos {
    private $conex;
    private $id_centro;
    private $nombre_producto;
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
        return $this->nombre_producto;
    }

    public function setNombreP($nombre_producto) {
        $this->nombre_producto = $nombre_producto;
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
        $sql = "SELECT COUNT(*) FROM productos WHERE nombre_producto = :nombre_producto";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }
    
    public function validarCodigoProducto() {
        $sql = "SELECT COUNT(*) FROM productos WHERE codigo = :Codigo_Interno";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':Codigo_Interno', $this->codigo);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo código interno
        return $count == 0;
    }
        public function ingresarProducto() {
        $sql = "INSERT INTO productos (nombre_producto, descripcion_p, id_modelo, stock, stock_max, stock_min, peso, largo, alto, ancho, clausula_de_garantia, servicio, codigo, activo, lleva_lote, lleva_serial, categoria)
                VALUES (:nombre_producto, :Descripcion_P, :Modelo, :Stock_Actual, :Stock_Maximo, :Stock_Minimo, :Peso, :Largo, :Alto, :Ancho, :Clausula_de_garantia, :Servicio, :Codigo_Interno, 1, :Lote, :Serial, :Categoria)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
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
        $query = "SELECT nombre_producto, descripcion_p, id_modelo, stock, stock_max, stock_min, peso, largo, alto, ancho, clausula_de_garantia, servicio, codigo, activo, lleva_lote, lleva_serial, categoria FROM productos WHERE id_producto = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function obtenerProductoStock() {
        $queryProductos = 'SELECT id_producto, nombre_producto, stock, id_modelo, codigo FROM productos';
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function modificarProducto($id) {
        $sql = "UPDATE productos SET nombre_producto = :nombre_producto, descripcion_p = :Descripcion_P, id_modelo = :Modelo, stock = :Stock_Actual, stock_max = :Stock_Maximo, stock_min = :Stock_Minimo, peso = :Peso, largo = :Largo, alto = :Alto, ancho = :Ancho, clausula_de_garantia = :Clausula_de_garantia, servicio = :Servicio, codigo = :Codigo_Interno, lleva_lote = :Lote, lleva_serial = :Serial, categoria = :Categoria WHERE id_producto = :id_producto";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_producto', $id);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
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
        $sql = "UPDATE productos SET activo = 0 WHERE id_producto = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function obtenerModelos() {
        $query = "SELECT id_modelo, nombre_modelo FROM modelo";
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
    private $tableProductos = 'productos';
    private $tableModelos = 'modelo';
    public $id_producto;
    public $id_modelo;
    public $nombre_producto;
    public $stock_actual;
    public $codigo;

    public function __construct() {
        
        $this->conex = new Conexion();
        $this->conex = $this->conex->Conex();

    }

    public function obtenerProductos() {
       
        $queryProductos = 'SELECT id_producto, nombre_producto, stock, id_modelo, serial FROM ' . $this->tableProductos . ' WHERE estado = 1';
       
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        $idsModelos = array_column($productos, 'id_modelo');
        $idsModelos = array_unique($idsModelos);

        if (!empty($idsModelos)) {
            $idsModelos = implode(',', $idsModelos);

            $queryModelos = 'SELECT id_modelo, nombre_modelo FROM ' . $this->tableModelos . ' WHERE id_modelo IN (' . $idsModelos . ')';

            $stmtModelos = $this->conex->prepare($queryModelos);
            $stmtModelos->execute();
            $modelos = $stmtModelos->fetchAll(PDO::FETCH_ASSOC);
            $descripcionModelos = [];
            foreach ($modelos as $modelo) {
                $descripcionModelos[$modelo['id_modelo']] = $modelo['nombre_modelo'];
            }
            foreach ($productos as &$producto) {
                if (isset($descripcionModelos[$producto['id_modelo']])) {
                    $producto['nombre_modelo'] = $descripcionModelos[$producto['id_modelo']];
                } else {
                    $producto['nombre_modelo'] = null;
                }
            }
        } else {

            foreach ($productos as &$producto) {
                $producto['nombre_modelo'] = null;
            }
        }

        return $productos;
    }
}