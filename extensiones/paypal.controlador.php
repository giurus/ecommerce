<?php

require_once "../model/rutas.php";
require_once "../model/carrito.modelo.php";

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Paypal{
    static public function mdlPagoPaypal($datos){

        require __DIR__ . '/bootstrap.php';

        $tituloArray = explode(",",$datos["tituloArray"]);
        $cantidadArray = explode(",",$datos["cantidadArray"]);
        $valorItemArray = explode(",",$datos["valorItemArray"]);
        $cantidadProductos = str_replace(",","-", $datos["cantidadArray"]);
        $idProductos = str_replace(",","-",$datos["idProductoArray"]);
        $pagoProductos = str_replace(",","-",$datos["valorItemArray"]);
        $telefono = $datos['telefono'];

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        
        $item = array();
        $variosItem = array();

        for ($i=0; $i < count($tituloArray) ; $i++) { 
            $division = $valorItemArray[$i]/$cantidadArray[$i];
            $setPrice = bcdiv($division,'1',2);
            $item[$i] = new Item();
            $item[$i]->setName($tituloArray[$i])
                ->setCurrency($datos["divisa"])
                ->setQuantity($cantidadArray[$i])
                ->setPrice($setPrice);
                array_push($variosItem, $item[$i]);
        }

        $itemList = new ItemList();
        $itemList->setItems($variosItem);


        $details = new Details();
        $details->setShipping($datos["envio"])
            ->setTax($datos["impuesto"])
            ->setSubtotal($datos["subtotal"]);

        $amount = new Amount();
        $amount->setCurrency($datos["divisa"])
            ->setTotal($datos["total"])
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($datos["direccion"])
            ->setInvoiceNumber(uniqid());
        
        $url = Ruta::ctrRutaP();

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$url/index.php?ruta=finalizar-compra&paypal=true&productos=".$idProductos."&cantidad=".$cantidadProductos."&monto=".$pagoProductos."&telefono=".$telefono)
            ->setCancelUrl("$url/carrito-de-compras");

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

            
        try {
            $payment->create($apiContext);
            
        } catch (Paypal\Exception\PaypalConnectionException $ex) {
            echo $ex -> getCode();
            echo $ex -> getData();
            die($ex);
            return "$url/error";
        }

        foreach ($payment->getLinks() as $link) {
			if($link->getRel() == "approval_url"){
				$redirectUrl = $link->getHref();
			}
		}
        return $redirectUrl;
    }
}