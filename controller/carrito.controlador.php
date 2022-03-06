<?php 

class ControladorCarrito{
    /**MOSTRAR TARIFAS**/
    public function ctrMostrarTarifas(){
        $tabla = 'comercio';
        $respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);
        return $respuesta;
    }

    /**NUEVAS COMPRAS**/
    static public function ctrNuevasCompras($datos){
        $tabla = 'compras';
        $respuesta = ModeloCarrito::mdlNuevasCompras($tabla,$datos);
        if($respuesta=='ok'){
            $tabla = 'comentarios';
            ModeloUsuarios::mdlIngresoComentarios($tabla, $datos);
            /*ACTUALIZAR LAS NOTIFICACIONES DE VENTAS*/
            $traerNotificaciones = ModeloUsuarios::mdlMostrarNotificaciones('notificaciones');
            $nuevaVenta = $traerNotificaciones['ventas']+1;
            ModeloUsuarios::mdlActualizarNotificaciones('notificaciones','ventas',$nuevaVenta);
        }
        return $respuesta;
    }
}