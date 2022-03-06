<!--VALIDAR SESION-->
<?php
$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();
if(!isset($_SESSION["validarSesion"])){
    echo '<script>
        window.location = "'.$url.'"
    </script>';
    exit();
}

$item = $_SESSION["id"];
$deseos = ControladorUsuarios::ctrMostrarDeseos($item);

$ordenar = "id";
$item = "id";
$cantidad = 0;
foreach ($deseos as $key => $deseosC) {
    $idProducto = $deseosC["id_producto"];
    $nro = ControladorProductos::ctrListarProductos($ordenar,$item,$idProducto);
    $cantidad += (count($nro));
}
?>

<!--BREADCRUMB PERFIL-->
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item fondoBreadcrumb" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?=$url.'perfil'?>">Perfil</a></li>
                <li class="breadcrumb-item active pagActiva"><?php if($rutas[0]=="deseos") echo "Mi lista de Deseos"; ?></li>
            </ol>
        </nav>
    </div>
</div>



<div class="container">
    <div class="row">
        <h2>Mi lista de Deseos</h2>
    </div>
    <div class="row">
        <?php if(!$deseos){ ?>
            <div class="col-12 text-center error404">
                <h3 class="text-muted"><small>Aún no tiene productos en su lista de deseos</small></h3>
            </div>
            <?php } else { ?>
            <ul class="grid0">
                <div class="row row-cols-1 row-cols-md-3">
                    <?php
                    foreach ($deseos as $key => $value1) {
                        $valor = $value1["id_producto"];
                        $productos = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
                        foreach ($productos as $key => $value) { 
                            if($value["oferta"]==1){
                                $precio = $value["precioOferta"];
                            }else{
                                $precio = $value["precio"];
                            }     
                        ?>
                        <div class="col mb-4">
                            <li>
                                <div class="card shadow">
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
                                        <!--BOTONES-->
                                        <div class="col-6 enlaces">
                                            <div class="btn-group grupoBotones">
                                                <button type="button" class="btn btn-light quitarDeseo" idDeseo="<?=$value1["id"]?>" title="Quitar de mi lista de deseos">
                                                        <i class="fas fa-heart" aria-hidden="true"></i></span>
                                                </button>
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
                    <?php } 
                    }
                    ?>
                </div>
            </ul>
        <?php } ?> 
    </div>
</div>