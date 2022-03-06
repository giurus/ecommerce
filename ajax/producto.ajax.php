<?php

require_once "../controller/productos.controlador.php";
require_once "../model/productos.modelo.php";

class AjaxProductos{
    public $valor;
    public $item;
    public $id;
    public function ajaxVistaProducto(){
        
        $item1 = $this->item;
        $valor1 = $this->valor;
        $item2 = 'id';
        $valor2 = $this->id;
        
        $respuesta = ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
        echo $respuesta;
    }
    /**TRAER EL PRODUCTO DE ACUERDO AL ID**/
    /*public $idPro;
    public function ajaxTraerProducto(){
        $item = 'id';
        $valor = $this->idPro;
        $respuesta = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
        echo json_encode($respuesta);
    }*/
}

if(isset($_POST["valor"])){
    $vista = new AjaxProductos();
    $vista -> valor = $_POST["valor"];
    $vista -> item = $_POST["item"];
    $vista -> id = $_POST["id"];
    $vista -> ajaxVistaProducto();
}

/*if(isset($_POST["id"])){
    $producto = new AjaxProductos();
    $producto -> ididPro = $_POST["id"];
    $producto -> ajaxTraerProducto();
}*/

