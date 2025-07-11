<?php
require_once __DIR__ . '/../config/config.php';

class Backup {
    private $bd;
    private $tipo;

    public function __construct($tipo = 'P') {
        $this->bd = new BD($tipo);
        $this->tipo = $tipo;
    }




public function generar($nombreArchivo) {
    $pdo = $this->bd->getConexion();
    $dbname = $pdo->query('select database()')->fetchColumn();
    $rutaCarpeta = __DIR__ . '/../db/backup/';
    $ruta = $rutaCarpeta . $nombreArchivo;
    $config = DB_PRINCIPAL;

    // Verificar y crear carpeta si no existe
    if (!is_dir($rutaCarpeta)) {
        if (!mkdir($rutaCarpeta, 0775, true)) {
            return false;
        }
    }
    // Verificar permisos de escritura
    if (!is_writable($rutaCarpeta)) {
        return false;
    }

$mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe'; // En Windows
$opciones = "--databases {$dbname} --add-drop-database --add-drop-table --routines --events --triggers";
$comando = "\"$mysqldump\" --user=\"{$config['user']}\" --password=\"{$config['pass']}\" --host=\"{$config['host']}\" $opciones > \"$ruta\" 2>&1";
exec($comando, $output, $resultado);

    // Depuración: guardar salida del comando
    if ($resultado !== 0) {
        return false;
    }

    return ($resultado === 0 && file_exists($ruta) && filesize($ruta) > 0);
}


public function restaurar($nombreArchivo) {
    $ruta = __DIR__ . '/../db/backup/' . $nombreArchivo;
    $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;

    // Usa la ruta completa de mysql.exe en Windows
    $mysql = 'C:\\xampp\\mysql\\bin\\mysql.exe';

    // No pongas el nombre de la base de datos si el archivo contiene CREATE DATABASE
    $comando = "\"$mysql\" --user=\"{$config['user']}\" --password=\"{$config['pass']}\" --host=\"{$config['host']}\" < \"$ruta\" 2>&1";
    $output = [];
    $resultado = 0;
    exec($comando, $output, $resultado);

    if ($resultado !== 0) {
        return false;
    }
    return true;
}

    public function listar() {
        $ruta = __DIR__ . '/../db/backup/';
        $archivos = [];
        if (is_dir($ruta)) {
            $files = scandir($ruta);
            foreach ($files as $file) {
                if (preg_match('/\.sql$/', $file)) {
                    $archivos[] = $file;
                }
            }
        }
        return $archivos;
    }
}
?>