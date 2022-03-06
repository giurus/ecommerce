<?php

require_once "../controller/plantillaControlador.php";
require_once "../model/plantilla.modelo.php";

class AjaxPlantilla{
    public function ajaxEstiloPlantilla(){
        $respuesta = ControladorPlantilla::ctrEstiloPlantilla();
        echo json_encode($respuesta);
    }
}

$objeto = new AjaxPlantilla();
$objeto -> ajaxEstiloPlantilla();