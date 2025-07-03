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
        $ruta = __DIR__ . '/../DB/backup/' . $nombreArchivo;
        $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;

        // Intenta usar mysqldump con ruta absoluta si es necesario
        $mysqldump = 'mysqldump';
        // Si estás en Windows y mysqldump no está en el PATH, pon la ruta completa, por ejemplo:
        // $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

        $comando = "$mysqldump --user=\"{$config['user']}\" --password=\"{$config['pass']}\" --host=\"{$config['host']}\" {$dbname} > \"$ruta\" 2>&1";
        $output = [];
        $resultado = 0;
        exec($comando, $output, $resultado);

        if ($resultado !== 0) {
            error_log("Error al ejecutar mysqldump: " . implode("\n", $output));
            return false;
        }
        return $nombreArchivo;
    }

    public function restaurar($nombreArchivo) {
        $pdo = $this->bd->getConexion();
        $dbname = $pdo->query('select database()')->fetchColumn();
        $ruta = __DIR__ . '/../DB/backup/' . $nombreArchivo;
        $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;

        $mysql = 'mysql';
        // Si estás en Windows y mysql no está en el PATH, pon la ruta completa, por ejemplo:
        // $mysql = 'C:\\xampp\\mysql\\bin\\mysql.exe';

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