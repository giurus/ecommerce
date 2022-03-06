<?php 

    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();

    $item1 = "ruta";
    
    $tope = 12; //Cantidad de productos por pagina
    if(isset($rutas[1])){
        $base = ($rutas[1]-1)*$tope;
    }else{
        $rutas[1]=1;
        $base = 0;
    }
    $ordenar = "id";
    
    $productos = null;
    $listaProductos = null;
    if(isset($rutas[2])){
        $busqueda = $rutas[2];
        $productos = ControladorProductos::ctrBuscarProductos($busqueda,$ordenar,$base, $tope);
        $listaProductos = ControladorProductos::ctrListarProductosBusqueda($busqueda);
    }
    $cantidadProductos = count($listaProductos);
    $pagProductos = ceil($cantidadProductos/$tope);
    $numPagActual = $rutas[1];
    
    $ruta = $rutas[0];
    
?>
<div class="barraProductos">
	<div class="container">
		<div class="row">
            <!--BREADCRUMB-->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item fondoBreadcrumb" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                    <li class="breadcrumb-item active pagActiva"><?=$rutas[0]?></li>
                </ol>
            </nav>
            <!---->
		</div>
	</div>
</div>

<div class="productos">
    <div class="container">
        <div class="row">
            <?php if(!$productos){  ?>
            <div class="col-12 error404 text-center">
                <h1><small>¡Oops!</small></h1>
                <h2>Aún no hay productos en esta sección</h2>
            </div>
            <?php }else{ ?>
            <!--PRODUCTOS EN CUADRICULA-->
            <ul class="grid0">
                <?php 
                    $claseCol = 'row-cols-4';
                    if($cantidadProductos==1){ $claseCol='row-cols-3'; }
                ?>
                <div class="row <?=$claseCol?> row-cols-md-<?php if($cantidadProductos>4){ echo '4'; } ?>">
                    <?php foreach ($productos as $key => $value) {
                            if($value["oferta"]==1){
                                $precio = $value["precioOferta"];
                            }else{
                                $precio = $value["precio"];
                            }    
                    ?>
                    <div class="col mb-4">
                        <li>
                        <div class="card shadow">
                                <?php 
                                if($value["nuevo"]!=0){
                                    echo '
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-warning">Nuevo</div>
                                    </div>
                                    ';
                                }
                                ?>
                                <a href="<?=$url.$value["ruta"]?>" class="pixelProducto">
                                    <img src="<?=$servidor?><?=$value["portada"]?>" class="img-thumbnail">
                                </a>
                                <div class="card-body">
                                    <!----ETIQUETAS DE DESCUENTOS O NUEVOS------>
                                    <h4>
                                        <small>
                                            <a href="<?=$url.$value["ruta"]?>" class="pixelProducto">
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
                                            <a href="<?=$url.$value["ruta"]?>" class="pixelProducto">
                                                <button type="button" class="btn btn-light" title="Ver Producto">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </li>
                    </div>
                    <?php 
                }
                ?>
                </div>
            </ul>
            <?php
        } ?>
        </div>
        <div class="clearfix"></div>

        <!--PAGINACION----------------------------->
        <?php
        if(count($listaProductos)>12) { ?>
        <div class="row">
            <?php 
                //maximo de botones
                $botones = 4;
                //boton principal
                $inicioboton = 1;
                if(isset($numPagActual)){
                    $inicioboton = $numPagActual-1;
                    if($numPagActual==1){
                        $inicioboton = $numPagActual;
                    }
                }
                //calcular cantidad de botones mediante el boton de inicio
                $botones = $botones + $inicioboton;
                //calcular el fin de los botones
                if($botones>$pagProductos){
                    $botones = $pagProductos +1;
                }
                if($numPagActual<1 || $numPagActual>$pagProductos || $cantidadProductos<=$tope){}else{
                    echo '
                    <ul class="pagination justify-content-center">';
                        if($numPagActual>1){
                            if($numPagActual>=3){
                                echo '<li class="page-item"><a class="page-link" href="'.$url.$rutas[0].'/'.'1'.'/'.$rutas[2].'"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></a></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="'.$url.$rutas[0].'/'.($numPagActual-1).'/'.$rutas[2].'"><i class="fas fa-chevron-left"></i></a></li>';    
                        }
                        for($i = $inicioboton-1; $i< $botones-1; $i++){
                            $colorActive = '';
                            if($numPagActual==$i+1){
                                $colorActive = 'active';
                            }
                            echo '<li class="page-item '.$colorActive.'"><a class="page-link" href="'.$url.$rutas[0].'/'.($i+1).'/'.$rutas[2].'">'.($i+1).'</a></li>';
                        }
                        if($numPagActual<$pagProductos){
                            echo '<li class="page-item"><a class="page-link" href="'.$url.$rutas[0].'/'.($numPagActual+1).'/'.$rutas[2].'"><i class="fas fa-chevron-right"></i></a></li>';
                            if($numPagActual<=$pagProductos-4){
                                echo '<li class="page-item"><a class="page-link" href="'.$url.$rutas[0].'/'.$pagProductos.'/'.$rutas[2].'"><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></a></li>'; 
                            }
                        } 
                    echo '</ul>';
                }
            ?>
            <!---------------->
        </div>
        <?php } ?>
    </div>
</div>

