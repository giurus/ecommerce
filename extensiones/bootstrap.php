<?php
require __DIR__ . '/vendor/autoload.php';


use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

$tabla = 'comercio';
$respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);

$clienteidpaypal = $respuesta["clienteidpaypal"];
$passwordpaypal = $respuesta["passwordpaypal"];
$modopaypal = $respuesta["modopaypal"];

$apiContext = new ApiContext(
    new OAuthTokenCredential(
        $clienteidpaypal,
        $passwordpaypal
    )
);

$apiContext->setConfig(
    array(
        'mode' => 'sandbox',
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'DEBUG', 
        'http.CURLOPT_CONNECTTIMEOUT' => 30
    )
);