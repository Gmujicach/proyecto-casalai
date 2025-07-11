<?php

function plantilla($nombre, $datos = [])
{
    extract($datos);
    include "plantillas/{$nombre}.php";
}

function renderImagen($id, $nombre)
{
    return <<<HTML
        <img class="img-thumbnail my-3" src="img/{$id}/{$nombre}">
    HTML;
}
