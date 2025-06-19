<?php
require_once 'Config/config.php';

class Categoria extends BD {
    private $id_categoria;
    private $nombre_categoria;
    private $conex;

    public function __construct() {
        $conexion = new BD('P');
        $this->conex = $conexion->getConexion();
    }

    public function getIdCategoria() { return $this->id_categoria; }
    public function setIdCategoria($id_categoria) { $this->id_categoria = $id_categoria; }

    public function getNombreCategoria() { return $this->nombre_categoria; }
    public function setNombreCategoria($nombre_categoria) { $this->nombre_categoria = $nombre_categoria; }

    private function generarNombreTabla() {
        return 'cat_' . strtolower(str_replace(' ', '_', $this->nombre_categoria));
    }

    public function registrarCategoria($caracteristicas) {
        $resultado = $this->r_Categoria();
        if ($resultado) {
            return $this->crearTablaCategoria($caracteristicas);
        }
        return false;
    }

    private function r_Categoria() {
        $sql = "INSERT INTO tbl_categoria (nombre_categoria) VALUES (:nombre_categoria)";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':nombre_categoria', $this->nombre_categoria);
        return $stmt->execute();
    }

    private function crearTablaCategoria($caracteristicas) {
        $nombreTabla = $this->generarNombreTabla();
        $sql = "CREATE TABLE IF NOT EXISTS `$nombreTabla` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_producto INT NOT NULL,";

        foreach ($caracteristicas as $carac) {
            $campo = strtolower(str_replace(' ', '_', $carac['nombre']));
            switch ($carac['tipo']) {
                case 'int':
                    $sql .= "`$campo` INT,";
                    break;
                case 'float':
                    $sql .= "`$campo` FLOAT,";
                    break;
                case 'string':
                    $max = (int)($carac['max'] ?? 255);
                    $sql .= "`$campo` VARCHAR($max),";
                    break;
            }
        }
        $sql = rtrim($sql, ',') . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        return $this->conex->exec($sql) !== false;
    }

    public function modificarCategoria($id_categoria, $nuevo_nombre, $caracteristicas) {
        $tablaAntigua = $this->generarNombreTabla();
        $this->nombre_categoria = $nuevo_nombre;
        $tablaNueva = $this->generarNombreTabla();

        $this->m_categoria($id_categoria);

        if ($tablaAntigua !== $tablaNueva) {
            $this->conex->exec("RENAME TABLE `$tablaAntigua` TO `$tablaNueva`");
        }

        $cols = $this->conex->query("SHOW COLUMNS FROM `$tablaNueva`")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($cols as $col) {
            if (!in_array($col, ['id', 'id_producto'])) {
                $this->conex->exec("ALTER TABLE `$tablaNueva` DROP COLUMN `$col`");
            }
        }

        foreach ($caracteristicas as $carac) {
            $campo = strtolower(str_replace(' ', '_', $carac['nombre']));
            switch ($carac['tipo']) {
                case 'int':
                    $this->conex->exec("ALTER TABLE `$tablaNueva` ADD `$campo` INT");
                    break;
                case 'float':
                    $this->conex->exec("ALTER TABLE `$tablaNueva` ADD `$campo` FLOAT");
                    break;
                case 'string':
                    $max = (int)($carac['max'] ?? 255);
                    $this->conex->exec("ALTER TABLE `$tablaNueva` ADD `$campo` VARCHAR($max)");
                    break;
            }
        }
        return true;
    }

    private function m_categoria($id_categoria) {
        $sql = "UPDATE tbl_categoria SET nombre_categoria = :nombre_categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':nombre_categoria', $this->nombre_categoria);
        return $stmt->execute();
    }

    public function eliminarCategoria($id_categoria) {
        $nombreActual = $this->obtenerCategoriaPorId($id_categoria)['nombre_categoria'];
        $this->nombre_categoria = $nombreActual;
        $tabla = $this->generarNombreTabla();

        $count = $this->conex->query("SELECT COUNT(*) FROM `$tabla`")->fetchColumn();
        if ($count > 0) {
            return ['status' => 'error', 'mensaje' => 'No se puede eliminar la categoría porque hay productos registrados.'];
        }

        $this->conex->exec("DROP TABLE `$tabla`");
        $sql = "DELETE FROM tbl_categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->execute();

        return ['status' => 'ok'];
    }

    public function existeNombreCategoria($nombre_categoria, $excluir_id = null) {
        $sql = "SELECT COUNT(*) FROM tbl_categoria WHERE nombre_categoria = ?";
        $params = [$nombre_categoria];
        if ($excluir_id !== null) {
            $sql .= " AND id_categoria != ?";
            $params[] = $excluir_id;
        }
        $stmt = $this->conex->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerUltimoCategoria() {
        $sql = "SELECT * FROM tbl_categoria ORDER BY id_categoria DESC LIMIT 1";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


public function obtenerCategoriaPorId($id_categoria) {
    $sql = "SELECT id_categoria, nombre_categoria FROM tbl_categoria WHERE id_categoria = :id_categoria";
    $stmt = $this->conex->prepare($sql);
    $stmt->execute([$id_categoria]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener características de la tabla dinámica
    $this->nombre_categoria = $categoria['nombre_categoria'];
    $tabla = $this->generarNombreTabla();
    $caracteristicas = [];
    $cols = $this->conex->query("SHOW COLUMNS FROM `$tabla`")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $col) {
        if (!in_array($col['Field'], ['id', 'id_producto'])) {
            $tipo = 'string';
            if (strpos($col['Type'], 'int') !== false) $tipo = 'int';
            elseif (strpos($col['Type'], 'float') !== false) $tipo = 'float';
            $max = 255;
            if (preg_match('/varchar\((\d+)\)/i', $col['Type'], $m)) $max = $m[1];
            $caracteristicas[] = [
                'nombre' => str_replace('_', ' ', ucfirst($col['Field'])),
                'tipo' => $tipo,
                'max' => $max
            ];
        }
    }
    $categoria['caracteristicas'] = $caracteristicas;
    return $categoria;
}

    public function consultarCategorias() {
        $sql = "SELECT id_categoria, nombre_categoria FROM tbl_categoria";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
