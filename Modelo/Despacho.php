<?php

require_once 'Config/config.php';

class Despacho extends BD
{   
    private $tabledespacho ='tbl_despachos';
    private $id_despacho;
    private $id_clientes;
    private $fecha_despacho;
    private $correlativo;

    public function __construct() {
    parent::__construct('P');
    $this->db = $this->getConexion();
}
    public function setIdDespacho($id_despacho)
    {
        $this->id_despacho = $id_despacho;
    }
    public function getIdDespacho()
    {
        return $this->id_despacho;
    }
    public function setIdClientes($id_clientes)
    {
        $this->id_clientes = $id_clientes;
    }
    public function getIdClientes()
    {
        return $this->id_clientes;
    }
    public function setFechaDespacho($fecha_despacho)
    {
        $this->fecha_despacho = $fecha_despacho;
    }
    public function getFechaDespacho()
    {
        return $this->fecha_despacho;
    }
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;
    }
    public function getCorrelativo()
    {
        return $this->correlativo;
    }



    

    function registrar($id_clientes, $id_producto,$cantidad, $correlativo)
    {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {
           
            $fecha = date('Y-m-d H:i:s');
            $exist = $co->query("SELECT id_producto, stock FROM tbl_productos ");
            $stock = [];

            while ($row = $exist->fetch(PDO::FETCH_ASSOC)
            ) {
                $stock[$row['id_producto']] = [
                    'cantidad' => $row['stock'],
                ];
            }

            for ($i = 0; $i < count($id_producto); $i++) {
                $idProd = $id_producto[$i];
                $cantidadActual = isset($stock[$idProd]['cantidad']) ? $stock[$idProd]['cantidad'] : 0;
                $Total = $cantidadActual - $cantidad[$i];
                $co->query("UPDATE tbl_productos SET stock = $Total WHERE id_producto = $idProd");
            }
            
                $guarda = $co->query("INSERT INTO tbl_despachos(id_clientes,fecha_despacho ,correlativo)
                values ('$id_clientes',' $fecha','$correlativo')");
                $lid = $co->lastInsertId();
            
          

            $tamano = count($id_producto);

            for ($i = 0; $i < $tamano; $i++) {
                $gd = $co->query("INSERT INTO `tbl_detalle_despachos`
			   (id_producto,cantidad, id_despachos)
			   values(
              '$id_producto[$i]',
               '$cantidad[$i]',
                '$lid'
               )");
            }
           

            $r['resultado'] = 'registrar';
            $r['mensaje'] =  "Se registro correctamente";
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] =  $e->getMessage();
        }
        return $r;
    }


    function listadoproductos()
    {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {

            $resultado = $co->query("SELECT * FROM tbl_productos");

            if ($resultado) {

                $respuesta = '';
                foreach ($resultado as $r) {
                    $respuesta = $respuesta . "<tr style='cursor:pointer' onclick='colocaproducto(this);'>";
                    $respuesta = $respuesta . "<td style='display:none'>";
                    $respuesta = $respuesta . $r['id_producto'];
                    $respuesta = $respuesta . "</td>";
                    $respuesta = $respuesta . "<td>";
                    $respuesta = $respuesta . $r['nombre_producto'];
                    $respuesta = $respuesta . "</td>";
                    $respuesta = $respuesta . "<td>";
                    $respuesta = $respuesta . $r['stock'];
                    $respuesta = $respuesta . "</td>";
                    $respuesta = $respuesta . "</tr>";
                }
            }
            $r['resultado'] = 'listadoproductos';
            $r['mensaje'] =  $respuesta;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] =  $e->getMessage();
        }

        return $r;
    }

    public function obtenerfactura()
    {
        $co = $this->getConexion();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p = $co->prepare("SELECT f.id_factura, c.nombre , c.id_clientes, f.fecha, f.estatus
        FROM tbl_facturas AS f
        INNER JOIN tbl_clientes AS c ON c.id_clientes = f.cliente; ");
        $p->execute();
        $r = $p->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
	function consultarproductos() {
    $sql = "SELECT p.id_producto, p.nombre_producto, m.nombre_modelo, mar.nombre_marca, p.serial
            FROM tbl_productos AS p 
            INNER JOIN tbl_modelos AS m ON p.id_modelo = m.id_modelo 
            INNER JOIN tbl_marcas AS mar ON m.id_marca = mar.id_marca;";
    $conexion = $this->getConexion()->prepare($sql);
    $conexion->execute();
    $registros = $conexion->fetchAll(PDO::FETCH_ASSOC);
    return $registros;
    }
    public function getdespacho() {

        $querydespachos = 'SELECT d.id_despachos, d.correlativo, d.fecha_despacho,
         c.id_clientes, c.nombre, c.cedula 
        FROM tbl_despachos AS d 
        INNER JOIN tbl_facturas AS f ON d.id_despachos = f.id_factura 
        INNER JOIN tbl_clientes AS c ON f.cliente = c.id_clientes;
        ';
        
        // Punto de depuración: Query de marcas preparada
        //echo "Query de marcas preparada: " . $querymarcas . "<br>";
        
        
        $stmtdespachos = $this->getConexion()->prepare($querydespachos);
        $stmtdespachos->execute();
        $despachos = $stmtdespachos->fetchAll(PDO::FETCH_ASSOC);

        return $despachos;
    }
}
