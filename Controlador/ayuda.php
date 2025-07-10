<?php
$pagina = "ayuda";
if (is_file("vista/" . $pagina . ".php")) {
    require_once("vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}
?>