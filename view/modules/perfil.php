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
?>

<!--BREADCRUMB PERFIL-->
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

<!--SECCION PERFIL-->
<div class="container">
    <div class="row">
        <div class="links">
            <a href="<?=$url?>mis-datos" class="col-xl-12">
                <span class="link-item">
                    <h4><i class="fas fa-user-circle fa-lg"></i>  Mi Información</h4>
                </span>
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="links">
            <a href="<?=$url?>historial-compra" class="col-xl-12">
                <span class="link-item">
                    <h4><i class="far fa-calendar-minus fa-lg"></i></i>  Historial y Detalles de mis Pedidos</h4>
                </span>
            </a>
        </div>    
    </div>
    <br>
    <div class="row">
        <div class="links">
            <a href="<?=$url?>deseos" class="col-xl-12">
                <span class="link-item">
                    <h4><i class="fas fa-hand-holding-heart fa-lg"></i>  Mi lista de Deseos</h4>
                </span>
            </a>
        </div>
    </div>
</div>



