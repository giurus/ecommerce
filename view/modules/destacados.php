<?php
    $servidor = Ruta::ctrRutaServidor();

    $titulosModulos=array("PRODUCTOS DESTACADOS", "NUEVOS PRODUCTOS");
    $rutaModulos=array("productos-destacados","nuevos-productos");
    $base = 0;
    $tope = 4;
    if($titulosModulos[0]=="PRODUCTOS DESTACADOS"){
        $ordenar = "ventas";
        $item = null;
        $valor = null;
        $destacados = ControladorProductos::ctrMostrarProductos($ordenar,$item,$valor,$base, $tope);
    }
    if($titulosModulos[1]=="NUEVOS PRODUCTOS"){
        $ordenar = "nuevo";
        $item = null;
        $valor = null;
        $nuevos = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor,$base, $tope);
    }

    $modulos = array($destacados,$nuevos);

    //BANNER EN MEDIO DE LA PAGINA
    $banner = ControladorProductos::ctrMostrarCategorias('ruta','sin-categoria');
?>
<!--Productos destacados (Mas vendidos) -->
<?php for ($i=0; $i < count($titulosModulos) ; $i++){ ?>
<div class="productos">
    <div class="container">
        <div class="row">
            <!--titulo de productos-->
            <div class="col-12 tituloDestacado">
                <div class="col-12">
                    <h2><?=$titulosModulos[$i]?></h2>
                </div>
            </div>
            <hr>
            <!--PRODUCTOS DESTACADOS-->
            <ul class="grid0 d-inline-flex">
                <?php foreach ($modulos[$i] as $key => $value) { ?>
                <li class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card-deck">
                        <div class="card shadow h-100">
                            <?php 
                            if($value["nuevo"]!=0 && $titulosModulos[$i]!="NUEVOS PRODUCTOS"){
                                echo '
                                <div class="ribbon-wrapper">
                                    <div class="ribbon bg-warning">Nuevo</div>
                                </div>
                                ';
                            }
                            ?>
                            <a href="<?=$value["ruta"]?>" class="pixelProducto">
                                <img src="<?=$servidor?><?=$value["portada"]?>" class="img-thumbnail">
                            </a>
                            <div class="card-body">
                                <!----ETIQUETAS DE DESCUENTOS O NUEVOS------>
                                <h4>
                                    <small>
                                        <a href="<?=$value["ruta"]?>" class="pixelProducto">
                                            <div class="text-center tituloProducto">
                                            <?=$value["titulo"]?>
                                            </div>
                                            <span style="color:rgba(0,0,0,0)">-</span> 
                                            <span class="badge badge-warning fontSize"><?php if($value["oferta"]!=0) echo $value["descuentoOferta"]."% Dto"; ?></span> 
                                        </a>
                                    </small>
                                </h4>
                                <!---PRECIO DE LOS PRODUCTOS--->
                                <div class="col-10 precio">
                                        <?php if($value["oferta"]!=0) { ?>
                                        <h4>
                                            <small>
                                                <strong class="oferta">S/.<?=$value["precio"]?> </strong>
                                            </small>
                                            <small>S/.<?=$value["precioOferta"]?></small>
                                        </h4>
                                        <?php }else{ ?>
                                        <h4>
                                            <small>S/.<?=$value["precio"]?></small>
                                        </h4>
                                        <?php } ?>
                                </div>
                                <!--BOTONES DE CARRITO, DESEOS, VER-->
                                <div class="col-6 enlaces">
                                    <div class="btn-group grupoBotones">
                                        <?php if(isset($_SESSION["id"])){
                                            $valores = array();
                                            $item = $_SESSION["id"];
                                            $deseos = ControladorUsuarios::ctrMostrarDeseos($item);
                                            foreach ($deseos as $key => $value2) {
                                                if($value2["id_producto"]==$value["id"]){
                                                    $condicion = $value2["id_producto"];
                                                    array_push($valores, $condicion);
                                                }
                                            }
                                            if(isset($valores[0])){ ?>
                                                <button type="button" class="btn btn-light deseos" idProducto="<?=$value["id"]?>" title="Agregar a la lista de deseos">
                                                    <i data-original="fas fa-heart" class="fas fa-heart" aria-hidden="true"></i>
                                                </button>
                                        <?php }else{ ?>
                                                <button type="button" class="btn btn-light deseos" idProducto="<?=$value["id"]?>" title="Agregar a la lista de deseos">
                                                    <i data-original="far fa-heart" class="far fa-heart" aria-hidden="true"></i>
                                                </button>
                                        <?php }
                                        }else{ ?>
                                            <button type="button" class="btn btn-light deseos" title="Agregar a la lista de deseos">
                                                <i data-original="far fa-heart" class="far fa-heart" aria-hidden="true"></i>
                                            </button>
                                        <?php  }  ?>
                                        <?php
                                        if($value["oferta"]==1){
                                            $precio = $value["precioOferta"];
                                        }else{
                                            $precio = $value["precio"];
                                        }
                                        ?>
                                        <button type="button" style="margin-left:1px" class="btn btn-light agregarCarrito" idProducto="<?=$value["id"]?>" imagen="<?=$servidor.$value["portada"]?>" titulo="<?=$value["titulo"]?>" precio="<?=$precio?>" peso="<?=$value["peso"]?>" title="Agregar al carrito">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <a href="<?=$value["ruta"]?>" class="pixelProducto">
                                            <button type="button" class="btn btn-light" title="Ver Producto">
                                                <i class="far fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div><br>
<?php 
    if($titulosModulos[$i]=="PRODUCTOS DESTACADOS"){
        echo '
        <br>
            <div class="container-fluid clearfix bannerMedio">
                <img src="'.$servidor.$banner["img"].'" style="width: 100%;">
            </div>
        ';
    }
} ?>


