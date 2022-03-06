<?php

class ControladorProductos{
    static public function ctrMostrarCategorias($item,$valor){
        $tabla = "categorias";
        $respuesta = ModeloProductos::mdlMostrarCategorias($tabla,$item,$valor);
        return $respuesta;
    }

    static public function ctrMostrarSubCategorias($item,$valor){
        $tabla = "subcategorias";
        $respuesta = ModeloProductos::mdlMostrarSubCategorias($tabla,$item,$valor);
        return $respuesta;
    }

    static public function ctrMostrarProductos($ordenar,$item,$valor,$base, $tope){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla,$ordenar,$item,$valor, $base, $tope);
        return $respuesta;
    }

    static public function ctrMostrarProductosRelacionados($item,$valor,$base, $tope, $modo,$id){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarProductosRelacionados($tabla,$item,$valor,$base, $tope, $modo,$id);
        return $respuesta;
    }

    static public function ctrListarProductos($ordenar,$item,$valor){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlListarProductos($tabla,$ordenar,$item,$valor);
        return $respuesta;
    }

    static public function ctrMostrarInfoProducto($item,$valor){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarInfoProducto($tabla,$item,$valor);
        return $respuesta;
    }

    static public function ctrBuscarProductos($busqueda,$ordenar,$base, $tope){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlBuscarProductos($tabla,$busqueda,$ordenar,$base, $tope);
        return $respuesta;
    }

    static public function ctrListarProductosBusqueda($busqueda){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlListarProductosBusqueda($tabla,$busqueda);
        return $respuesta;
    }

    static public function ctrActualizarProducto($item1,$valor1,$item2,$valor2){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlActualizarProducto($tabla,$item1,$valor1,$item2,$valor2);
        return $respuesta;
    }

    /**MOSTRAR TABLA DE COMPRAS**/
    static public function ctrCompras(){
        $tabla = "compras";
        $respuesta = ModeloProductos::mdlCompras($tabla);
        return $respuesta;
    }

    
}