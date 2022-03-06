<?php 

require_once "../controller/usuarios.controlador.php";
require_once "../model/usuarios.modelo.php";

class ajaxUsuarios{
    /**VALIDAR EMAIL EXISTENTE**/
    public $validarEmail;
    public function ajaxValidarEmail(){
        $datos = $this->validarEmail;
        $respuesta = ControladorUsuarios::ctrMostrarUsuario("email", $datos);
        echo json_encode($respuesta);
    }

    /**AGREGAR LISTA DE DESEOS**/
    public $idUsuario;
    public $idProducto;
    public function ajaxAgregarDeseo(){
        $datos = array("idUsuario"=>$this->idUsuario, "idProducto"=>$this->idProducto);
        $respuesta = ControladorUsuarios::ctrAgregarDeseo($datos);
        echo $respuesta;
    }

    /***QUITAR LISTA DE DESEOS**/
    public $idDeseo;
    public function ajaxQuitarDeseo(){
        $datos = $this->idDeseo;
        $respuesta = ControladorUsuarios::ctrQuitarDeseo($datos);
        echo $respuesta;
    }
}

/****/
if(isset($_POST["validarEmail"])){
    $valEmail = new ajaxUsuarios();
    $valEmail->validarEmail=$_POST["validarEmail"];
    $valEmail->ajaxValidarEmail();
}

/**AGREGAR LISTA DE DESEOS**/
if(isset($_POST["idUsuario"])){
    $deseo = new ajaxUsuarios();
    $deseo -> idUsuario = $_POST["idUsuario"];
    $deseo -> idProducto = $_POST["idProducto"];
    $deseo -> ajaxAgregarDeseo();
}


/***QUITAR LISTA DE DESEOS**/
if(isset($_POST["idDeseo"])){
    $quitarDeseo = new ajaxUsuarios();
    $quitarDeseo -> idDeseo = $_POST["idDeseo"];
    $quitarDeseo -> ajaxQuitarDeseo();
}