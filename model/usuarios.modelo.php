<?php

require_once "conexion.php";

class ModeloUsuarios{
    /**CREACION Y NOTIFICACIONES DE NUEVOS USUARIOS**/
    static public function mdlRegistroUsuario($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, password, email, modo, verificacion, emailEncriptado) VALUES(:nombre, :apellido, :password, :email, :modo, :verificacion, :emailEncriptado)");
        $stmt -> bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido",$datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":password",$datos["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":email",$datos["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":modo",$datos["modo"], PDO::PARAM_STR);
        $stmt -> bindParam(":verificacion",$datos["verificacion"], PDO::PARAM_INT);
        $stmt -> bindParam(":emailEncriptado",$datos["emailEncriptado"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    static public function mdlMostrarNotificaciones($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt-> close();
		$stmt = null;
    }

    static public function mdlActualizarNotificaciones($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item=:$item");
        $stmt -> bindParam(':'.$item, $valor, PDO::PARAM_INT);
        if($stmt -> execute()){
            return 'ok';
        }else{
            return 'error';
        }
		$stmt-> close();
		$stmt = null;
    }
    /**************************************************/

    /**MOSTRAR USUARIO**/
    static public function mdlMostrarUsuario($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt-> close();
		$stmt = null;
    }

    /**ACTUALIZAR VERIFICACION USUARIO**/
    static public function mdlActualizarUsuario($tabla,$id,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE id = :id");
        $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
        $stmt -> bindParam(":id",$id, PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "No se pudo verificar";
        }
        $stmt->close();
        $stmt = null;
    }

    /***ACTUALIZAR PERFIL**/
    static public function mdlActualizarPerfil($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, password = :password, email = :email, telefono=:telefono WHERE id = :id");
        $stmt -> bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido",$datos["apellido"], PDO::PARAM_STR);
        $stmt -> bindParam(":password",$datos["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":email",$datos["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":telefono",$datos["telefono"], PDO::PARAM_STR);
        $stmt -> bindParam(":id",$datos["id"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    /**MOSTRAR COMPRAS DEL USUARIO**/
    static public function mdlMostrarCompras($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
        $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /**MOSTRAR TODOS LOS COMENTARIOS**/
    static public function mdlComentarios($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE calificacion!=0");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /**MOSTRAR COMENTARIOS DEL PERFIL POR COMPRA**/
    static public function mdlMostrarComentariosPerfil($tabla,$datos){
        if($datos["idUsuario"]!=""){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
            $stmt -> bindParam(":id_usuario",$datos["idUsuario"], PDO::PARAM_INT);
            $stmt -> bindParam(":id_producto",$datos["idProducto"], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto ORDER BY id DESC");
            $stmt -> bindParam(":id_producto",$datos["idProducto"], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;
    }

    /**ACTUALIZAR COMENTARIO**/
    static public function mdlActualizarComentario($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET calificacion = :calificacion, comentario = :comentario WHERE id=:id");
        $stmt -> bindParam(":calificacion",$datos["calificacion"], PDO::PARAM_INT);
        $stmt -> bindParam(":comentario",$datos["comentario"], PDO::PARAM_STR);
        $stmt -> bindParam(":id",$datos["id"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    /**AGREGAR A LISTA DE DESEOS***/
    static public function mdlAgregarDeseo($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto) VALUES (:id_usuario, :id_producto)");
        $stmt -> bindParam(":id_usuario",$datos["idUsuario"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_producto",$datos["idProducto"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    /**MOSTRAR LISTA DE DESEOS**/
    static public function mdlMostrarDeseos($tabla,$item){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario ORDER BY id DESC");
        $stmt -> bindParam(":id_usuario",$item, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /**QUITAR A LISTA DE DESEOS***/
    static public function mdlQuitarDeseo($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id",$datos, PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    /**INGRESO COMENTARIOS**/
    static public function mdlIngresoComentarios($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto) VALUES (:id_usuario, :id_producto)");
        $stmt -> bindParam(":id_usuario",$datos["idUsuario"], PDO::PARAM_INT);
        $stmt -> bindParam(":id_producto",$datos["idProducto"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
}