<?php
if (!is_file("modelo/" . $pagina . ".php")) {
    echo "Falta el modelo";
    exit;
}
require_once("modelo/" . $pagina . ".php");
if (is_file("vista/" . $pagina . ".php")) {
    if (!empty($_POST)) {
        $o = new Login();
        $h = $_POST['accion'];

        if ($h == 'acceder') {
            $o->set_username($_POST['username']);
            $o->set_password($_POST['password']);
            $m = $o->existe();
            if ($m['resultado'] == 'existe') {
                session_destroy();
                session_start();
                $_SESSION['name'] = $m['mensaje'];
                $_SESSION['nombre_rol'] = $m['nombre_rol'];
                $_SESSION['id_usuario'] = $m['id_usuario'];
                $_SESSION['id_rol'] = $m['id_rol'];
                $_SESSION['cedula'] = $m['cedula'];
                if ($_SESSION['nombre_rol'] === 'Cliente') {
                 header(header: 'Location: ?pagina=catalogo');  
                }else{

                header(header: 'Location: ?pagina=dashboard');    
                }
                
                die();
            } else {
                $mensaje = $m['mensaje'];
            }
        }

        // NUEVO: Registro doble usuario + cliente
        if ($h == 'registrar') {
            // Recibe los datos del formulario
            $datos = [
                'nombre_usuario' => $_POST['nombre_usuario'],
                'clave' => $_POST['clave'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'cedula' => $_POST['cedula'],
                'direccion' => $_POST['direccion']
            ];
            // Llama al método del modelo
            $resultado = $o->registrarUsuarioYCliente($datos);
            if ($resultado['status'] == 'success') {
    $mensaje = '<span class="success">' . $resultado['mensaje'] . '</span>';
} else {
    $mensaje = '<span class="error">' . $resultado['mensaje'] . '</span>';
}
        }
    }

    require_once("vista/" . $pagina . ".php");
} else {
    echo "Falta la vista";
}