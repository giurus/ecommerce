<?php

require_once "../extensiones/paypal.controlador.php";


class AjaxCarrito{
    /**METODO PAYPAL**/
    public $divisa;
    public $direccion;
    public $telefono;
	public $total;
	public $impuesto;
	public $envio;
	public $subtotal;
	public $tituloArray;
	public $cantidadArray;
	public $valorItemArray;
    public $idProductoArray;
    
    public function ajaxEnviarPaypal(){
        $datos = array(
            "divisa" => $this -> divisa,
            "direccion" => $this -> direccion,
            "telefono" => $this -> telefono,
            "total" => $this -> total,
            "impuesto" => $this -> impuesto,
            "envio" => $this -> envio,
            "subtotal" => $this -> subtotal,
            "tituloArray" => $this -> tituloArray,
            "cantidadArray" => $this -> cantidadArray,
            "valorItemArray" => $this -> valorItemArray,
            "idProductoArray" => $this -> idProductoArray,
        );
        $respuesta = Paypal::mdlPagoPaypal($datos);
        echo $respuesta;
    }
    
}

/**METODO DE LA CLASE PAYPAL**/
if(isset($_POST["divisa"])){
    $paypal = new AjaxCarrito();
    $paypal -> divisa = $_POST['divisa'];
    $paypal -> direccion = $_POST['direccion'];
    $paypal -> telefono = $_POST['telefono'];
	$paypal -> total = $_POST['total'];
	$paypal -> impuesto = $_POST['impuesto'];
	$paypal -> envio = $_POST['envio'];
	$paypal -> subtotal = $_POST['subtotal'];
	$paypal -> tituloArray = $_POST['tituloArray'];
	$paypal -> cantidadArray = $_POST['cantidadArray'];
	$paypal -> valorItemArray = $_POST['valorItemArray'];
    $paypal -> idProductoArray = $_POST['idProductoArray'];
    $paypal -> ajaxEnviarPaypal();
}