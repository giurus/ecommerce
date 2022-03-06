<?php 

require_once "conexion.php";

class ModeloCarrito{
    static public function mdlMostrarTarifas($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
        $stmt = null;
    }

    static public function mdlNuevasCompras($tabla,$datos){
        $monto = round(floatval($datos['monto'])*3.59);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto, cantidad, metodo, email,telefono, direccion, distrito, monto) VALUES (:id_usuario, :id_producto, :cantidad, :metodo, :email, :telefono, :direccion, :distrito, :monto)");
        $stmt->bindParam(":id_usuario",$datos["idUsuario"], PDO::PARAM_INT);
        $stmt->bindParam(":id_producto",$datos["idProducto"], PDO::PARAM_INT);
        $stmt->bindParam(":cantidad",$datos["cantidad"], PDO::PARAM_INT);
        $stmt->bindParam(":metodo",$datos["metodo"], PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion",$datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":distrito",$datos["distrito"], PDO::PARAM_STR);
        $stmt->bindParam(":monto",$monto, PDO::PARAM_STR);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }
}