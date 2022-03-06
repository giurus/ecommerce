<?php

class ControladorPlantilla {
    
    public function plantilla(){
        include "view/template.php";
    }

    
    public function ctrEstiloPlantilla(){
        $tabla = "plantilla";
        $respt = ModeloPlantilla::mdlEstiloPlantilla($tabla);
        return $respt;
    } 

    public function ctrMostrarComercio(){
        $tabla = "comercio";
        $respt = ModeloPlantilla::mdlMostrarComercio($tabla);
        return $respt;
    }


}