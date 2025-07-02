<?php
require_once __DIR__ . '/../Config/config.php';

class Backup {
    private $bd;
    private $tipo;
    private $nombreArchivo;

    public function __construct($tipo = 'P') {
        $this->bd = new BD($tipo);
        $this->tipo = $tipo;
    }

    // Getters y setters
    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo) { $this->tipo = $tipo; }

    public function getNombreArchivo() { return $this->nombreArchivo; }
    public function setNombreArchivo($nombreArchivo) { $this->nombreArchivo = $nombreArchivo; }

    // Realiza el respaldo de la base de datos y devuelve la ruta del archivo generado
    public function backup($nombreArchivo) {
        $this->setNombreArchivo($nombreArchivo);
        $pdo = $this->bd->getConexion();
        $dbname = $pdo->query('select database()')->fetchColumn();

        $ruta = __DIR__ . '/BD/backups/' . $nombreArchivo;
        $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;
        $comando = "mysqldump --user=" . $config['user'] . " --password=" . $config['pass'] . " --host=" . $config['host'] . " $dbname > $ruta";
        system($comando, $resultado);

        return ($resultado === 0) ? $ruta : false;
    }

    // Restaura la base de datos desde un archivo SQL
    public function restore($nombreArchivo) {
        $this->setNombreArchivo($nombreArchivo);
        $pdo = $this->bd->getConexion();
        $dbname = $pdo->query('select database()')->fetchColumn();

        $ruta = __DIR__ . '/BD/backups/' . $nombreArchivo;
        $config = ($this->tipo === 'S') ? DB_SEGURIDAD : DB_PRINCIPAL;
        $comando = "mysql --user=" . $config['user'] . " --password=" . $config['pass'] . " --host=" . $config['host'] . " $dbname < $ruta";
        system($comando, $resultado);

        return ($resultado === 0);
    }

    // Consulta los respaldos existentes en la carpeta Backups
    public function listarRespaldos() {
        $ruta = __DIR__ . '/BD/backups/';
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