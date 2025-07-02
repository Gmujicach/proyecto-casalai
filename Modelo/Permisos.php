<?php

require_once __DIR__ . '/../Config/Config.php';

class Permisos extends BD {
    private $conex;
    
    public function __construct() {
        $db = new BD('S');
        $this->conex = $db->getConexion();
    }

    public function getRoles() {
        $stmt = $this->conex->query("SELECT id_rol, nombre_rol FROM tbl_rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getModulos() {
        $stmt = $this->conex->query("SELECT id_modulo, nombre_modulo FROM tbl_modulos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getPermisosPorRolModulo() {
    $stmt = $this->conex->query("SELECT id_rol, id_modulo, accion, estatus FROM tbl_permisos");
    $permisos = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if ($row['estatus'] === 'Permitido') {
            $permisos[$row['id_rol']][$row['id_modulo']][$row['accion']] = true;
        }
    }
    return $permisos;
}

public function guardarPermisos($permisosForm, $roles, $modulos, $acciones) {
    // Borra todos los permisos actuales
    $this->conex->exec("DELETE FROM tbl_permisos");
    // Inserta todos los permisos posibles
    foreach ($roles as $rol) {
        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                $estatus = (isset($permisosForm[$rol['id_rol']][$modulo['id_modulo']][$accion]) && $permisosForm[$rol['id_rol']][$modulo['id_modulo']][$accion] == 'on')
                    ? 'Permitido' : 'No Permitido';
                $stmt = $this->conex->prepare("INSERT INTO tbl_permisos (id_rol, id_modulo, accion, estatus) VALUES (?, ?, ?, ?)");
                $stmt->execute([$rol['id_rol'], $modulo['id_modulo'], $accion, $estatus]);
            }
        }
    }
}
}
?>