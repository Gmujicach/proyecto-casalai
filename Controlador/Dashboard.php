<?php

if(is_file('Vista/'.$pagina.'.php')){
    require_once ('Vista/'.$pagina.'.php');  //si la pagina existe se carga su vista correspondiente
}else{
    echo "PAGINA EN CONSTRUCCIÓN";
}
