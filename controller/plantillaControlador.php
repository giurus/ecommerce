<?php

class ControladorPlantilla {
    
    public function plantilla(){
        include "view/template.php";
    }

    
    static public function ctrEstiloPlantilla(){
        $tabla = "plantilla";
        $respt = ModeloPlantilla::mdlEstiloPlantilla($tabla);
        return $respt;
    } 

    static public function ctrMostrarComercio(){
        $tabla = "comercio";
        $respt = ModeloPlantilla::mdlMostrarComercio($tabla);
        return $respt;
    }


}