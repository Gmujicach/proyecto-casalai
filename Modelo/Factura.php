<?php
require_once 'config.php';

class Factura extends BD
{
    private $id;
    private $fecha;
    private $cliente;
    private $descuento;
    private $estatus;
    private $id_producto;
    private $cantidad;
    private $conex;

    // Constructor
    function __construct() {
        parent::__construct();
        $this->conex = parent::conexion();
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getCliente() { return $this->cliente; }
    public function setCliente($cliente) { $this->cliente = $cliente; }

    public function getDescuento() { return $this->descuento; }
    public function setDescuento($descuento) { $this->descuento = $descuento; }

    public function getEstatus() { return $this->estatus; }
    public function setEstatus($estatus) { $this->estatus = $estatus; }

    public function getIdProducto() { return $this->id_producto; }
    public function setIdProducto($id_producto) { $this->id_producto = $id_producto; }

    public function getCantidad() { return $this->cantidad; }
    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }

    // Transacciones
    public function facturaTransaccion($transaccion) {
        switch ($transaccion) {
            case 'Ingresar':
                return $this->facturaIngresar();                 
            case 'Consultar':
                return $this->facturaConsultar($this->id);
            case 'Cancelar':
                return $this->facturaCancelar($this->id);
            case 'Procesar':
                return $this->facturaProcesar($this->id);
            default:
                throw new Exception("Transacción no válida.");
        }
    }

    // Crear factura
    private function facturaIngresar() {
        $pdo = $this->conex;
        try {
            $pdo->beginTransaction();

            // Insertar en tabla factura
            $stmt = $pdo->prepare("INSERT INTO tbl_facturas (fecha, cliente, descuento, estatus) VALUES (?, ?, ?, ?)");
            $stmt->execute([$this->fecha, $this->cliente, $this->descuento, $this->estatus]);

            $factura_id = $pdo->lastInsertId();

            // Insertar en factura_detalle
            $stmt2 = $pdo->prepare("INSERT INTO tbl_factura_detalle (factura_id, id_producto, cantidad) VALUES (?, ?, ?)");
            $stmt2->execute([$factura_id, $this->id_producto, $this->cantidad]);

            $pdo->commit();
            return $factura_id;
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Obtener factura
    public function facturaConsultar($id_factura) {
       

        $sqlDetalles = "SELECT f.id_factura, f.fecha, c.nombre, c.cedula, c.telefono, c.direccion,
            p.nombre_producto AS producto, m.nombre_modelo, mar.nombre_marca,
            p.precio, df.cantidad, f.descuento, f.estatus
        FROM tbl_factura_detalle df
        JOIN tbl_facturas f ON f.id_factura = df.factura_id
        JOIN tbl_clientes c ON c.id_clientes = f.cliente
        JOIN tbl_productos p ON df.id_producto = p.id_producto
        JOIN tbl_modelos m ON m.id_modelo = p.id_modelo
        JOIN tbl_marcas mar ON mar.id_marca = m.id_marca
        WHERE f.id_factura = ?";

        $stmt = $this->conex->prepare($sqlDetalles);
        $stmt->execute([$id_factura]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$detalles) return ['resultado' => 'error', 'mensaje' => 'Factura no encontrada.'];

        $html = '<div class="accordion" id="accordionFacturas">';

        $fila = $detalles[0];
        $contenido = '<div><p><strong>Cliente:</strong> ' . htmlspecialchars($fila['nombre']) . '</p>';
        $contenido .= '<p><strong>Cédula:</strong> ' . htmlspecialchars($fila['cedula']) . '</p>';
        $contenido .= '<p><strong>Teléfono:</strong> ' . htmlspecialchars($fila['telefono']) . '</p>';
        $contenido .= '<p><strong>Dirección:</strong> ' . htmlspecialchars($fila['direccion']) . '</p>';
        $contenido .= '<p><strong>Descuento:</strong> ' . htmlspecialchars($fila['descuento']) . '%</p>';
        $contenido .= '<p><strong>Estatus:</strong> ' . htmlspecialchars($fila['estatus']) . '</p></div>';

        $contenido .= '<table><thead><tr><th>Producto</th><th>Modelo</th><th>Marca</th><th>Cantidad</th><th>Precio</th></tr></thead><tbody>';

        $total = 0;
        foreach ($detalles as $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            $contenido .= '<tr><td>' . htmlspecialchars($item['producto']) . '</td>';
            $contenido .= '<td>' . htmlspecialchars($item['nombre_modelo']) . '</td>';
            $contenido .= '<td>' . htmlspecialchars($item['nombre_marca']) . '</td>';
            $contenido .= '<td>' . $item['cantidad'] . '</td>';
            $contenido .= '<td>' . number_format($item['precio'], 2) . '</td></tr>';
        }

        $montoTotal = $total + ($total * 0.16) - ($total * $fila['descuento'] / 100);

        $contenido .= '<tr><td colspan="4">Total con Impuestos:</td><td>' . number_format($montoTotal, 2) . '</td></tr>';
        $contenido .= '</tbody></table>';

        $html .= '<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $id_factura . '">Factura #' . $id_factura . ' - Fecha: ' . $fila['fecha'] . '</button></h2>';
        $html .= '<div id="collapse' . $id_factura . '" class="accordion-collapse collapse"><div class="accordion-body">' . $contenido . '</div></div></div>';

        $html .= '</div>';

        return [
            'resultado' => 'listado',
            'mensaje' => $html
        ];
    }

    // Marcar factura como Cancelada
    public function facturaCancelar($id) {
        $stmt = $this->conex->prepare("UPDATE tbl_facturas SET estatus = 'Cancelada' WHERE id_factura = ?");
        return $stmt->execute([$id]);
    }

    // Marcar factura como Procesada
    public function facturaProcesar($id) {
        $pdo = $this->conex;
        $stmt = $pdo->prepare("UPDATE tbl_facturas SET estatus = 'Procesada' WHERE id_factura = ?");
        return $stmt->execute([$id]);
    }
}




/* class Productos {
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

    public function ingresarFactura($cliente, $fecha_hora, $productos, $subtotal) {
        try {
            // Iniciar transacción
            $this->conex->beginTransaction();
    
            // Insertar en la tabla 'facturas'
            $sql = "INSERT INTO facturas (cliente, fecha) VALUES (:cliente, :fecha_hora)";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':cliente', $cliente);
            $stmt->bindParam(':fecha_hora', $fecha_hora);
            $stmt->execute();
    
            // Obtener el ID de la venta recién insertada
            $id_venta = $this->conex->lastInsertId();
    
            // Insertar productos en la tabla 'factura_detalle'
            $sqlDetalle = "INSERT INTO factura_detalle (factura_id, id_producto, cantidad, subtotal) 
                           VALUES (:id_venta, :id_producto, :cantidad, :precio)";
            $stmtDetalle = $this->conex->prepare($sqlDetalle);
    
            // Preparar consulta para actualizar la cantidad en 'tbl_productos'
            $sqlUpdateStock = "UPDATE tbl_productos SET stock = stock - :cantidad WHERE id_producto = :id_producto AND stock >= :cantidad";
            $stmtUpdateStock = $this->conex->prepare($sqlUpdateStock);
    
            foreach ($productos as $producto) {
                // Verificar si el producto tiene los datos necesarios
                if (!isset($producto["id_producto"], $producto["cantidad"], $producto["precio"])) {
                    throw new Exception("Datos incompletos en el producto.");
                }
    
                // Calcular subtotal del producto (precio unitario * cantidad)
                $subtotal_producto = $subtotal;
    
                // Insertar detalle de la factura
                $stmtDetalle->execute([
                    ":id_venta" => $id_venta,
                    ":id_producto" => $producto["id_producto"],
                    ":cantidad" => $producto["cantidad"],
                    ":precio" => $subtotal_producto // Se usa el subtotal de cada producto
                ]);
    
                // Actualizar el stock del producto
                $stmtUpdateStock->execute([
                    ":id_producto" => $producto["id_producto"],
                    ":cantidad" => $producto["cantidad"]
                ]);
    
                // Verificar si se afectó alguna fila (para asegurarse de que hay suficiente stock)
                if ($stmtUpdateStock->rowCount() === 0) {
                    throw new Exception("Stock insuficiente para el producto ID " . $producto["id_producto"]);
                }
            }
    
            // Confirmar la transacción
            $this->conex->commit();
            return "Factura insertada correctamente con ID: $id_venta";
    
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conex->rollBack();
            return "Error al insertar la factura: " . $e->getMessage();
        }
    }
    
    function consultarFactura($id){
        try {
            // Iniciar transacción
            $this->conex->beginTransaction();
    
            // Insertar en la tabla 'ventas'
            $sql = "SELECT f.id AS facturas, f.fecha, f.cliente,
            c.nombre as tbl_clientes,c.rif, c.direccion,c.telefono, c.telefono_secundario,
            p.nombre_p AS tbl_producto,
             m.descripcion_mo as tbl_modelos,
              mar.descripcion_ma as tbl_marcas , fd.cantidad, p.precio, fd.subtotal 
              FROM factura_detalle fd 
              JOIN facturas f ON fd.factura_id = f.id 
              JOIN tbl_productos p ON fd.id_producto = p.id_producto 
              JOIN tbl_clientes c on f.cliente = c.id_clientes 
              JOIN tbl_modelos m on p.id_modelo = m.id_modelo 
              JOIN tbl_marcas mar on m.id_marca = mar.id_marca 
              WHERE f.id = :id";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Confirmar la transacción
            $this->conex->commit();
    
            return $res;
    
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conex->rollBack();
            return "Error al insertar la factura: " . $e->getMessage();
        }

        

    }

    // Método para consultar la última factura registrada sin filtro por cliente
// Método para consultar la última factura registrada sin filtro por cliente
public function consultarFacturaReciente() {
    try {
        // Iniciar transacción
        $this->conex->beginTransaction();

        // Consulta SQL para obtener la última factura registrada
        $query = "SELECT 
    f.id AS facturas, 
    f.fecha, 
    f.cliente, 
    c.nombre AS tbl_clientes, 
    c.rif, 
    c.direccion, 
    c.telefono, 
    c.telefono_secundario, 
    p.nombre_p AS tbl_producto, 
    m.descripcion_mo AS tbl_modelos, 
    mar.descripcion_ma AS tbl_marcas, 
    fd.cantidad, 
    p.precio, 
    fd.subtotal 
FROM factura_detalle fd
JOIN facturas f ON fd.factura_id = f.id
JOIN tbl_productos p ON fd.id_producto = p.id_producto
JOIN tbl_clientes c ON f.cliente = c.id_clientes
JOIN tbl_modelos m ON p.id_modelo = m.id_modelo
JOIN tbl_marcas mar ON m.id_marca = mar.id_marca
WHERE f.id = (SELECT MAX(id) FROM facturas)
ORDER BY f.id DESC;
";
        
        $stmt = $this->conex->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Confirmar la transacción
        $this->conex->commit();

        return $res;

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $this->conex->rollBack();
        return "Error al consultar la factura: " . $e->getMessage();
    }
}



    function listadoproductos() {
        try {
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Consulta SQL corregida y optimizada
            $sql = "SELECT p.id_producto, p.nombre_p, m.descripcion_mo AS tbl_modelos, 
                           mar.descripcion_ma AS tbl_marcas, p.stock, p.precio 
                    FROM tbl_productos AS p 
                    JOIN tbl_modelos AS m ON p.id_modelo = m.id_modelo 
                    JOIN tbl_marcas AS mar ON m.id_marca = mar.id_marca";
    
            $stmt = $this->conex->query($sql);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $respuesta = '';
    
            foreach ($productos as $producto) {
                $respuesta .= "<tr style='cursor:pointer' onclick='colocaproducto(this);'>";
                $respuesta .= "<td style='display:none'>" . htmlspecialchars($producto['id_producto']) . "</td>";
                $respuesta .= "<td>" . htmlspecialchars($producto['nombre_p']) . "</td>";
                $respuesta .= "<td>" . htmlspecialchars($producto['tbl_modelos']) . "</td>";
                $respuesta .= "<td>" . htmlspecialchars($producto['tbl_marcas']) . "</td>";
                $respuesta .= "<td>" . htmlspecialchars($producto['stock']) . "</td>";
                $respuesta .= "<td>" . number_format($producto['precio'], 2) . " $</td>";
                $respuesta .= "</tr>";
            }
    
            return [
                'resultado' => 'listadoproductos',
                'mensaje' => $respuesta
            ];
            
        } catch (Exception $e) {
            return [
                'resultado' => 'error',
                'mensaje' => $e->getMessage()
            ];
        }
    }

    function listadoprefacturas() {
        try {
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Consulta SQL corregida y optimizada
            $sql = "SELECT * FROM `facturas`";
    
            $stmt = $this->conex->query($sql);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $respuesta = '';

foreach ($productos as $producto) {
    $facturaId = htmlspecialchars($producto['id']);
    
    // Contenedor del acordeón para cada factura
    $respuesta .= "

    

        <div class='accordion' id='accordionExample'>
            <!-- Factura 1 -->
            <div class='accordion-item'>
                <h2 class='accordion-header' id='heading".htmlspecialchars($producto['id'])."'>
                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse".htmlspecialchars($producto['id'])."' aria-expanded='false' aria-controls='collapse".htmlspecialchars($producto['id'])."'>
                        Codigo de la Factura: ".htmlspecialchars($producto['id'])." - 2025-03-29 - Cliente: Juan Pérez
                    </button>
                </h2>
                <div id='collapse".htmlspecialchars($producto['id'])."' class='accordion-collapse collapse' aria-labelledby='heading".htmlspecialchars($producto['id'])."' data-bs-parent='#accordi".htmlspecialchars($producto['id'])."xample'>
                    <div class='accordion-body'>
                        <div class='table-responsive'>
                            <table class='table table-striped table-bordered'>
                                <thead class='table-dark'>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2025-03-29</td>
                                        <td>Juan Pérez</td>
                                        <td>Pendiente</td>
                                        <td>
                                            <button class='btn btn-danger btn-sm'><i class='fas fa-ban'></i> Cancelar</button>
                                            <button class='btn btn-success btn-sm'><i class='fas fa-money-bill-wave'></i> Pagar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <!-- Bootstrap JS -->
    <script src='Public/bootstrap/js/bootstrap.bundle.min.js'></script>";

}

    
            return [
                'resultado' => 'listadoproductos',
                'mensaje' => $respuesta
            ];
            
        } catch (Exception $e) {
            return [
                'resultado' => 'error',
                'mensaje' => $e->getMessage()
            ];
        }
    }

    public function getdespacho() {
        // Punto de depuración: Iniciando getmarcas
        //echo "Iniciando getmarcas.<br>";
        
        // Primera consulta para obtener datos de marcas
        $querydespachos = 'SELECT * FROM tbl_productos';
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        $stmtdespachos = $this->conex->prepare($querydespachos);
        $stmtdespachos->execute();
        $despachos = $stmtdespachos->fetchAll(PDO::FETCH_ASSOC);

        return $despachos;
    }
    public function obtenercliente()
    {

        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p = $this->conex->prepare("SELECT id_clientes, nombre FROM tbl_clientes ");
        $p->execute();
        $r = $p->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
}
;
*/
?>


    
  