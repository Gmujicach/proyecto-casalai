<?php

require_once __DIR__ . '/../config/config.php';

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


public function getPermisosUsuarioModulo($id_rol, $nombre_modulo) {
    // Busca el id_modulo por nombre
    $stmt = $this->conex->prepare("SELECT id_modulo FROM tbl_modulos WHERE LOWER(nombre_modulo) = LOWER(?) LIMIT 1");
    $stmt->execute([$nombre_modulo]);
    $modulo = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$modulo) {
        return [
            'consultar' => false,
            'incluir' => false,
            'modificar' => false,
            'eliminar' => false
        ];
    }
    $id_modulo = $modulo['id_modulo'];

    // Obtiene los permisos para ese rol y módulo
    $stmt = $this->conex->prepare("SELECT accion, estatus FROM tbl_permisos WHERE id_rol = ? AND id_modulo = ?");
    $stmt->execute([$id_rol, $id_modulo]);
    $permisos = [
        'consultar' => false,
        'incluir' => false,
        'modificar' => false,
        'eliminar' => false
    ];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $perm) {
        $permisos[$perm['accion']] = ($perm['estatus'] === 'Permitido');
    }
    return $permisos;
}
public function guardarPermisos($permisosForm, $roles, $modulos, $acciones) {
    // Borra todos los permisos actuales EXCEPTO los del SuperUsuario (id_rol = 6)
    $this->conex->exec("DELETE FROM tbl_permisos WHERE id_rol <> 6");
    // Inserta todos los permisos posibles, EXCEPTO para el SuperUsuario
    foreach ($roles as $rol) {
        if ($rol['id_rol'] == 6) continue; // Saltar SuperUsuario
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