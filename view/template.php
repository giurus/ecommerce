<?php 
    session_start();
    $icono = ControladorPlantilla::ctrEstiloPlantilla();
    $url = Ruta::ctrRuta();
    $servidor = Ruta::ctrRutaServidor();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="PetShop">
    <meta name="description"
        content="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio, quia quis, vel expedita inventore natus atque dolore impedit ipsam iusto cupiditate non incidunt accusantium.">
    <meta name="keyword"
        content="Lorem ipsum dolor, sit amet consectetur, adipisicing, elit. Optio, quia quis, vel expedita inventore, natus atque dolore impedit ipsam iusto cupiditate non incidunt accusantium.">
    <title>Anaferperu.com | Tienda Online Delivery de productos para mascotas.</title>
    <link rel="icon" href="<?=$servidor?><?=$icono["icono"]?>">
    <!--Plugins CSS-->
    <link rel="stylesheet" href="<?=$url?>view/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$url?>view/css/plugins/transiciones.css">
    <link rel="stylesheet" href="<?=$url?>view/css/plugins/sweetalert.css">
    <link rel="stylesheet" href="<?=$url?>view/css/plugins/css/all.min.css">
    <link rel="stylesheet" href="<?=$url?>view/css/plugins/dscountdown.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <!--Estilos personalizados-->
    <link rel="stylesheet" href="<?=$url?>view/css/plantilla.css">
    <link rel="stylesheet" href="<?=$url?>view/css/cabezote.css">
    <link rel="stylesheet" href="<?=$url?>view/css/productos.css">
    <link rel="stylesheet" href="<?=$url?>view/css/infoproducto.css">
    <link rel="stylesheet" href="<?=$url?>view/css/perfil.css">
    <link rel="stylesheet" href="<?=$url?>view/css/carritoCompras.css">
    <link rel="stylesheet" href="<?=$url?>view/css/navegacion.css">
    <link rel="stylesheet" href="<?=$url?>view/css/ofertas.css">
    <link rel="stylesheet" href="<?=$url?>view/css/footer.css">
    <link rel="stylesheet" href="<?=$url?>view/css/ribbon.css">
    <link rel="stylesheet" href="<?=$url?>view/css/loader.css">
    <!--Scripts JavaScripts-->
    <script src="<?=$url?>view/js/plugins/jquery.min.js"></script>
    <script src="<?=$url?>view/js/plugins/bootstrap.min.js"></script>
    <script src="<?=$url?>view/js/plugins/jquery.easing.js"></script>
    <script src="<?=$url?>view/js/plugins/jquery.scrollUp.js"></script>
    <script src="<?=$url?>view/js/plugins/jquery.flexslider.js"></script>
    <script src="<?=$url?>view/js/plugins/sweetalert.min.js"></script>
    <script src="<?=$url?>view/js/plugins/md5-min.js"></script>
    <script src="<?=$url?>view/js/plugins/dscountdown.min.js"></script>
</head>

<body>
<!--<div class="gooey">
  <span class="dot"></span>
  <div class="dots">
    <span></span>
    <span></span>
    <span></span>
  </div>
</div>-->
<div class="paginaTotal">
    <?php 
    include "modules/header.php";
    include "modules/barraNavegacion.php";
    /**CONTENIDO DINÁMICO**/
    $rutas = array();
    $ruta = null;
    $infoProducto = null;

    if(isset($_GET["ruta"])){
        /*SEPARAR LA RUTA*/
        $rutas = explode ("/", $_GET["ruta"]);
        /****/
        $item = "ruta";
        $valor = $rutas[0];
        /**URLS AMIGABLES DE CATEGORIAS**/
        $rutaCategorias = ControladorProductos::ctrMostrarCategorias($item,$valor);
        
        if($valor==$rutaCategorias["ruta"]){
            $ruta=$valor;
        }
        
        /**URLS AMIGABLES DE SUBCATEGORIAS**/
        $rutaSubCategorias = ControladorProductos::ctrMostrarSubCategorias($item,$valor);
        foreach ($rutaSubCategorias as $key => $value) {
            if($valor==$value["ruta"]){
                $ruta=$valor;
            }
        }

        /**URLS AMIGABLES DE PRODUCTOS**/
        $rutaProductos = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
        if($valor==$rutaProductos["ruta"]){
            $infoProducto=$valor;
        }

        /**LISTA BLANCA DE URLS AMIGABLES**/
        if($ruta != null){
            include "modules/productos.php";
        }else if($infoProducto!=null){
            include "modules/infoproducto.php";
        }else if($rutas[0]){
            switch ($rutas[0]) {
                case 'buscador':include "modules/".$rutas[0].".php";break;
                case 'verificar':include "modules/".$rutas[0].".php";break;
                case 'salir':include "modules/".$rutas[0].".php";break;
                case 'perfil':include "modules/".$rutas[0].".php";break;
                case 'mis-datos':include "modules/".$rutas[0].".php";break;
                case 'historial-compra':include "modules/".$rutas[0].".php";break;
                case 'deseos':include "modules/".$rutas[0].".php";break;
                case 'carrito-de-compras':include "modules/".$rutas[0].".php";break;
                case 'error':include "modules/".$rutas[0].".php";break;
                case 'finalizar-compra':include "modules/".$rutas[0].".php";break;
                case 'oferta':include "modules/".$rutas[0].".php";break;
                case 'contacto':include "modules/".$rutas[0].".php";break;
                default:include "modules/error404.php";;break;
            }
        }
    }else{
        include "modules/slide.php";
        include "modules/destacados.php";
    }
    include "modules/footer.php";
    ?>
    <input type="hidden" value="<?=$url?>" id="rutaOculta">
</div>
    <!--JAVASCRIPT PERSONALIZADO-->
    <script src="<?=$url?>view/js/plantilla.js"></script>
    <script src="<?=$url?>view/js/slide.js"></script>
    <script src="<?=$url?>view/js/buscador.js"></script>
    <script src="<?=$url?>view/js/infoproducto.js"></script>
    <script src="<?=$url?>view/js/usuarios.js"></script>
    <script src="<?=$url?>view/js/carritoCompra.js"></script>
    <script src="<?=$url?>view/js/barraNavegacion.js"></script>
    <script src="<?=$url?>view/js/loader.js"></script>
</body>
</html>