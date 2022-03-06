<?php

class Ruta{
    /**RUTA FRONTEND ( CLIENTE )**/
    public static function ctrRuta(){
        return "http://localhost/shop/anafer/";
    }

    /**RUTA BACKEND ( SERVIDOR ) **/
    public static function ctrRutaServidor(){
        return "http://localhost/shop/admin/";
    }

    /**RUTA PAGO PAYPAL **/
    public static function ctrRutaP(){
        return "http://localhost/shop/anafer";
    }
}