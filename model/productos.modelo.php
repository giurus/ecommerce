<?php

require_once "conexion.php";

class ModeloProductos{
    static public function mdlMostrarCategorias($tabla,$item,$valor){
        if($item !=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND ($item = :$item)");
            $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;
    }

    static public function mdlMostrarSubCategorias($tabla,$item,$valor){
        if($item !=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND ($item = :$item)");
            $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;
    }

    /*MOSTRAR PRODUCTOS*/
    static public function mdlMostrarProductos($tabla,$ordenar,$item,$valor, $base, $tope){
        if($item!=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where (estado=1) AND ($item = :$item) order by $ordenar desc limit $base, $tope");
            $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1 order by $ordenar desc limit $base, $tope");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        $stmt->close();
        $stmt = null;
    }

    /*LISTAR PRODUCTOS*/
    static public function mdlListarProductos($tabla,$ordenar,$item,$valor){
        if($item!=null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND ($item = :$item) ORDER BY $ordenar DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1 ORDER BY $ordenar DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        $stmt->close();
        $stmt = null;
    }

    

    /**LISTAR PRODUCTOS RELACIONADOS**/
    static public function mdlMostrarProductosRelacionados($tabla,$item,$valor,$base,$tope,$modo,$id){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND ($item = :$item) not in (id=$id) ORDER BY $modo LIMIT $base, $tope");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1 not in(id=$id) ORDER BY $modo LIMIT $base, $tope");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;

	}

    /*MOSTRAR INFO PRODUCTOS*/
    static public function mdlMostrarInfoProducto($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND ($item = :$item)");
        $stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
        $stmt = null;
    }

    /**BUSCADOR**/

    static public function mdlBuscarProductos($tabla,$busqueda,$ordenar,$base, $tope){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND (ruta like '%$busqueda%' or titulo like '%$busqueda%' or marca like '%$busqueda%') order by $ordenar desc limit $base, $tope");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /**LISTAR PRODUCTOS BUSQUEDA**/
    static public function mdlListarProductosBusqueda($tabla,$busqueda){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (estado=1) AND (ruta like '%$busqueda%' or titulo like '%$busqueda%' or marca like '%$busqueda%')");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /**ACTUALIZAR VISTA PRODUCTO**/

    static public function mdlActualizarProducto($tabla,$item1,$valor1,$item2,$valor2){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 =:$item1 WHERE $item2=:$item2");
        $stmt -> bindParam(":".$item1,$valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":".$item2,$valor2, PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    /**MOSTRAR TABLA COMPRAS**/
    static public function mdlCompras($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    
}