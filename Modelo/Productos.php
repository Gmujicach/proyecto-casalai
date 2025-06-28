<?php
require_once 'Config/Config.php';

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
    private $numero;
    private $color;
    private $tipo;
    private $volumen;
    private $capacidad;
    private $descripcion_otros;

    private $voltaje_entrada;
    private $voltaje_salida;
    private $tomas;



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

public function setPeso($peso) { $this->peso = $peso; }
public function setAlto($alto) { $this->alto = $alto; }
public function getAlto() { return $this->alto; }

public function setAncho($ancho) { $this->ancho = $ancho; }
public function getAncho() { return $this->ancho; }

public function setLargo($largo) { $this->largo = $largo; }
public function getLargo() { return $this->largo; }

public function setNumero($numero) { $this->numero = $numero; }
public function getNumero() { return $this->numero; }

public function setColor($color) { $this->color = $color; }
public function getColor() { return $this->color; }

public function setTipo($tipo) { $this->tipo = $tipo; }
public function getTipo() { return $this->tipo; }

public function setVolumen($volumen) { $this->volumen = $volumen; }
public function getVolumen() { return $this->volumen; }

// Reutiliza setNumero(), setColor()

public function setCapacidad($capacidad) { $this->capacidad = $capacidad; }
public function getCapacidad() { return $this->capacidad; }

public function setDescripcionOtros($descripcion) { $this->descripcion_otros = $descripcion; }
public function getDescripcionOtros() { return $this->descripcion_otros; }

public function setVoltajeEntrada($voltaje_entrada) { $this->voltaje_entrada = $voltaje_entrada; }
public function getVoltajeEntrada() { return $this->voltaje_entrada; }
public function setVoltajeSalida($voltaje_salida) { $this->voltaje_salida = $voltaje_salida; }
public function getVoltajeSalida() { return $this->voltaje_salida; }
public function setTomas($tomas) { $this->tomas = $tomas; }
public function getTomas() { return $this->tomas; }


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



public function ingresarProducto($datosCategoria) {
    try {
        $this->conex->beginTransaction();

        // 1. Obtener el nombre de la tabla dinámica y deducir el nombre de la categoría
        if (empty($datosCategoria['tabla_categoria'])) {
            throw new Exception("No se especificó la tabla de categoría.");
        }
        $tablaCategoria = $datosCategoria['tabla_categoria']; // Ejemplo: cat_herramientas

        // Deducir el nombre de la categoría (sin 'cat_', reemplazar '_' por ' ')
        $nombreCategoria = str_replace('_', ' ', ucfirst(str_replace('cat_', '', $tablaCategoria)));

        // 2. Buscar el id_categoria en tbl_categoria usando el nombre
        $sqlCatId = "SELECT id_categoria FROM tbl_categoria WHERE LOWER(nombre_categoria) = LOWER(:nombre_categoria) LIMIT 1";
        $stmtCatId = $this->conex->prepare($sqlCatId);
        $stmtCatId->bindParam(':nombre_categoria', $nombreCategoria);
        $stmtCatId->execute();
        $idCategoria = $stmtCatId->fetchColumn();

        if (!$idCategoria) {
            $this->conex->rollBack();
            throw new Exception("No se encontró la categoría '$nombreCategoria' en la base de datos.");
        }

        // 3. Insertar producto principal
        $sql = "INSERT INTO tbl_productos (`serial`, `nombre_producto`, `descripcion_producto`, `id_modelo`, `id_categoria`, `stock`, `stock_minimo`, `stock_maximo`, `clausula_garantia`, `precio`, `estado`)
                VALUES (:serial_p, :nombre_producto, :descripcion_producto, :modelo, :categoria, :stock_actual, :stock_minimo, :stock_maximo, :clausula_garantia, :precio, 'habilitado')";

        $stmt = $this->conex->prepare($sql);

        $stmt->bindParam(':serial_p', $this->serial);
        $stmt->bindParam(':nombre_producto', $this->nombre_producto);
        $stmt->bindParam(':descripcion_producto', $this->descripcion_p);
        $stmt->bindParam(':modelo', $this->id_modelo);
        $stmt->bindParam(':categoria', $idCategoria); // Usar el id_categoria obtenido
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_min);
        $stmt->bindParam(':stock_maximo', $this->stock_max);
        $stmt->bindParam(':clausula_garantia', $this->clausula_garantia);
        $stmt->bindParam(':precio', $this->precio);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $this->conex->rollBack();
            error_log("Error SQL al insertar producto: " . $errorInfo[2]);
            throw new Exception("Error SQL al insertar producto: " . $errorInfo[2]);
        }

        $idProducto = $this->conex->lastInsertId();

        // 4. Insertar características dinámicas en la tabla de la categoría
        if (!empty($tablaCategoria) && !empty($datosCategoria['carac']) && is_array($datosCategoria['carac'])) {
            $caracteristicas = $datosCategoria['carac'];

            $campos = array_keys($caracteristicas);
            $placeholders = array_map(function($k){ return ':' . $k; }, $campos);

            $sqlCat = "INSERT INTO `$tablaCategoria` (id_producto, " . implode(',', $campos) . ") VALUES (:id_producto, " . implode(',', $placeholders) . ")";
            $stmtCat = $this->conex->prepare($sqlCat);
            $stmtCat->bindParam(':id_producto', $idProducto);

            foreach ($caracteristicas as $campo => $valor) {
                $stmtCat->bindValue(':' . $campo, $valor);
            }

            if (!$stmtCat->execute()) {
                $errorInfo = $stmtCat->errorInfo();
                $this->conex->rollBack();
                error_log("Error SQL al insertar características: " . $errorInfo[2]);
                throw new Exception("Error SQL al insertar características: " . $errorInfo[2]);
            }
        }

        $this->conex->commit();
        return $idProducto;

    } catch (Exception $e) {
        $this->conex->rollBack();
        error_log("Error al ingresar producto: " . $e->getMessage());
        throw new Exception("Error al ingresar producto: " . $e->getMessage());
    }
}
public function actualizarstockProducto($id_producto, $cantidad) {
    // Disminuir el stock según la cantidad vendida
    $sql = "UPDATE tbl_productos 
            SET stock = stock - :cantidad
            WHERE id_producto = :id_producto";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    return $stmt->execute();
}
    public function obtenerProductoPorId($id) {
        $query = "SELECT * FROM tbl_productos WHERE id_producto = ?";
        $stmt = $this->conex->prepare($query);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }


public function obtenerCategoriasDinamicas() {
    $sql = "SHOW TABLES LIKE 'cat\_%'";
    $stmt = $this->conex->prepare($sql);
    $stmt->execute();
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $categorias = [];
    foreach ($tablas as $tabla) {
        // Obtener nombre de la categoría
        $nombre_categoria = ucfirst(str_replace('cat_', '', $tabla));
        // Obtener columnas (características)
        $cols = $this->conex->query("SHOW COLUMNS FROM `$tabla`")->fetchAll(PDO::FETCH_ASSOC);
        $caracteristicas = [];
        foreach ($cols as $col) {
            if (!in_array($col['Field'], ['id', 'id_producto'])) {
                $tipo = 'string';
                if (strpos($col['Type'], 'int') !== false) $tipo = 'int';
                elseif (strpos($col['Type'], 'float') !== false) $tipo = 'float';
                $max = 255;
                if (preg_match('/varchar\((\d+)\)/i', $col['Type'], $m)) $max = $m[1];
                $caracteristicas[] = [
                    'nombre' => $col['Field'],
                    'tipo' => $tipo,
                    'max' => $max
                ];
            }
        }
        $categorias[] = [
            'tabla' => $tabla,
            'nombre_categoria' => $nombre_categoria,
            'caracteristicas' => $caracteristicas
        ];
    }
    return $categorias;
}
    public function obtenerProductoStock() {
        $queryProductos = 'SELECT id_producto, nombre_producto, stock, id_modelo, serial FROM tbl_productos';
        $stmtProductos = $this->conex->prepare($queryProductos);
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

public function modificarProducto($id, $datosCategoria) {
    try {
        $this->conex->beginTransaction();

        // 1. Obtener el nombre de la tabla dinámica y deducir el nombre de la categoría
        if (empty($datosCategoria['tabla_categoria'])) {
            throw new Exception("No se especificó la tabla de categoría.");
        }
        $tablaCategoria = $datosCategoria['tabla_categoria']; // Ejemplo: cat_herramientas

        // Deducir el nombre de la categoría (sin 'cat_', reemplazar '_' por ' ')
        $nombreCategoria = str_replace('_', ' ', ucfirst(str_replace('cat_', '', $tablaCategoria)));

        // 2. Buscar el id_categoria en tbl_categoria usando el nombre
        $sqlCatId = "SELECT id_categoria FROM tbl_categoria WHERE LOWER(nombre_categoria) = LOWER(:nombre_categoria) LIMIT 1";
        $stmtCatId = $this->conex->prepare($sqlCatId);
        $stmtCatId->bindParam(':nombre_categoria', $nombreCategoria);
        $stmtCatId->execute();
        $idCategoria = $stmtCatId->fetchColumn();

        if (!$idCategoria) {
            $this->conex->rollBack();
            throw new Exception("No se encontró la categoría '$nombreCategoria' en la base de datos.");
        }

        // 3. Actualizar producto principal
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
        $stmt->bindParam(':categoria', $idCategoria);
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_min);
        $stmt->bindParam(':stock_maximo', $this->stock_max);
        $stmt->bindParam(':clausula_garantia', $this->clausula_garantia);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->execute();

        // 4. Actualizar o insertar características dinámicas
        if (!empty($tablaCategoria) && !empty($datosCategoria['carac']) && is_array($datosCategoria['carac'])) {
            $caracteristicas = $datosCategoria['carac'];
            $campos = array_keys($caracteristicas);
            $placeholders = array_map(function($k){ return ':' . $k; }, $campos);

            // Verifica si ya existen características para este producto
            $sqlCheck = "SELECT COUNT(*) FROM `$tablaCategoria` WHERE id_producto = :id_producto";
            $stmtCheck = $this->conex->prepare($sqlCheck);
            $stmtCheck->bindParam(':id_producto', $id);
            $stmtCheck->execute();
            $existe = $stmtCheck->fetchColumn() > 0;

            if ($existe) {
                // UPDATE dinámico
                $set = [];
                foreach ($campos as $campo) {
                    $set[] = "`$campo` = :$campo";
                }
                $sqlCat = "UPDATE `$tablaCategoria` SET " . implode(', ', $set) . " WHERE id_producto = :id_producto";
                $stmtCat = $this->conex->prepare($sqlCat);
                $stmtCat->bindParam(':id_producto', $id);
                foreach ($caracteristicas as $campo => $valor) {
                    $stmtCat->bindValue(':' . $campo, $valor);
                }
                if (!$stmtCat->execute()) {
                    $errorInfo = $stmtCat->errorInfo();
                    $this->conex->rollBack();
                    throw new Exception("Error SQL al actualizar características: " . $errorInfo[2]);
                }
            } else {
                // INSERT dinámico
                $sqlCat = "INSERT INTO `$tablaCategoria` (id_producto, " . implode(',', $campos) . ") VALUES (:id_producto, " . implode(',', $placeholders) . ")";
                $stmtCat = $this->conex->prepare($sqlCat);
                $stmtCat->bindParam(':id_producto', $id);
                foreach ($caracteristicas as $campo => $valor) {
                    $stmtCat->bindValue(':' . $campo, $valor);
                }
                if (!$stmtCat->execute()) {
                    $errorInfo = $stmtCat->errorInfo();
                    $this->conex->rollBack();
                    throw new Exception("Error SQL al insertar características: " . $errorInfo[2]);
                }
            }
        }

        $this->conex->commit();
        return true;

    } catch (Exception $e) {
        $this->conex->rollBack();
        throw new Exception('Error al modificar producto: ' . $e->getMessage());
    }
}



public function eliminarProducto($id) {
    try {
        $sql = "DELETE FROM `tbl_productos` WHERE id_producto = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return [
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ];
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            // Código de error para violación de clave foránea
            return [
                'success' => false,
                'message' => 'No se puede eliminar el producto porque tiene registros asociados.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ];
        }
    }
}

    public function obtenerModelos() {
        $query = "SELECT 
    mo.id_modelo AS tbl_modelos,
    mo.nombre_modelo,
    mar.nombre_marca AS tbl_marcas
FROM 
    tbl_modelos mo
JOIN 
    tbl_marcas mar ON mo.id_marca = mar.id_marca;
";
        $stmt = $this->conex->query($query);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errorInfo = $this->conex->errorInfo();
            echo "Debug: Error en el query: " . $errorInfo[2] . "\n";
            return [];
        }
    }

        public function cambiarEstatus($nuevoEstatus) {
        try {
            $sql = "UPDATE tbl_productos SET estado = :estatus WHERE id_producto = :id";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':estatus', $nuevoEstatus);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al cambiar estatus: " . $e->getMessage());
            return false;
        }
    }

    //catalogo
    public function obtenerMarcas() {
    $query = "SELECT id_marca, nombre_marca FROM tbl_marcas";
    $stmt = $this->conex->query($query);

    if ($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $errorInfo = $this->conex->errorInfo();
        echo "Debug: Error en el query: " . $errorInfo[2] . "\n";
        return [];
    }
}

public function obtenerProductosConMarca() {
    $query = "SELECT p.*, m.nombre_marca as marca 
              FROM tbl_productos p
              JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE p.estado = 'habilitado' AND p.stock > 0
              ORDER BY p.nombre_producto ASC";
    
    $stmt = $this->conex->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerProductosPorMarca($id_marca) {
    $query = "SELECT p.*, m.nombre_marca as marca 
              FROM tbl_productos p
              JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE m.id_marca = :id_marca AND p.estado = 'habilitado' AND p.stock > 0
              ORDER BY p.nombre_producto ASC";
    
    $stmt = $this->conex->prepare($query);
    $stmt->bindParam(':id_marca', $id_marca);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerCombosDisponibles($esAdmin = false) {
    $sql = "SELECT * FROM tbl_combo";
    if (!$esAdmin) {
        $sql .= " WHERE activo = 1";
    }else{
        $sql .= " WHERE activo IN (0, 1)";
    }
    $stmt = $this->conex->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerDetallesCombo($id_combo) {
    $query = "SELECT cd.id_producto, cd.cantidad, p.nombre_producto, p.precio, p.stock, 
                     m.nombre_marca as marca, p.descripcion_producto as descripcion
              FROM tbl_combo_detalle cd
              INNER JOIN tbl_productos p ON cd.id_producto = p.id_producto
              INNER JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              INNER JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE cd.id_combo = :id_combo AND p.estado = 'habilitado'";
    
    $stmt = $this->conex->prepare($query);
    $stmt->bindParam(':id_combo', $id_combo);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function agregarProductoAlCarrito($id_cliente, $id_producto, $cantidad = 1, $id_combo = null) {
    try {
        // Verificar stock disponible
        $producto = $this->obtenerProductoPorId($id_producto);
        if (!$producto || $producto['stock'] < $cantidad) {
            throw new Exception('Producto no disponible o cantidad insuficiente');
        }

        // Obtener o crear carrito
        $id_carrito = $this->obtenerOCrearCarrito($id_cliente);

        // Verificar si ya existe en el carrito
        $sql = "SELECT id_carrito_detalle, cantidad FROM tbl_carritodetalle 
                WHERE id_carrito = :id_carrito AND id_producto = :id_producto";
        
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_carrito', $id_carrito);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
        
        $existente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existente) {
            // Actualizar cantidad si ya existe
            $nueva_cantidad = $existente['cantidad'] + $cantidad;
            $sql = "UPDATE tbl_carritodetalle SET cantidad = :cantidad 
                    WHERE id_carrito_detalle = :id_carrito_detalle";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':cantidad', $nueva_cantidad);
            $stmt->bindParam(':id_carrito_detalle', $existente['id_carrito_detalle']);
            return $stmt->execute();
        } else {
            // Insertar nuevo registro
            $sql = "INSERT INTO tbl_carritodetalle 
                    (id_carrito, id_producto, cantidad, estatus) 
                    VALUES (:id_carrito, :id_producto, :cantidad, 'pendiente')";
            
            $stmt = $this->conex->prepare($sql);
            
            $stmt->bindParam(':id_carrito', $id_carrito);
            $stmt->bindParam(':id_producto', $id_producto);
            $stmt->bindParam(':cantidad', $cantidad);
            
            return $stmt->execute();
        }
    } catch (Exception $e) {
        error_log("Error en agregarProductoAlCarrito: " . $e->getMessage());
        return false;
    }
}

private function obtenerOCrearCarrito($id_cliente) {
    $sql = "SELECT id_carrito FROM tbl_carrito 
            WHERE id_cliente = :id_cliente
            ORDER BY fecha_creacion DESC LIMIT 1";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    $carrito = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($carrito) {
        return $carrito['id_carrito'];
    } else {
        $sql = "INSERT INTO tbl_carrito (id_cliente) VALUES (:id_cliente)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $this->conex->lastInsertId();
    }
}

public function agregarComboAlCarrito($id_cliente, $id_combo) {
    $this->conex->beginTransaction();
    
    try {
        // 1. Verificar que el combo existe
        $combo = $this->obtenerComboPorId($id_combo);
        if (!$combo) {
            throw new Exception("El combo no está disponible");
        }

        // 2. Obtener los productos del combo con sus cantidades
        $productosCombo = $this->obtenerDetallesCombo($id_combo);
        if (empty($productosCombo)) {
            throw new Exception("El combo no contiene productos válidos");
        }

        // 3. Verificar stock para todos los productos del combo
        foreach ($productosCombo as $producto) {
            $productoInfo = $this->obtenerProductoPorId($producto['id_producto']);
            if (!$productoInfo || $productoInfo['stock'] < $producto['cantidad']) {
                throw new Exception("El producto {$productoInfo['nombre_producto']} no tiene suficiente stock");
            }
        }

        // 4. Obtener o crear carrito
        $id_carrito = $this->obtenerOCrearCarrito($id_cliente);

        // 5. Agregar cada producto del combo al carrito
        foreach ($productosCombo as $producto) {
            $this->agregarProductoAlCarrito($id_cliente, $producto['id_producto'], $producto['cantidad']);
        }
        
        $this->conex->commit();
        return true;
        
    } catch (Exception $e) {
        $this->conex->rollBack();
        error_log("Error en agregarComboAlCarrito: " . $e->getMessage());
        throw $e;
    }
}

public function obtenerComboPorId($id_combo) {
    $sql = "SELECT * FROM tbl_combo WHERE id_combo = :id_combo";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_combo', $id_combo);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function obtenerTodosProductosParaCombos() {
    $query = "SELECT p.id_producto, p.nombre_producto, p.stock, m.nombre_marca as marca, p.precio
              FROM tbl_productos p
              JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE p.estado = 'habilitado'
              ORDER BY p.nombre_producto ASC";
    
    $stmt = $this->conex->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerProductosBajoStock() {
    $query = "SELECT p.id_producto, p.nombre_producto, p.stock, p.stock_minimo, 
                     m.nombre_marca as marca
              FROM tbl_productos p
              JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE p.stock <= p.stock_minimo AND p.estado = 'habilitado'
              ORDER BY (p.stock / p.stock_minimo) ASC";
    
    $stmt = $this->conex->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function buscarProductos($termino) {
    $query = "SELECT p.*, m.nombre_marca as marca 
              FROM tbl_productos p
              JOIN tbl_modelos mo ON p.id_modelo = mo.id_modelo
              JOIN tbl_marcas m ON mo.id_marca = m.id_marca
              WHERE (p.nombre_producto LIKE :termino OR 
                    p.descripcion_producto LIKE :termino OR
                    p.serial LIKE :termino OR
                    m.nombre_marca LIKE :termino)
              AND p.estado = 'habilitado'
              ORDER BY p.nombre_producto ASC";
    
    $stmt = $this->conex->prepare($query);
    $termino = "%$termino%";
    $stmt->bindParam(':termino', $termino);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function actualizarStock($id_producto, $cantidad) {
    $sql = "UPDATE tbl_productos SET stock = stock + :cantidad 
            WHERE id_producto = :id_producto";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':id_producto', $id_producto);
    return $stmt->execute();
}
private function agregarProductoACombo($id_combo, $id_producto, $cantidad) {
    // Verificar que el producto existe
    $producto = $this->obtenerProductoPorId($id_producto);
    if (!$producto) {
        throw new Exception("El producto con ID $id_producto no existe");
    }
    
    $sql = "INSERT INTO tbl_combo_detalle (id_combo, id_producto, cantidad) 
            VALUES (:id_combo, :id_producto, :cantidad)";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_combo', $id_combo);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->bindParam(':cantidad', $cantidad);
    return $stmt->execute();
}

public function crearCombo($nombre, $descripcion, $productos) {
    $this->conex->beginTransaction();
    
    try {
        // Insertar el combo principal
        $sql = "INSERT INTO tbl_combo (nombre_combo, descripcion) 
                VALUES (:nombre, :descripcion)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
        
        $id_combo = $this->conex->lastInsertId();
        
        // Insertar los productos del combo
        foreach ($productos as $producto) {
            $this->agregarProductoACombo($id_combo, $producto['id'], $producto['cantidad']);
        }
        
        $this->conex->commit();
        return $id_combo;
    } catch (Exception $e) {
        $this->conex->rollBack();
        throw $e;
    }
}

public function actualizarCombo($id_combo, $nombre, $descripcion, $productos) {
    $this->conex->beginTransaction();
    
    try {
        // Actualizar el combo principal
        $sql = "UPDATE tbl_combo 
                SET nombre_combo = :nombre, 
                    descripcion = :descripcion
                WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id_combo', $id_combo);
        $stmt->execute();
        
        // Eliminar los productos actuales del combo
        $sql = "DELETE FROM tbl_combo_detalle WHERE id_combo = :id_combo";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_combo', $id_combo);
        $stmt->execute();
        
        // Insertar los nuevos productos del combo
        foreach ($productos as $producto) {
            $this->agregarProductoACombo($id_combo, $producto['id'], $producto['cantidad']);
        }
        
        $this->conex->commit();
        return true;
    } catch (Exception $e) {
        $this->conex->rollBack();
        throw $e;
    }
}

public function eliminarCombo($id_combo) {
    // Opción 1: Eliminación física (elimina también los detalles por CASCADE)
    // $sql = "DELETE FROM tbl_combo WHERE id_combo = :id_combo";
    
    // Opción 2: Eliminación lógica (recomendado)
    $sql = "UPDATE tbl_combo SET activo = 0 WHERE id_combo = :id_combo";
    
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_combo', $id_combo);
    return $stmt->execute();
}

public function obtenerInfoCompletaCombo($id_combo) {
    $combo = $this->obtenerComboPorId($id_combo);
    if (!$combo) {
        return null;
    }
    
    $combo['productos'] = $this->obtenerDetallesCombo($id_combo);
    
    // Calcular precio total del combo
    $combo['precio_total'] = 0;
    foreach ($combo['productos'] as $producto) {
        $combo['precio_total'] += ($producto['precio'] * $producto['cantidad']);
    }
    
    // Calcular ahorro estimado (10% del total)
    $combo['ahorro_estimado'] = $combo['precio_total'] * 0.1;
    $combo['precio_final'] = $combo['precio_total'] - $combo['ahorro_estimado'];
    
    return $combo;
}

public function obtenerTodosCombosConDetalles() {
    $combos = $this->obtenerCombosDisponibles();
    
    foreach ($combos as &$combo) {
        $combo['productos'] = $this->obtenerDetallesCombo($combo['id_combo']);
        
        // Calcular información adicional
        $combo['total_productos'] = count($combo['productos']);
        $combo['precio_total'] = 0;
        
        foreach ($combo['productos'] as $producto) {
            $combo['precio_total'] += ($producto['precio'] * $producto['cantidad']);
        }
        
        $combo['ahorro_estimado'] = $combo['precio_total'] * 0.1;
        $combo['precio_final'] = $combo['precio_total'] - $combo['ahorro_estimado'];
    }
    
    return $combos;
}

public function obtenerCantidadCarrito($id_cliente) {
    $sql = "SELECT SUM(cd.cantidad) as total 
            FROM tbl_carritodetalle cd
            JOIN tbl_carrito c ON cd.id_carrito = c.id_carrito
            WHERE c.id_cliente = :id_cliente AND cd.estatus = 'pendiente'";
    
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

public function verificarStock($id_producto, $cantidad) {
    $sql = "SELECT stock FROM tbl_productos WHERE id_producto = :id_producto AND estado = 'habilitado'";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($producto && $producto['stock'] >= $cantidad);
}

public function cambiarEstadoCombo($id_combo) {
    // Verificar que el combo existe
    $combo = $this->obtenerComboPorId($id_combo);
    if (!$combo) {
        throw new Exception('Combo no encontrado');
    }
    
    // Determinar el nuevo estado (alternar entre 1 y 0)
    $nuevoEstado = $combo['activo'] ? 0 : 1;
    
    // Preparar y ejecutar la consulta
    $sql = "UPDATE tbl_combo SET activo = :activo WHERE id_combo = :id_combo";
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(':activo', $nuevoEstado, PDO::PARAM_INT);
    $stmt->bindParam(':id_combo', $id_combo, PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar el estado del combo');
    }
    
    return true;
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
    // 1. Consulta general con modelo y categoría
    $queryProductos = '
SELECT 
    tbl_productos.*, 
    tbl_modelos.nombre_modelo, 
    tbl_categoria.nombre_categoria 
FROM tbl_productos 
INNER JOIN tbl_modelos 
    ON tbl_productos.id_modelo = tbl_modelos.id_modelo 
INNER JOIN tbl_categoria 
    ON tbl_productos.id_categoria = tbl_categoria.id_categoria
ORDER BY tbl_productos.id_producto ASC;
';

    $stmtProductos = $this->conex->prepare($queryProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    // 2. Agregar características específicas por categoría
    foreach ($productos as &$producto) {
        $idProducto = $producto['id_producto'];
        $categoria = strtolower($producto['nombre_categoria']); // debe ser como se llama la tabla

        switch ($categoria) {
            case 'impresora':
                $sql = "SELECT * FROM tbl_impresoras WHERE id_producto = :id";
                break;
            case 'protector de voltaje':
                $sql = "SELECT * FROM tbl_protector_voltaje WHERE id_producto = :id";
                break;
            case 'tinta':
                $sql = "SELECT * FROM tbl_tintas WHERE id_producto = :id";
                break;
            case 'cartucho':
                $sql = "SELECT * FROM tbl_cartucho_tinta WHERE id_producto = :id";
                break;
            case 'otros':
                $sql = "SELECT * FROM tbl_otros WHERE id_producto = :id";
                break;
            default:
                $sql = null;
                break;
        }

        if ($sql) {
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':id', $idProducto, PDO::PARAM_INT);
            $stmt->execute();
            $caracteristicas = $stmt->fetch(PDO::FETCH_ASSOC);
            $producto['caracteristicas'] = $caracteristicas ?: [];
        } else {
            $producto['caracteristicas'] = [];
        }
    }

    return $productos;
}


    public function obtenerProductosConBajoStock() {
    $queryProductos = '
        SELECT tbl_productos.*, 
               tbl_modelos.nombre_modelo, 
               tbl_categoria.nombre_categoria 
        FROM tbl_productos 
        INNER JOIN tbl_modelos 
            ON tbl_productos.id_modelo = tbl_modelos.id_modelo 
        INNER JOIN tbl_categoria 
            ON tbl_productos.id_categoria = tbl_categoria.id_categoria
        WHERE tbl_productos.stock < tbl_productos.stock_minimo
    ';

    $stmtProductos = $this->conex->prepare($queryProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    return $productos;
}

}