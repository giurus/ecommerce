<?php 
    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();

    $item = "ruta";
    $valor = $rutas[0];
    $infoproducto = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
?>
<?php 
    /**VISTAS DE LOS PRODUCTOS**/
    echo '
        <span class="vistas ocultar">'.$infoproducto["vistas"].'</span>
        <span class="idPro ocultar">'.$infoproducto["id"].'</span>
    ';
?>
<!--BREADCRUMB INFO PRODUCTOS-->
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
    <hr>
</div>
<!--INFOPRODUCTOS-->
<div class="container infoproducto">
    <div class="row">
        <!--VISOR DE PRODUCTOS-->
        <div class="col-md-5 col-sm-6 col-xs-12 visorImg">
            <figure class="visor">
                <img class="img-thumbnail shadow" src="<?=$servidor.$infoproducto["portada"]?>" >
            </figure>
        </div>
        <div class="col-md-7 col-sm-6 col-xs-12">
            <div class="row justify-content-between">
                <div class="col-4">
                    <!--REGRESAR A LA TIENDA-->
                    <h6>
                        <a href="javascript:history.back()" class="text-muted"><i class="fas fa-reply"></i>Continuar comprando</a>
                    </h6>
                </div>
                <div class="col-4">
                </div>
            </div>
            <div class="clearfix"><br></div>
            <!--ESPACIO PARA LA INFORMACION DEL PRODUCTO-->
            <h1><?=$infoproducto["titulo"]?><br>
                <small>
                    <span class="badge badge-warning"><?php if($infoproducto["nuevo"]!=0) echo "Nuevo"; ?></span> 
                    <span class="badge badge-warning"><?php if($infoproducto["oferta"]!=0) echo $infoproducto["descuentoOferta"]."% Dto"; ?></span>
                </small>
            </h1>
            <!--PRECIO DEL PRODUCTO-->
            <?php if($infoproducto["oferta"]!=0) { ?>
            <h2>
                <strong class="oferta">S/.<?=$infoproducto["precio"]?></strong>
                S/.<?=$infoproducto["precioOferta"]?>
            </h2>
            <?php }else{ ?>
            <h2>S/.<?=$infoproducto["precio"]?></h2>
            <?php } ?>
            <!--DESCRIPCION DEL PRODUCTO-->
            <p class="text-justify"><?=$infoproducto["descripcion"]?></p>
            <hr><br>
            <!------------------------------->
            <!--BOTONES DE COMPRA-->
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <?php
                        if($infoproducto["oferta"]==1){
                            $precio = $infoproducto["precioOferta"];
                        }else{
                            $precio = $infoproducto["precio"];
                        }
                    ?>
                    <button class="btn btn-block btn-lg backColor agregarCarrito" idProducto="<?=$infoproducto["id"]?>" imagen="<?=$servidor.$infoproducto["portada"]?>" titulo="<?=$infoproducto["titulo"]?>" precio="<?=$precio?>" peso="<?=$infoproducto["peso"]?>"><strong>AÑADIR AL CARRITO <i class="fas fa-shopping-cart"></i></strong></button>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-md-12 col-12">
                    <h6 class="text-muted">La cantidad puede ser modificada en el carrito de compras</h6>
                </div>
            </div>
            <!--ZONA LUPA-->
            <figure class="lupa">
                <img src="">
            </figure>
        </div>
    </div>
    <!--COMENTARIOS------------------->
    <br><hr>
    <div class="col-xl-12 clearfix">
        <div class="row">
            <?php 
                $datos = array("idUsuario"=>"", "idProducto"=>$infoproducto["id"]);
                $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);
                $cantidad = 0;
                foreach ($comentarios as $key => $value) {
                    if($value["comentario"]!=""){
                        $cantidad +=1;
                    }
                }
            ?>
            <ul class="nav nav-tabs starComentarios">
                <?php 
                    $cantidadCalificacion = 0;
                    if($cantidad == 0){
                        echo '<li class="nav-item"><a class="nav-link active"><strong>Opiniones</strong></a></li>
                        
                        ';
                    }else{
                        echo '<li class="nav-item"><a class="nav-link active"><strong>Opiniones</strong></a></li>';
                        $sumaCalificacion = 0;
                        foreach ($comentarios as $key => $value) {
                            if($value["calificacion"]!=0){
                                $cantidadCalificacion ++;
                                $sumaCalificacion += $value["calificacion"];
                            }
                        }
                        $promedio = round($sumaCalificacion/$cantidadCalificacion,0);
                        echo '
                        <li class="nav-item"><a class="nav-link disabled text-muted">Promedio de calificación: '.$promedio.' | ';
                        switch ($promedio) {
                            case 1:echo '<span style="color: orange;">★</span>★★★★';break;
                            case 2:echo '<span style="color: orange;">★★</span>★★★';break;
                            case 3:echo '<span style="color: orange;">★★★</span>★★';break;
                            case 4:echo '<span style="color: orange;">★★★★</span>★';break;
                            case 5:echo '<span style="color: orange;">★★★★★</span>';break;
                        }
                        echo '</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <br>
    <!--OPINIONES DE LOS USUARIOS-->
    <?php if($cantidad==0){
        echo '
            <div class="row comentarios">
                <h3 class="text-center"><small>Este producto aún no tiene valoraciones.</small></h3>
            </div><br>
        ';
    }else{ ?>
    <div class="row comentarios">
        <div class="alturaComentarios">
            <?php 
                $contador = 0;
                foreach ($comentarios as $key => $value) {
                    if($value["comentario"]!=""){
                        $item = "id";
                        $valor = $value["id_usuario"];
                        $usuario = ControladorUsuarios::ctrMostrarUsuario($item,$valor); ?>
                        <div class="card" style="width: 100%;">
                            <div class="card-header">
                                Por: <?=$usuario["nombre"].' '.$usuario["apellido"]?>
                            </div>
                            <div class="card-body">
                                <?=$value["comentario"]?>
                            </div>
                            <div class="card-footer">
                                <?php 
                                    $numero = intval($value["calificacion"]);
                                    switch ($numero) {
                                        case 1:echo '<span style="color: orange;">★</span>★★★★';break;
                                        case 2:echo '<span style="color: orange;">★★</span>★★★';break;
                                        case 3:echo '<span style="color: orange;">★★★</span>★★';break;
                                        case 4:echo '<span style="color: orange;">★★★★</span>★';break;
                                        case 5:echo '<span style="color: orange;">★★★★★</span>';break;
                                    }
                                ?>
                            </div>
                        </div><br>
            <?php   }
                }
            ?>
        </div>
    </div>
    <?php } ?><hr>
    <!-------------------------->
    <!--PRODUCTOS RELACIONADOS-->
    <div class="productos">
        <div class="container">
            <div class="row">
                <!--titulo de productos-->
                <div class="col-12 tituloDestacado">
                    <div class="col-12">
                        <h3>PRODUCTOS RELACIONADOS</h3>
                    </div>
                    <div class="clearfix"><br></div>
                </div>
                <div class="clearfix"> </div>
                <hr>
                <?php
                    $item = "id_subcategoria";
                    $valor = $infoproducto["id_subcategoria"];
                    $base = 0;
                    $tope = 4;
                    $modo = "Rand()";
                    $relacionados = ControladorProductos::ctrMostrarProductosRelacionados($item,$valor,$base,$tope,$modo,$infoproducto['id']);
                    if(!$relacionados){
                        echo "<div class='col-12 error404'><h2>No hay productos relacionados</h2></div>";
                    }else{ 
                        $cantRela = count($relacionados);
                        $columnaRela = '4';
                        if($cantRela>1){ $columnaRela='3'; }
                        ?>
                            <ul class="grid0 d-inline-flex">
                                <!--Producto-->
                                <?php foreach ($relacionados as $key => $value) { ?>
                                    <li class="col-xl-<?=$columnaRela?> col-lg-<?=$columnaRela?> col-md-3 col-sm-6 col-12">
                                        <div class="card-deck">
                                            <div class="card shadow h-100">
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
                                                                <span class="badge badge-warning fontSize"><?php if($value["nuevo"]!=0) echo "Nuevo"; ?></span> 
                                                                <span class="badge badge-warning fontSize"><?php if($value["oferta"]!=0) echo $value["descuentoOferta"]."% Dto"; ?></span> 
                                                            </a>
                                                        </small>
                                                    </h4>
                                                    <!---PRECIO DE LOS PRODUCTOS--->
                                                    <div class="col-6 precio">
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
                    <?php } ?>

            
            </div>
        </div>
    </div>
</div>

