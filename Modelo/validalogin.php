<?php
class validalogin
{
    function leesesion()
    {

        if (empty($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['rango'])) {
            $s = $_SESSION['rango'];
        } else {
            $s = "";
        }
        return $s;
    }
    function destruyesesion()
    {
        session_start();
        session_destroy();
        header("Location: . ");
    }
}
