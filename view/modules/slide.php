<?php
    $slide = ControladorSlide::ctrMostrarSlide();
    $servidor = Ruta::ctrRutaServidor();
?>
<!--SLIDE-->
<?php if($slide!=''){ ?>
<div class="container">
    <div id="carouselExampleIndicators" class="carousel slide shadow-sm" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php 
            $i = 0;
            foreach ($slide as $key => $value) {
                $activo = '';
                if($i==0){
                    $activo = 'active';
                }
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" class="'.$activo.'"></li>';
                $i++;
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php 
            $i = 0;
            foreach ($slide as $key => $value) {
                $activo = '';
                if($i==0){
                    $activo = 'active';
                }
                echo '<div class="carousel-item '.$activo.'"><a href="'.$value['url'].'"><img class="d-block w-100" src="'.$servidor.$value["imgFondo"].'"></a></div>';
                $i++;
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<?php } ?>


