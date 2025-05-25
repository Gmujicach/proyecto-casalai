<?php
require_once 'Config/config.php';

class Productos extends BD{
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
    private $clausula_garantia;
    private $servicio;
    private $serial;
    private $estado;
    private $lleva_lote;
    private $lleva_serial;
    private $categoria;
    private $id;

    private $precio;
    
    function __construct() {
        parent::__construct();
        $this->conex = parent::getConexion();
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
        return $this->clausula_garantia;
    }

    public function setClausulaDeGarantia($clausula_garantia) {
        $this->clausula_garantia = $clausula_garantia;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function setServicio($servicio) {
        $this->servicio = $servicio;
    }

    public function getCodigo() {
        return $this->serial;
    }

    public function setCodigo($serial) {
        $this->serial = $serial;
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
    // Setter para $precio
public function setPrecio($precio) {
    $this->precio = $precio;
}

// Getter para $precio
public function getPrecio() {
    return $this->precio;
}


    public function validarNombreProducto() {
        $sql = "SELECT COUNT(*) FROM tbl_productos WHERE nombre_producto = :nombre_producto";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo nombre
        return $count == 0;
    }
    
    public function validarCodigoProducto() {
        $sql = "SELECT COUNT(*) FROM tbl_productos WHERE serial = :serial_Interno";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':serial_Interno', $this->serial);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Retorna true si no existe un producto con el mismo código interno
        return $count == 0;
    }
    public function ingresarProducto() {
        $sql = "INSERT INTO tbl_productos (`serial`, `nombre_producto`, `descripcion_producto`, `id_modelo`, `id_categoria`, `stock`, `stock_minimo`, `stock_maximo`, `clausula_garantia`, `precio`, `estado`)
                VALUES (:serial_p, :nombre_producto, :descripcion_producto, :modelo, :categoria, :stock_actual, :stock_minimo, :stock_maximo, :clausula_garantia, :precio, 1)";
        
        $stmt = $this->conex->prepare($sql);
    
        $stmt->bindParam(':serial_p', $this->serial);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
        $stmt->bindParam(':descripcion_producto', $this->descripcion_p); // CORREGIDO aquí
        $stmt->bindParam(':modelo', $this->id_modelo);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_min); // CORREGIDO: stock mínimo
        $stmt->bindParam(':stock_maximo', $this->stock_max); // CORREGIDO: stock máximo
        $stmt->bindParam(':clausula_garantia', $this->clausula_garantia);
        $stmt->bindParam(':precio', $this->precio); // AÑADIDO: bind de precio
    
        return $stmt->execute();
    }
    

    public function obtenerProductoPorId($id) {
        $query = "SELECT nombre_producto, descripcion_p, id_modelo, stock, stock_max, stock_min, peso, largo, alto, ancho, clausula_garantia, servicio, serial, estado, lleva_lote, lleva_serial, categoria FROM tbl_productos WHERE id_producto = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function obtenerProductoStock() {
        $queryProductos = 'SELECT id_producto, nombre_producto, stock, id_modelo, serial FROM tbl_productos';
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function modificarProducto($id) {
        $sql = "UPDATE tbl_productos 
                SET serial = :serial_p,
                    nombre_producto = :nombre_producto,
                    descripcion_producto = :descripcion_producto,
                    id_modelo = :modelo,
                    id_categoria = :categoria,
                    stock = :stock_actual,
                    stock_minimo = :stock_minimo,
                    stock_maximo = :stock_maximo,
                    clausula_garantia = :clausula_garantia,
                    precio = :precio
                WHERE id_producto = :id_producto";
    
        $stmt = $this->conex->prepare($sql);
    
        $stmt->bindParam(':id_producto', $id);
        $stmt->bindParam(':serial_p', $this->serial);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
        $stmt->bindParam(':descripcion_producto', $this->descripcion_p);
        $stmt->bindParam(':modelo', $this->id_modelo);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_min);
        $stmt->bindParam(':stock_maximo', $this->stock_max);
        $stmt->bindParam(':clausula_garantia', $this->clausula_garantia);
        $stmt->bindParam(':precio', $this->precio);
    
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            throw new Exception('Error al modificar producto: ' . $errorInfo[2]);
        }
    }
    


    public function eliminarProducto($id) {
        $sql = "UPDATE tbl_productos SET estado = 0 WHERE id_producto = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function obtenerModelos() {
        $query = "SELECT id_modelo, nombre_modelo FROM tbl_modelos";
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



class Producto extends Productos{
    private $conex;
    private $tableProductos = 'tbl_productos';
    private $tableModelos = 'tbl_modelos';
    public $id_producto;
    public $id_modelo;
    public $nombre_producto;
    public $stock_actual;
    public $serial;

    function __construct() {
        parent::__construct();
        $this->conex = parent::getConexion();
    }

    public function obtenerProductos() {
       
        $queryProductos = 
        'SELECT tbl_productos.*, tbl_modelos.nombre_modelo, tbl_categoria.nombre_caracteristicas 
        FROM tbl_productos 
        INNER JOIN tbl_modelos 
        ON tbl_productos.id_modelo = tbl_modelos.id_modelo 
        INNER JOIN tbl_categoria 
        ON tbl_productos.id_categoria = tbl_categoria.id_categoria 
        where estado = 1;
';
       
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