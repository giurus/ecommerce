<?php

$url = Ruta::ctrRuta();

if(!isset($_SESSION["validarSesion"])){
    echo '<script>
        window.location = "'.$url.'"
    </script>';
    exit();
}

#REQUERIMOS LAS CREDENCIALES DE PAYPAL
require 'extensiones/bootstrap.php';
require_once "model/carrito.modelo.php";
#LIBRERIAS SDK
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

/*
PAGO CON PAYPAL ------------------------>
*/
#EVALUAMOS SI LA COMPRA ESTA APROBADA
if(isset($_GET['paypal']) && $_GET['paypal']==='true'){
    #recibir los productos comprados
    $productos = explode("-", $_GET['productos']);
    $cantidad = explode("-", $_GET['cantidad']);
    $monto = explode("-", $_GET['monto']);
    $telefono = $_GET['telefono'];
    #Capturamos el id que nos da paypal
    $paymentId = $_GET['paymentId'];

    #Creamos un objeto para confirmar las credenciales si tiene el id del pago.
    $payment = Payment::get($paymentId, $apiContext);

    #Creamos la ejecucion de pago, invocando la clase paymentExecution y extraemos el id de quien pago.
    $execution = new PaymentExecution();
    $execution -> setPayerId($_GET['PayerID']);

    #validamos las credenciales que el id del comprador si coincidan
    $payment -> execute($execution, $apiContext);
    $datosTransaccion = $payment->toJSON();
    $datosUsuario = json_decode($datosTransaccion);
    $emailComprador = $datosUsuario->payer->payer_info->email;
    $direccion = $datosUsuario->transactions[0]->description;
    $direccionArray = explode("-",$direccion);
    
    #Actualizamos la base de datos
    for ($i=0; $i<count($productos); $i++) { 
        $datos = array("idUsuario"=>$_SESSION["id"],
                        "idProducto"=>$productos[$i],
                        "cantidad"=>$cantidad[$i],
                        "metodo"=>"paypal",
                        "email"=>$emailComprador,
                        "direccion"=>$direccionArray[0],
                        "distrito"=>$direccionArray[1],
                        "monto"=>$monto[$i],
                        "telefono"=>$telefono
        );

        $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

        $ordenar = 'id';
        $item = 'id';
        $valor = $productos[$i];
        $productosCompra = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);

        foreach ($productosCompra as $key => $value) {
            $item1 = 'ventas';
            $valor1 = intval($value["ventas"])+intval($cantidad[$i]);
            $item2 = 'id';
            $valor2 = $value["id"];
            $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
        }

        if($respuesta=='ok' && $actualizarCompra=='ok'){
            echo '<script>
                localStorage.removeItem("listaProductos");
                localStorage.removeItem("cantidadCesta");
                localStorage.removeItem("sumaCesta");
                window.location="'.$url.'historial-compra";
            </script>';
        }
    }
}else{
    /**PAGOS DE PAYU**/
    $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
    $merchant_id = $_REQUEST['merchantId'];
    $referenceCode = $_REQUEST['referenceCode'];
    $TX_VALUE = $_REQUEST['TX_VALUE'];
    $New_value = number_format($TX_VALUE, 1, '.', '');
    $currency = $_REQUEST['currency'];
    $transactionState = $_REQUEST['transactionState'];
    $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
    $firmacreada = md5($firma_cadena);
    $firma = $_REQUEST['signature'];
    $reference_pol = $_REQUEST['reference_pol'];
    $cus = $_REQUEST['cus'];
    $extra1 = $_REQUEST['description'];
    $pseBank = $_REQUEST['pseBank'];
    $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
    $transactionId = $_REQUEST['transactionId'];

    if ($_REQUEST['transactionState'] == 4 ) {
        $estadoTx = "Transacción aprobada";
    }

    else if ($_REQUEST['transactionState'] == 6 ) {
        $estadoTx = "Transacción rechazada";
    }

    else if ($_REQUEST['transactionState'] == 104 ) {
        $estadoTx = "Error";
    }

    else if ($_REQUEST['transactionState'] == 7 ) {
        $estadoTx = "Transacción pendiente";
    }

    else {
        $estadoTx=$_REQUEST['mensaje'];
    }


    if (strtoupper($firma) == strtoupper($firmacreada && $estadoTx == "Transacción aprobada")) {
        $productos = explode("-",$_GET['productos']);
        $cantidad = explode("-",$_GET['cantidad']);
        $monto = explode("-", $_GET['monto']);
        for ($i=0; $i<count($productos); $i++) { 
            $datos = array("idUsuario"=>$_SESSION["id"],
                            "idProducto"=>$productos[$i],
                            "cantidad"=>$cantidad,
                            "metodo"=>"payu",
                            "email"=>$_REQUEST['buyerEmail'],
                            "direccion"=>'',
                            "distrito"=>'',
                            "monto"=>$monto[$i]
            );
    
            $respuesta = ControladorCarrito::ctrNuevasCompras($datos);
    
            $ordenar = 'id';
            $item = 'id';
            $valor = $productos[$i];
            $productosCompra = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
    
            foreach ($productosCompra as $key => $value) {
                $item1 = 'ventas';
                $valor1 = $value["ventas"]+$cantidad[$i];
                $item2 = 'id';
                $valor2 = $value["id"];
                $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
            }
    
            if($respuesta=='ok' && $respuesta=='ok'){
                echo '<script>
                    localStorage.removeItem("listaProductos");
                    localStorage.removeItem("cantidadCesta");
                    localStorage.removeItem("sumaCesta");
                    window.location="'.$url.'historial-compra";
                </script>';
            }
        }
    }
}



