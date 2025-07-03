<?php
require_once __DIR__ . '/../Config/config.php';

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
    $rutaCarpeta = __DIR__ . '/../DB/backup/';
    $ruta = $rutaCarpeta . $nombreArchivo;
    $config = DB_PRINCIPAL;

    // Verificar y crear carpeta si no existe
    if (!is_dir($rutaCarpeta)) {
        if (!mkdir($rutaCarpeta, 0775, true)) {
            error_log("No se pudo crear la carpeta de backup: $rutaCarpeta");
            return false;
        }
    }
    // Verificar permisos de escritura
    if (!is_writable($rutaCarpeta)) {
        error_log("La carpeta de backup no tiene permisos de escritura: $rutaCarpeta");
        return false;
    }

    $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe'; // En Windows
    // $mysqldump = 'mysqldump'; // En Linux

    $comando = "\"$mysqldump\" --user=\"{$config['user']}\" --password=\"{$config['pass']}\" --host=\"{$config['host']}\" {$dbname} > \"$ruta\" 2>&1";
    exec($comando, $output, $resultado);

    // Depuración: guardar salida del comando
    if ($resultado !== 0) {
        error_log("Error al ejecutar mysqldump: " . implode("\n", $output));
    }

    return ($resultado === 0 && file_exists($ruta) && filesize($ruta) > 0);
}

public function restaurar($nombreArchivo) {
    $pdo = $this->bd->getConexion();
    $dbname = $pdo->query('select database()')->fetchColumn();
    $ruta = __DIR__ . '/../DB/backup/' . $nombreArchivo;
    $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;

    $mysql = 'mysql';
    // $mysql = 'C:\\xampp\\mysql\\bin\\mysql.exe'; // Si es necesario

    $comando = "$mysql --user=\"{$config['user']}\" --password=\"{$config['pass']}\" --host=\"{$config['host']}\" {$dbname} < \"$ruta\" 2>&1";
    $output = [];
    $resultado = 0;
    exec($comando, $output, $resultado);

    if ($resultado !== 0) {
        error_log("Error al ejecutar mysql restore: " . implode("\n", $output));
        return false;
    }
    return true;
}

    public function listar() {
        $ruta = __DIR__ . '/../DB/backup/';
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