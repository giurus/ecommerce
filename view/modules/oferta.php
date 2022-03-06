<?php 
    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();
?>
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
<div class="container">
    <div class="row ">
        <?php 
            /**TRAEMOS LAS OFERTAS PROMOCIONES**/
            $item = null;
            $valor =  null;
            date_default_timezone_set('America/Lima');
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fechaActual = $fecha.' '.$hora;
            //Traemos las ofertas Categorias
            $respuesta = ControladorProductos::ctrMostrarCategorias($item, $valor);
            foreach ($respuesta as $key => $value) {
                if($value['oferta']==1){
                    if($value['finOferta']>$fecha){
                        $datetime1 = new DateTime($value['finOferta']);
                        $datetime2 = new DateTime($fechaActual);
                        $interval = date_diff($datetime1,$datetime2);
                        $finOferta = $interval->format('%a');      
            ?>  
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="ofertas">
                        <h3 class="text-center text-uppercase">¡Promociones en <br><?=$value["categoria"]?>!</h3>
                        <figure>
                            <img src="<?=$servidor.$value["imgOferta"]?>" width="100%" class="" alt="">
                            <div class="sombraSuperior"></div>
                            <h1 class="text-center text-uppercase"><?=$value["descuentoOferta"]!=0 ? $value["descuentoOferta"].'% Dto.' : 'S/.'.$value["precioOferta"] ?></h1>
                        </figure>
                        <center>
                            <div class="countdown" finOferta='<?=$value["finOferta"]?>'></div>
                            <a href="<?=$url.$value["ruta"]?>" class="btn backColor btn-lg text-uppercase pixelOferta">Ir a la promoción</a>
                        </center>
                    </div>
                </div>      
            <?php   }
                }
            }

            //Traemos las ofertas subCategorias
            $respuestaSubCategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);
            foreach ($respuestaSubCategorias as $key => $value) {
                if($value['oferta']==1 && $value['ofertadoPorCategoria']==0){
                    if($value['finOferta']>$fecha){
                        $datetime1 = new DateTime($value['finOferta']);
                        $datetime2 = new DateTime($fechaActual);
                        $interval = date_diff($datetime1,$datetime2);
                        $finOferta = $interval->format('%a');      
            ?>  
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="ofertas">
                        <h3 class="text-center text-uppercase">¡Promociones en <br><?=$value["subcategoria"]?>!</h3>
                        <figure>
                            <img src="<?=$servidor.$value["imgOferta"]?>" width="100%" class="" alt="">
                            <div class="sombraSuperior"></div>
                            <h1 class="text-center text-uppercase"><?=$value["descuentoOferta"]!=0 ? $value["descuentoOferta"].'% Dto.' : 'S/.'.$value["precioOferta"] ?></h1>
                        </figure>
                        <center>
                            <div class="countdown" finOferta='<?=$value["finOferta"]?>'></div>
                            <a href="<?=$url.$value["ruta"]?>" class="btn backColor btn-lg text-uppercase pixelOferta">Ir a la promoción</a>
                        </center>
                    </div>
                </div>      
            <?php   }
                }
            }

            //Traemos las ofertas productos
            $ordenar = 'id';
            $respuestaProductos = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
            foreach ($respuestaProductos as $key => $value) {
                if($value['oferta']==1 && $value['ofertadoPorCategoria']==0 && $value['ofertadoPorSubCategoria']==0){
                    if($value['finOferta']>$fecha){
                        $datetime1 = new DateTime($value['finOferta']);
                        $datetime2 = new DateTime($fechaActual);
                        $interval = date_diff($datetime1,$datetime2);
                        $finOferta = $interval->format('%a');      
            ?>  
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="ofertas">
                        <h3 class="text-center text-uppercase">¡Promocion en <br><?=$value["titulo"]?>!</h3>
                        <figure>
                            <img src="<?=$servidor.$value["imgOferta"]?>" width="100%" class="" alt="">
                            <div class="sombraSuperior"></div>
                            <h1 class="text-center text-uppercase"><?=$value["descuentoOferta"]!=0 ? $value["descuentoOferta"].'% Dto.' : 'S/.'.$value["precioOferta"] ?></h1>
                        </figure>
                        <center>
                            <div class="countdown" finOferta='<?=$value["finOferta"]?>'></div>
                            <a href="<?=$url.$value["ruta"]?>" class="btn backColor btn-lg text-uppercase pixelOferta">Ir a la promoción</a>
                        </center>
                    </div>
                </div>      
            <?php   }
                }
            }
        ?>
    </div>
</div>