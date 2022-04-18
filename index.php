<?php

    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'C:/xampp/htdocs/shop/anafer/php_error_log');

    require_once "controller/plantillaControlador.php";
    require_once "controller/productos.controlador.php";
    require_once "controller/slide.controlador.php";
    require_once "controller/usuarios.controlador.php";
    require_once "controller/carrito.controlador.php";

    require_once "model/plantilla.modelo.php";
    require_once "model/productos.modelo.php";
    require_once "model/slide.modelo.php";
    require_once "model/usuarios.modelo.php";
    require_once "model/carrito.modelo.php";
    
    require_once "model/rutas.php";

    require_once "extensiones/vendor/autoload.php";
    

    $plantilla = new ControladorPlantilla();
    $plantilla->plantilla();