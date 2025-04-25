<?php
// AuthController.php

class Auth{
    public function login() {
        require_once 'Vistas/login.php';
    }

    public function register() {
        require_once 'Vistas/register.php';
    }
}
?>